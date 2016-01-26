<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
// src/TodoCerdo/TodoCerdoBundle/Form/PedidoType.php
/*Clase clase que maneja el formulario de darUbicacion de los pedidos.
 *Solamente datos de "Direccion".
 * El submit de este formulario agrega direccion en la tabla direccion..
 */
namespace TodoCerdo\TodoCerdoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;



class DireccionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        /* Aca me pide ubicación pero no existe ninguna ubicacion en la entidad 
         * "Direccion.php".
         * Lo mismo ocurre con ciudad.
         */
        
        $builder->add('Localidad','entity',array('class'=>'TodoCerdoTodoCerdoBundle:Localidad'));
        $builder->add('Zona','entity',array('class'=>'TodoCerdoTodoCerdoBundle:Zona'));
        $builder->add('Calle', 'text');
        $builder->add('Altura', 'text');
        $builder->add('Piso', 'text');
        $builder->add('Departamento', 'text');
        $builder->add('Nombre','text');
        
        
        
    }

  

    public function getName() {
        return 'direccion';
    }
}

?>
