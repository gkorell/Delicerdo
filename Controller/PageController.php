<?php
// src/TodoCerdo/TodoCerdoBundle/Controller/PageController.php

namespace TodoCerdo\TodoCerdoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Importa el nuevo espacio de nombres
use TodoCerdo\TodoCerdoBundle\Entity\Contacto;
use TodoCerdo\TodoCerdoBundle\Form\ContactoType;

class PageController extends Controller
{
    public function indexAction()
    {
        
        return $this->render('TodoCerdoTodoCerdoBundle:Page:index.html.twig');
    }
    
    
    //La funcion aboutAction controla la pagina sobre(acerca de) 	
    public function aboutAction()
    {
        return $this->render('TodoCerdoTodoCerdoBundle:Page:about.html.twig');
    } 
    
    //La funcion contactAction controla el formulario contacto para enviar emails al administrador del sitio
    public function contactAction()
    {    //Cargo el formulario
        $contacto = new Contacto();
        $form = $this->createForm(new ContactoType(), $contacto);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
               $form->bind($request);

           if ($form->isValid()) {
            
            $message = \Swift_Message::newInstance()
                    ->setSubject('Consulta de contacto de todocerdodigital.com')
                    ->setFrom('guillermo.korell@gmail.com')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                    ->setBody($this->renderView('TodoCerdoTodoCerdoBundle:Page:contactEmail.txt.twig', array('contacto' => $contacto)));
               $this->get('mailer')->send($message);

               $this->get('session')->getFlashBag()->add('message-notice', 'Su consulta ha sido enviada satisfactoriamente. Gracias!');

            // Redirect - This is important to prevent users re-posting
            // the form if they refresh the page
            // realiza alguna acción, como enviar un correo electrónico

            // Redirige - Esto es importante para prevenir que el usuario reenvíe
            // el formulario si actualiza la página
            return $this->redirect($this->generateUrl('TodoCerdoTodoCerdoBundle_contact'));
           }
        }
        return $this->render('TodoCerdoTodoCerdoBundle:Page:contact.html.twig', array('form' => $form->createView()));
    }
    public function faqAction()
    {
        return $this->render('TodoCerdoTodoCerdoBundle:Page:faq.html.twig');
    }
    
    public function sidebarAction()
    {
        $session = $this->getRequest()->getSession();
        $precioTotal = $session->get('precioTotal');
        $cantidadTotal = $session->get('cantidadTotal');
        
        //si tiene elementos en el carro renderiza el link, sino un texto
        if($cantidadTotal!=0){
            $contenido_boton = 'Finalizar Compra';
            $href_boton = 'TodoCerdoTodoCerdoBundle_detalleCarrito';
            
        }else{
            $contenido_boton = 'Tu carrito esta vacio';
            $href_boton = '';
        }
         return $this->render('TodoCerdoTodoCerdoBundle:Page:sidebar.html.twig', 
                array('cantidadTotal' => $cantidadTotal,
                      'precioTotal' => $precioTotal,
                    'contenidoBoton' => $contenido_boton,
                    'hrefBoton' => $href_boton
                   ));
    }
    
    public function unauthorizedAction(){
        $session = $this->get('session');
        $usuario = $this->get('security.context')->getToken()->getUser()->getUsername();
        $session->getFlashBag()->add('error', 'El usuario "'.$usuario. '" no está autorizado para acceder a este sitio');
        
        return $this->render('TodoCerdoTodoCerdoBundle:Page:accessDenied.html.twig');
    }
 }
?>
