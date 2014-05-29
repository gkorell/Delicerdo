<?php

/*
 * Carga los tipos de Coccion. 
 */

// src/Acme/HelloBundle/DataFixtures/ORM/LoadUserData.php

namespace TodoCerdo\TodoCerdoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use TodoCerdo\TodoCerdoBundle\Entity\TipoCoccion;

class LoadTipoCoccion implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $TipoCoccion1 = new TipoCoccion();
        $TipoCoccion1->setNombre('Horneado');
        
        $TipoCoccion2 = new TipoCoccion();
        $TipoCoccion2->setNombre('Parrilla/Grillado');
        
        $TipoCoccion3 = new TipoCoccion();
        $TipoCoccion3->setNombre('Sartenaeado');
        
        $TipoCoccion4 = new TipoCoccion();
        $TipoCoccion4->setNombre('Guisado');
        

        $manager->persist($TipoCoccion1);
        $manager->persist($TipoCoccion2);
        $manager->persist($TipoCoccion3);
        $manager->persist($TipoCoccion4);
        
        
        $manager->flush();
    }
}
