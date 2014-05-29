<?php
// src/TodoCerdo/TodoCerdoBundle/Controller/ProductoController.php

namespace TodoCerdo\TodoCerdoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TodoCerdo\TodoCerdoBundle\Form\ProductoType;
use TodoCerdo\TodoCerdoBundle\Entity\Producto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class ProductoController extends Controller
{
    public function listAction($idTipo)
    {
        //$em = $this->getDoctrine()->getManager();
        $productos = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:Producto')
                ->findByTipoProducto($idTipo);
                
        $tipo = $this->getDoctrine()->getRepository('TodoCerdoTodoCerdoBundle:TipoProducto')->find($idTipo);
        

        return $this->render('TodoCerdoTodoCerdoBundle:Producto:list.html.twig',array('productos'=>$productos,'tipoProducto'=>$tipo));
    }
    
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tipoProductos = $em->getRepository('TodoCerdoTodoCerdoBundle:TipoProducto')->findAll();
        
        return $this->render('TodoCerdoTodoCerdoBundle:Producto:index.html.twig',array('tipoProductos'=>$tipoProductos));
    }
    
    
    public function newAction()
    {
        $producto = new Producto();
        $form = $this->createForm(new ProductoType, $producto);
        
        $request = $this->getRequest();
        
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($producto);
                $em->flush();

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('TodoCerdoTodoCerdoBundle_productos'));
            }
        }
        
        return $this->render('TodoCerdoTodoCerdoBundle:Producto:nuevoProducto.html.twig', array(
            'form' => $form->createView()));


    }
    
    //renderiza el formulario de editar producto y llama a update
    public function editarAction($idProducto){
                
        $em = $this->getDoctrine()->getManager();
        $producto_modif = $em->getRepository('TodoCerdoTodoCerdoBundle:Producto')->find($idProducto);
        
        
        if (!$producto_modif) {
            throw $this->createNotFoundException('El producto no existe');
        
        }
        
        $editForm = $this->createForm(new ProductoType(), $producto_modif);
        $deleteForm = $this->createDeleteForm($idProducto);
        

        return $this->render('TodoCerdoTodoCerdoBundle:Producto:editarProducto.html.twig', array(
            'producto'      => $producto_modif,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
        
        
    }
    
    //realiza el update del producto en la base de datos, hace la accion de editar
    public function updateAction($idProducto)
    {
        $em = $this->getDoctrine()->getManager();

        $producto = $em->getRepository('TodoCerdoTodoCerdoBundle:Producto')->find($idProducto);

        if (!$producto) {
            throw $this->createNotFoundException('No es posible encontrar la receta.');
        }
        
        
       
        $editForm   = $this->createForm(new ProductoType(), $producto);
        $deleteForm = $this->createDeleteForm($idProducto);

        //$request = $this->getRequest();

        $request = Request::createFromGlobals();
        if ($request->getMethod() == 'POST') {
            
            $editForm->bind($request);
        
            $valido=false;
            $valido=$editForm->isValid();
            if ($valido) {
                $em->persist($producto);
                $em->flush();

                //return $this->redirect($this->generateUrl('TodoCerdoTodoCerdoBundle_editarproducto', array('idProducto' => $idProducto)));
                return $this->redirect($this->generateUrl('TodoCerdoTodoCerdoBundle_productos'));
            }
        }

        return $this->render('TodoCerdoTodoCerdoBundle:Producto:editarProducto.html.twig', array(
            'producto'      => $producto,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
    public function deleteAction($idProducto)
    {   
        
        $form = $this->createDeleteForm($idProducto);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TodoCerdoTodoCerdoBundle:Producto')->find($idProducto);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Receta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }
//lslslsslsl
        return $this->redirect($this->generateUrl('TodoCerdoTodoCerdoBundle_productos'));
    }
    
    public function descripcionAction(){// a este método lo llama en list.html.twig
      
            $id=$this->getRequest()->get("id");//obtiene el id del request
        
            $em = $this->getDoctrine()->getManager();
            $producto = $em->getRepository('TodoCerdoTodoCerdoBundle:Producto')->find($id);//devuelve un producto por id
            
            $descripcion=$producto->getDescripcion();
            $detalle = $producto->getDetalle();
            
            return $this->render('TodoCerdoTodoCerdoBundle:Producto:descripcion_ajax.html.twig', array(
            'descripcion' => $descripcion,'detalle'=>$detalle));
        
  }
       
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

?>
