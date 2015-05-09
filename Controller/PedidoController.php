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
use TodoCerdo\TodoCerdoBundle\Form\PedidoType;
use TodoCerdo\TodoCerdoBundle\Entity\Direccion;
use TodoCerdo\TodoCerdoBundle\Entity\Zona;
use TodoCerdo\TodoCerdoBundle\Entity\Producto;
use TodoCerdo\TodoCerdoBundle\Entity\Detalle;
use TodoCerdo\TodoCerdoBundle\Entity\Localidad;
use TodoCerdo\TodoCerdoBundle\Entity\Pedido;
use TodoCerdo\TodoCerdoBundle\Entity\Estado;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class PedidoController extends Controller {
    
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
        
        $contenido_boton = 'Finalizar Compra';
        $href_boton = 'href="{{ path("TodoCerdoTodoCerdoBundle_detalleCarrito") }}"';

        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:subtotalAjax.html.twig', 
                array('cantidadTotal' => $cantidadTotal,
                      'precioTotal' => $precioTotal,
                    'contenidoBoton' => $contenido_boton,
                    'hrefBoton' => $href_boton
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

    //va a ver el carrito con el listado de los productos seleccionados para compra
    public function detalleCarritoAction(){
        $session = $this->getRequest()->getSession();
        $carrito = $session->get('carrito');
        
        $precioTotal = $session->get('precioTotal');
        
                
        
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:detalleCarrito.html.twig', 
                array('carrito'=> $carrito,
                      'precioTotal'=>$precioTotal));
    }

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
                
        //primero buscar las direcciones del usuario
        $direccion = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Direccion')->findByUsuario($idUsuario);
        $localidad = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Localidad')->findAll();
        //aca tengo que cargar el campo select

        $form = $this->createForm(new DireccionType(), $direccion[0]);

        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:darUbicacion.html.twig', array(
                    'form' => $form->createView(), 'direccion' => $direccion, 'localidad' => $localidad, 'usuario' => $idUsuario));
    }
    
    
    //carga la vista inicial del formulario de alta de direccion
    public function agregarDireccionAction($idUsuario){
        
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
        
          
        //cargo el arreglo de localidades para el select
        $localidad = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Localidad')->findAll();
        //aca tengo que cargar el campo select

        $form = $this->createForm(new DireccionType());
        
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:agregarDireccion.html.twig', array(
                    'form' => $form->createView(), 'direccion' => $direccion, 'localidad' => $localidad, 'usuario' => $idUsuario));
        
    }
    
    
    //persiste la direccion y devuelve las partes de la vista para actualizar por ajax
    public function agregarDirAjaxAction($idUsuario){
        
        $request = $this->getRequest();

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
         
        //aca persisto la direccion
        if ($request->getMethod() == "POST") {
            $form = $this->createForm(new DireccionType(), $direccion);
            
            $direccion->setUsuario($ObjUsuario); 
            $form->bind($request); //cambiar por handle
            
            $esvalido = $form->isValid();
            if ($esvalido) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($direccion);
                $em->flush();
                $id=$direccion->getId();
            }
        }
        
        $direcciones = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Direccion')->findByUsuario($idUsuario);
        $arreglo_form = $this->actualizaFormDireccion($id);
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:darUbicacionAjax.html.twig',$direcciones, $arreglo_form);
        
    }
    
 

    public function obtenerBarriosAction() {

        $id = $this->getRequest()->get("id"); //obtiene el id del request

        $em = $this->getDoctrine()->getManager();
        //este no le gusta
        $zonas = $em->getRepository('TodoCerdoTodoCerdoBundle:Zona')
                ->findByLocalidad($id); //devuelve las zonas  por id


        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:selectBarrios.html.twig', array('zonas' => $zonas));
    }
    
    
     private function actualizaFormDireccion($id){
        
        $repositorio = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Direccion');
        $direccion = $repositorio->findOneById($id);

        $localidadId = $direccion->getLocalidad()->getId();
        $zonaId = $direccion->getZona()->getId();
        //$jsonDireccion = $serializer->serialize($direccion, 'json');

        $localidades = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Localidad')->findAll();
        $zonas = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Zona')->findByLocalidad($localidadId);
        
        $arreglo=array('direccion' => $direccion, 'localidadId' => $localidadId, 'zonaId' => $zonaId, 'localidades' => $localidades,'zonas' => $zonas);
        
        return $arreglo;
    }

    public function obtenerDireccionAction() {
        //$encoders = array('xml' => new XmlEncoder(), 'json' => new JsonEncoder());
        //$normalizers = array(new GetSetMethodNormalizer());
        //$serializer = new Serializer($normalizers, $encoders);

        $id = $this->getRequest()->get("idDireccion"); //obtiene el id del request
        
        $arreglo = $this->actualizaFormDireccion($id);
               
        //$repositorio = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Direccion');
        //$direccion = $repositorio->findOneById($id);

        //$localidadId = $direccion->getLocalidad()->getId();
        //$zonaId = $direccion->getZona()->getId();
        //$jsonDireccion = $serializer->serialize($direccion, 'json');

        //$localidades = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Localidad')->findAll();
        //$zonas = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Zona')->findByLocalidad($localidadId);
        //return new Response($jsonDireccion); 
        //return $this->render('TodoCerdoTodoCerdoBundle:Pedido:inputCalle.html.twig', array('direccion' => $direccion, 'localidadId' => $localidadId, 'zonaId' => $zonaId, 'localidades' => $localidades, 'zonas' => $zonas));
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:inputCalle.html.twig', $arreglo);
    }
    
    
    public function continuarPedidoAction(){
        
        
        $session = $this->getRequest()->getSession();
        $pedido = new Pedido();
        $direccion = new Direccion();
        
        $direccion = $this->getRequest()->get("direccion");
        
        $session->set("direccionEnvio", $direccion);
        
        try{
            $form = $this->createForm(new PedidoType($pedido));
        } catch (\Exception $e){
            throwException($e);
        }
        
        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:confirmarPedido.html.twig', array('form' => $form->createView()));
        
    }
    
    
    public function finalizarPedidoAction(){
        
        //Obtengo el usuario
        $usuario = $this->get('security.context')->getToken()->getUser()->getUsername();
        $ObjUsuario = $this->getDoctrine()
            ->getRepository('TodoCerdoTodoCerdoBundle:Usuario')
            ->findOneByUsername($usuario);
        
        $pedido = new Pedido();
        $request = $this->getRequest();
        
        if ($request->getMethod() == "POST") {
                        
            //Obtengo la direccion seleccionada desde la base de datos
            $session = $this->getRequest()->getSession();
            $direccion = $session->get('direccionEnvio');
            $direccionEnvio = new Direccion();
            $direccionEnvio = $this->getDoctrine()
            ->getRepository('TodoCerdoTodoCerdoBundle:Direccion')
            ->findOneByNombre($direccion['Nombre']);
            
            //Obtengo el objeto estado
            $estado = new Estado();
            $estado = $this->getDoctrine()
            ->getRepository('TodoCerdoTodoCerdoBundle:Estado')
            ->findOneByNombre('Nuevo');
            
                      
            $form = $this->createForm(new PedidoType(),$pedido);
            $form->handleRequest($request);
            
            $pedido->setUsuario($ObjUsuario);
            $pedido->setDireccion($direccionEnvio);
            $pedido->setEstado($estado);
            
            $fecha = new \DateTime();
            
            $pedido->setFecha($fecha);
            //lleno el objeto pedido con los datos del form a mano porque no se como se hace
            //$pedido->setFechaEntrega( $form->get('fechaEntrega'));
            //$pedido->setHorarioTentativo($form->get('horarioTentativo'));
            //$pedido->setMedioConfirmacion($form->get('modoConfirma'));
            //$pedido->setPagaCon($form->get('pagaCon'));
            
            
            $em = $this->getDoctrine()->getManager();
            $em->getConnection()->beginTransaction();
            $idPedido=null;
            $enviado = 'NO';
            
            try{
                
                $esvalido = $form->isValid();
                if ($esvalido) {

                    $em->persist($pedido);
                    $em->flush();
                    $idPedido=$pedido->getId();
                }

                if($idPedido!=null){

                    $carrito = $session->get('carrito');
                    $cant = $session->get('cantidadTotal');


                    for($i=0;$i<$cant;$i++){

                        $detalle = new Detalle();
                        $producto = new Producto();
                        $idproducto = $carrito[$i]->getProducto()->getId();
                        
                        $producto = $em->getRepository('TodoCerdoTodoCerdoBundle:Producto')->find($idproducto);
                        
                        $cantidad = $carrito[$i]->getCantidad();
                        
                        $detalle->setProducto($producto);
                        $detalle->setCantidad($cantidad);
                        $detalle->setPedido($pedido);
                        $em->persist($detalle);


                    }

                    $em->flush();
                    $em->getConnection()->commit();
                    $enviado = 'OK';

                }
                
                
                
                
            } catch (Exception $ex) {
                $em->getConnection()->rollback();
                $enviado = 'NO';
                throw $ex;
            }
            
        }//end if post
        
        if($enviado == 'OK'){
            $mensage = "Su pedido ha sido procesado con &eacute;xito";
            $session->remove($carrito);
            $session->remove($cantidadTotal);
            $session->remove($direccionEnvio);
            $session->remove($precioTotal);
            
        }else{
            $mensage = "Ocurri&oacute; un error al procesar el pedido. Por favor intente nuevamente";
        }
        
        Return $this->render('TodoCerdoTodoCerdoBundle:Pedido:pedidoFinalizado.html.twig',array('mensaje'=>$mensaje));
        
    }//end action
    
    
    public function listarPedidosAction(){
        
        $request = $this->getRequest();
        $orden=null;
        $direction=null;
        
        if ($request->getMethod() == "GET") {
            $orden=$request->get('sort');
            $direction=$request->get('direction');
            
        }
            
        if($orden==null){
            $orden='p.id';
        }
            
        if($direction==null){
            $direction='ASC';
        }
        
        
        $em = $this->getDoctrine()->getEntityManager();
        $dql = 'SELECT p, e FROM TodoCerdoTodoCerdoBundle:Pedido p JOIN p.estado e WHERE e.id=:id ORDER BY '.$orden.' '.$direction.'';
        $query = $em->createQuery($dql)->setParameter('id', 1); //parametro de estado
        
        //$query = $em->createQuery('SELECT p, e FROM TodoCerdoTodoCerdoBundle:Pedido p JOIN p.estado e WHERE e.id=:id ORDER BY p.fecha DESC')->setParameter('id', 1);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
        $query,
        $this->getRequest()->query->get('page', 1), 5);
        

    return $this->render(
        'TodoCerdoTodoCerdoBundle:Pedido:listaPedidos.html.twig', compact('pagination'));
    }

    
    
    public function editarPedidoAction(){
     
        $request = $this->getRequest();
        $idPedido=null;
        $pedido = null;
        
        if ($request->getMethod() == "GET") {
            $idPedido=$request->get('id');
            
            $em = $this->getDoctrine()->getManager();
            
            $pedido = $em->getRepository('TodoCerdoTodoCerdoBundle:Pedido')->find($idPedido);
            
            if(!$pedido ){
                
                throw $this->createNotFoundException('El pedido no existe');
                
            }else{
            
                $editForm = $this->createForm(new PedidoType(), $pedido);
                //$deleteForm = $this->createDeleteForm($idProducto);
            }

        return $this->render('TodoCerdoTodoCerdoBundle:Pedido:editarPedidoAjax.html.twig', array(
            'pedido'      => $pedido,
            'edit_form'   => $editForm->createView(),
            ));
        }
        
    }
    
}//end controller

?>
