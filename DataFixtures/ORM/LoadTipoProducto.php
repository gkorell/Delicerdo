<?php

/*
 * Carga los tipos de productos. 
 */

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace TodoCerdo\TodoCerdoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TodoCerdo\TodoCerdoBundle\Entity\TipoProducto;

class LoadTipoProducto implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $TipoProducto1 = new TipoProducto();
        $TipoProducto1->setNombre('Cortes');
        
        
        $TipoProducto2 = new TipoProducto();
        $TipoProducto2->setNombre('Embutidos');
        

        $TipoProducto3 = new TipoProducto();
        $TipoProducto3->setNombre('Packs');
        


        $manager->persist($TipoProducto1);
        $manager->persist($TipoProducto2);
        $manager->persist($TipoProducto3);
        $manager->flush();
    }
}
