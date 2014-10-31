<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Controlador de los pedidos.
 */

namespace TodoCerdo\TodoCerdoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TodoCerdo\TodoCerdoBundle\Form\DireccionType;
use TodoCerdo\TodoCerdoBundle\Entity\Direccion;
use TodoCerdo\TodoCerdoBundle\Entity\Zona;
use TodoCerdo\TodoCerdoBundle\Entity\Producto;
use TodoCerdo\TodoCerdoBundle\Entity\Detalle;
use TodoCerdo\TodoCerdoBundle\Entity\Localidad;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class PedidoController extends Controller {
    

    public function darUbicacionAction($idUsuario) {
        // El idUsuario trae el idUsuario o puede traer en caso de que no este 
        // un valor null = 0.
        //recupero el idUsuario en el caso del valor null.
        $ObjUsuario = null;
        if ($idUsuario == 0) {

            $usuario = $this->get('security.context')->getToken()->getUser()->getUsername();
            $ObjUsuario = $this->getDoctrine()
                    ->getRepository('TodoCerdoTodoCerdoBundle:Usuario')
                    ->findOneByUsername($usuario);
            if ($ObjUsuario) {
                $idUsuario = $ObjUsuario->getId();
            }
        }

        $direccion = new Direccion();


        

        $request = $this->getRequest();

        //aca persisto la direccion
        if ($request->getMethod() == "POST") {
            $form = $this->createForm(new DireccionType(), $direccion);
            
            $direccion->setUsuario($ObjUsuario); 
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($direccion);
                $em->flush();
            }
        }
        //primero buscar las direcciones del usuario
        $direccion = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Direccion')->findByUsuario($idUsuario);
        $localidad = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Localidad')->findAll();
        //aca tengo que cargar el campo select

        $form = $this->createForm(new DireccionType(), $direccion[0]);

        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:darUbicacion.html.twig', array(
                    'form' => $form->createView(), 'direccion' => $direccion, 'localidad' => $localidad, 'usuario' => $idUsuario));
    }

    public function obtenerBarriosAction() {

        $id = $this->getRequest()->get("id"); //obtiene el id del request

        $em = $this->getDoctrine()->getManager();
        //este no le gusta
        $zonas = $em->getRepository('TodoCerdoTodoCerdoBundle:Zona')
                ->findByLocalidad($id); //devuelve las zonas  por id


        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:selectBarrios.html.twig', array('zonas' => $zonas));
    }

    public function obtenerDireccionAction() {
        //$encoders = array('xml' => new XmlEncoder(), 'json' => new JsonEncoder());
        //$normalizers = array(new GetSetMethodNormalizer());
        //$serializer = new Serializer($normalizers, $encoders);

        $id = $this->getRequest()->get("idDireccion"); //obtiene el id del request
        $repositorio = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Direccion');
        $direccion = $repositorio->findOneById($id);

        $localidadId = $direccion->getLocalidad()->getId();
        $zonaId = $direccion->getZona()->getId();
        //$jsonDireccion = $serializer->serialize($direccion, 'json');

        $localidades = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Localidad')->findAll();
        $zonas = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Zona')->findByLocalidad($localidadId);
        //return new Response($jsonDireccion); 
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:inputCalle.html.twig', array('direccion' => $direccion, 'localidadId' => $localidadId, 'zonaId' => $zonaId, 'localidades' => $localidades,
                    'zonas' => $zonas));
    }
    

    public function addDetalleAction() {
        //agrega un detalle al carrito, si no existe lo crea.
        $session = $this->getRequest()->getSession();

        $cantidad = $this->getRequest()->get("cantidad");
        $productoId = $this->getRequest()->get("productoId");
        
        $repositorio = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Producto');
        
        $producto =  $repositorio->find($productoId);

        $carrito = $session->get('carrito');
        
        $cantidadTotal = $session->get('cantidadTotal');
        
        if (isset($cantidadTotal)) {
            $cantidadTotal = $cantidadTotal + $cantidad;
        } else {
            $cantidadTotal = $cantidad;
        }



        //crea el objeto carrito, que es un arreglo de detalles, 
        if (!(isset($carrito))) {
            $carrito = Array();
        }

        $detalle = new Detalle();
        $detalle->setCantidad($cantidad);
        $detalle->setProducto($producto);

        $subTotal = 0;
        $subTotal = $detalle->calcularSubtotal();
        $precioTotal = $session->get('precioTotal');

        if (isset($precioTotal)) {
            $precioTotal = $subTotal + $precioTotal;
        } else {
            $precioTotal = $subTotal;
        }
        array_push($carrito, $detalle);

        $session->set('cantidadTotal', $cantidadTotal);
        $session->set('precioTotal', $precioTotal);
        $session->set('carrito', $carrito);

        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:subtotalAjax.html.twig', 
                array('cantidadTotal' => $cantidadTotal,
                      'precioTotal' => $precioTotal
                   ));
    }
    public function eliminarDetalleAction(){
        $session = $this->getRequest()->getSession();
        $carrito = $session->get('carrito');
        $elemento = $this->getRequest()->get("elemento");
        
        $precioTotal = $session->get('precioTotal');
        $cantidadTotal = $session->get('cantidadTotal');
        
        $precio = $this->getRequest()->get("subtotal");
        
        unset($carrito[$elemento]);
        $carrito = array_values($carrito);
        
        $precioTotal = $precioTotal - $precio;
        $cantidadTotal = $cantidadTotal -1;
        
        $session->set('precioTotal',$precioTotal);
        $session->set('cantidadTotal',$cantidadTotal);
        $session->set('carrito', $carrito);
        
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:detalleCarritoAjax.html.twig', 
                array('carrito'=> $carrito,
                      'precioTotal'=>$precioTotal));
          
       
        
    }


    
    public function detalleCarritoAction(){
        $session = $this->getRequest()->getSession();
        $carrito = $session->get('carrito');
        
        $precioTotal = $session->get('precioTotal');
        
                
        
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:detalleCarrito.html.twig', 
                array('carrito'=> $carrito,
                      'precioTotal'=>$precioTotal));
    }
    
    
    public function continuarPedidoAction(){
        
        
        $session = $this->getRequest()->getSession();
        
        $direccion = $this->getRequest()->get("direccion");
        
        $session->set("direccionEnvio", $direccion);
        
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:detalleCarritoAjax.html.twig');
    }        

    
}

?>
