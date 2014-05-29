<?php

namespace TodoCerdo\TodoCerdoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TodoCerdo\TodoCerdoBundle\Entity\Zona
 *
 * @ORM\Table(name="Zona")
 * @ORM\Entity
 */
class Zona
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
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=40, nullable=false)
     */
    protected  $nombre;

    /**
     * @var decimal $costoEnvio
     *
     * @ORM\Column(name="costo_envio", type="decimal", nullable=false)
     */
    protected  $costoEnvio;

    /**
     * @var "localidad"
     *
     * @ORM\ManyToOne(targetEntity="Localidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     * })
     */
    protected  $localidad;


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
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set costoEnvio
     *
     * @param decimal $costoEnvio
     */
    public function setCostoEnvio($costoEnvio)
    {
        $this->costoEnvio = $costoEnvio;
    }

    /**
     * Get costoEnvio
     *
     * @return decimal 
     */
    public function getCostoEnvio()
    {
        return $this->costoEnvio;
    }

    /**
     * Set localidad
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\localidad $localidad
     */
    public function setLocalidad(\TodoCerdo\TodoCerdoBundle\Entity\Localidad $localidad)
    {
        $this->localidad = $localidad;
    }

    /**
     * Get localidad
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\Localidad 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
        public function __toString() { return $this->nombre; }
}