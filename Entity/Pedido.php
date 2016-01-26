<?php

namespace TodoCerdo\TodoCerdoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TodoCerdo\TodoCerdoBundle\Entity\Detalle;
use TodoCerdo\TodoCerdoBundle\Entity\Estado;


/**
 * TodoCerdo\TodoCerdoBundle\Entity\Pedido
 *
 * @ORM\Table(name="Pedido")
 * @ORM\Entity
 */
class Pedido
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
     * @var datetime $fechaEntrega
     *
     * @ORM\Column(name="fecha_entrega", type="date", nullable=true)
     */
    protected $fechaEntrega;

    /**
     * @var string $horarioTentativo
     *
     * @ORM\Column(name="horario_tentativo", type="string", length=30, nullable=true)
     */
    protected $horarioTentativo;

    /**
     * @var boolean $confirmarPrecio
     *
     * @ORM\Column(name="confirmar_precio", type="boolean", nullable=true)
     */
    protected $confirmarPrecio;

    /**
     * @var integer $medioConfirmacion
     *
     * @ORM\Column(name="medio_confirmacion", type="integer", nullable=true)
     */
    protected $medioConfirmacion;

    /**
     * @var decimal $pagaCon
     *
     * @ORM\Column(name="paga_con", type="decimal", nullable=true)
     */
    protected $pagaCon;

    /**
     * @var datetime $fecha
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    protected $fecha;
    
    
    /**
     * @var float $precioTotal;
     *
     * @ORM\Column(name="precio_total", type="float", nullable=true)
     */
    protected $precioTotal;

    
    /**
     * @var "estado"
     *
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
     * })
     */
    protected $estado;

    /**
     * @var "usuario"
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    protected $usuario;
    
    
    /**
     * @var "direccion"
     * 
     * @ORM\ManyToOne(targetEntity="Direccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="direccion_id", referencedColumnName="id")
     * })
     */
    protected $direccion;

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
     * Set fechaEntrega
     *
     * @param datetime $fechaEntrega
     */
    public function setFechaEntrega($fechaEntrega)
    {
        $this->fechaEntrega = $fechaEntrega;
    }

    /**
     * Get fechaEntrega
     *
     * @return datetime 
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }
    
    
    /**
     * Set fechaEntrega
     *
     * @param datetime $fechaEntrega
     */
    public function setPrecioTotal($precioTotal)
    {
        $this->precioTotal = $precioTotal;
    }

    /**
     * Get precioTotal
     *
     * @return float 
     */
    public function getPrecioTotal()
    {
        return $this->precioTotal;
    }
    
    

    /**
     * Set horarioTentativo
     *
     * @param string $horarioTentativo
     */
    public function setHorarioTentativo($horarioTentativo)
    {
        $this->horarioTentativo = $horarioTentativo;
    }

    /**
     * Get horarioTentativo
     *
     * @return string 
     */
    public function getHorarioTentativo()
    {
        return $this->horarioTentativo;
    }

    /**
     * Set confirmarPrecio
     *
     * @param boolean $confirmarPrecio
     */
    public function setConfirmarPrecio($confirmarPrecio)
    {
        $this->confirmarPrecio = $confirmarPrecio;
    }

    /**
     * Get confirmarPrecio
     *
     * @return boolean 
     */
    public function getConfirmarPrecio()
    {
        return $this->confirmarPrecio;
    }

    /**
     * Set medioConfirmacion
     *
     * @param integer $medioConfirmacion
     */
    public function setMedioConfirmacion($medioConfirmacion)
    {
        $this->medioConfirmacion = $medioConfirmacion;
    }

    /**
     * Get medioConfirmacion
     *
     * @return integer 
     */
    public function getMedioConfirmacion()
    {
        return $this->medioConfirmacion;
    }

    /**
     * Set pagaCon
     *
     * @param decimal $pagaCon
     */
    public function setPagaCon($pagaCon)
    {
        $this->pagaCon = $pagaCon;
    }

    /**
     * Get pagaCon
     *
     * @return decimal 
     */
    public function getPagaCon()
    {
        return $this->pagaCon;
    }

    /**
     * Set fecha
     *
     * @param datetime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return datetime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set estado
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\Estado $estado
     */
    public function setEstado(\TodoCerdo\TodoCerdoBundle\Entity\Estado $estado)
    {
        $this->estado = $estado;
    }

    /**
     * Get estado
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\Estado 
     */
    public function getEstado()
    {
        return $this->estado;
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
     * Set direccion
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\Direccion $direccion
     */
    public function setDireccion(\TodoCerdo\TodoCerdoBundle\Entity\Direccion $direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * Get direccion
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\Direccion 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
    
}