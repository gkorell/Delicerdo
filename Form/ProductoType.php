<?php
namespace TodoCerdo\TodoCerdoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProductoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nombre','text',array('label'=>'Nombre'));
        $builder->add('descripcion','text',array('label'=>'Descripción'));
        $builder->add('precio','text',array('label'=>'Precio'));
        $builder->add('detalle','textarea',array('label'=>'Detalle'));
        $builder->add('pesoAproximado','number',array('label'=>'Peso aproximado'));
        $builder->add('tipoProducto','entity',array('label'=>'Tipo de Producto','class'=>'TodoCerdoTodoCerdoBundle:TipoProducto'));
        $builder->add('tipoCocciones','entity',array('label'=>'Tipo de Cocciones','class'=>'TodoCerdoTodoCerdoBundle:TipoCoccion','multiple'=>true, 'expanded'=>true));
        $builder->add('file','file',  array('label'=>'Imagen'));
        
   
    }
    
    public function getName()
    {
        return 'producto';
    }
}
?>