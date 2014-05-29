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
                    ->setFrom('enquiries@symblog.co.uk')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
                    ->setBody($this->renderView('TodoCerdoTodoCerdoBundle:Page:contactEmail.txt.twig', array('contacto' => $contacto)));
               $this->get('mailer')->send($message);

               $this->get('session')->setFlash('blogger-notice', 'Su consulta ha sido enviada satisfactoriamente. Gracias!');

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
         return $this->render('TodoCerdoTodoCerdoBundle:Page:sidebar.html.twig', 
                array('cantidadTotal' => $cantidadTotal,
                      'precioTotal' => $precioTotal
                   ));
    }
 }
?>
