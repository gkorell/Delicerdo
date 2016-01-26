<?php

namespace TodoCerdo\TodoCerdoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TodoCerdo\TodoCerdoBundle\Entity\Direccion
 *
 * @ORM\Table(name="Direccion")
 * @ORM\Entity
 */
class Direccion
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string $calle
     *
     * @ORM\Column(name="calle", type="string", length=30, nullable=false)
     */
    protected  $calle;

    /**
     * @var string $altura
     *
     * @ORM\Column(name="altura", type="string", length=10, nullable=false)
     */
    protected  $altura;

    /**
     * @var integer $piso
     *
     * @ORM\Column(name="piso", type="integer", nullable=false)
     */
    protected  $piso;

    /**
     * @var string $departamento
     *
     * @ORM\Column(name="departamento", type="string", length=3, nullable=false)
     */
    protected  $departamento;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=15, nullable=false)
     */
    protected  $nombre;

    /**
     * @var "zona"
     *
     * @ORM\ManyToOne(targetEntity="Zona")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zona_id", referencedColumnName="id")
     * })
     */
    protected  $zona;

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
     * @var "usuario"
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    protected  $usuario;



    

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
     * Set calle
     *
     * @param string $calle
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set altura
     *
     * @param string $altura
     */
    public function setAltura($altura)
    {
        $this->altura = $altura;
    }

    /**
     * Get altura
     *
     * @return string 
     */
    public function getAltura()
    {
        return $this->altura;
    }

    /**
     * Set piso
     *
     * @param integer $piso
     */
    public function setPiso($piso)
    {
        $this->piso = $piso;
    }

    /**
     * Get piso
     *
     * @return integer 
     */
    public function getPiso()
    {
        return $this->piso;
    }

    /**
     * Set departamento
     *
     * @param string $departamento
     */
    public function setDepartamento($departamento)
    {
        $this->departamento = $departamento;
    }

    /**
     * Get departamento
     *
     * @return string 
     */
    public function getDepartamento()
    {
        return $this->departamento;
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
     * Set zona
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\Zona $zona
     */
    public function setZona(\TodoCerdo\TodoCerdoBundle\Entity\Zona $zona)
    {
        $this->zona = $zona;
    }

    /**
     * Get zona
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\Zona
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set usuario
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\TodoCerdo\TodoCerdoBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    /**
     * Set localidad
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\Localidad $localidad
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