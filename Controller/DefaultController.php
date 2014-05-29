<?php

namespace TodoCerdo\TodoCerdoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('TodoCerdoTodoCerdoBundle:Default:index.html.twig', array('name' => $name));
    }
}
