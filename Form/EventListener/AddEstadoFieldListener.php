<?php

namespace TodoCerdo\TodoCerdoBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddEstadoFieldListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(FormEvents::PRE_SET_DATA => 'onPreSetData');
    }
    
    public function onPreSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        //$id = $data->getId();

        if (null !== $data->getId()) {
            
            //$form->add('Direccion','hidden',array('data_class'=>'TodoCerdo\TodoCerdoBundle\Entity\Direccion'));
            $form->add('Estado','entity',array('label'=>'Estado del Pedido','class'=>'TodoCerdoTodoCerdoBundle:Estado'));
            //$form->add('Estado', 'text');
            //$form->add('Usuario','hidden',array('data_class'=>'TodoCerdo\TodoCerdoBundle\Entity\Usuario'));
            
        }
    }
    
}
