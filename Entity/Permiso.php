<?php

namespace TodoCerdo\TodoCerdoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TodoCerdo\TodoCerdoBundle\Entity\Permiso
 *
 * @ORM\Table(name="Permiso")
 * @ORM\Entity
 */
class Permiso
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected  $id;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=30, nullable=false)
     */
    protected  $descripcion;

    /**
     * @var "perfil"
     *
     * @ORM\ManyToOne(targetEntity="perfil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perfil_id", referencedColumnName="id")
     * })
     */
    protected  $perfil;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set perfil
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\perfil $perfil
     */
    public function setPerfil(\TodoCerdo\TodoCerdoBundle\Entity\perfil $perfil)
    {
        $this->perfil = $perfil;
    }

    /**
     * Get perfil
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\perfil 
     */
    public function getPerfil()
    {
        return $this->perfil;
    }
}