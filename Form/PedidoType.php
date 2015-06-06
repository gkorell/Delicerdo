<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace TodoCerdo\TodoCerdoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use TodoCerdo\TodoCerdoBundle\Form;
use TodoCerdo\TodoCerdoBundle\Form\EventListener\AddEstadoFieldListener;



class PedidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        /* Aca me pide ubicación pero no existe ninguna ubicacion en la entidad 
         * "Direccion.php".
         * Lo mismo ocurre con ciudad.
         */
        
        $builder->add('Direccion','hidden',array('data_class'=>'TodoCerdo\TodoCerdoBundle\Entity\Direccion'));
        $builder->add('Estado','hidden',array('data_class'=>'TodoCerdo\TodoCerdoBundle\Entity\Estado'));
        $builder->add('Usuario','hidden',array('data_class'=>'TodoCerdo\TodoCerdoBundle\Entity\Usuario'));
        $builder->add('fechaEntrega','date',array('widget'=>'single_text','format' => 'dd-MM-yyyy', 'attr' => array('class' => 'date')));
        $builder->add('horarioTentativo','text');
        $builder->add('confirmarPrecio', 'checkbox', array('label'=>'Confirmar Precio','required'=>false));
        $builder->add('medioConfirmacion', 'choice', array('choices' => array('email' => 'Email', 'mensaje' => 'Mensaje de Texto'),'disabled'=>'true'));
        $builder->add('pagaCon', 'money');
        $builder->add('save', 'submit', array('label' => 'Confirmar Pedido'));
        //$builder->addEventSubscriber(new AddEstadoFieldListener());
        
        
        
        
    }

  

    public function getName() {
        return 'confirmarPedido';
    }
}
