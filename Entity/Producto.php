<?php

namespace TodoCerdo\TodoCerdoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * TodoCerdo\TodoCerdoBundle\Entity\Producto
 *
 * @ORM\Table(name="Producto")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */

class Producto
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
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=25, nullable=false)
     */
    protected $nombre;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=200, nullable=true)
     */
    protected $descripcion;

    /**
     * @var decimal $precio
     *
     * @ORM\Column(name="precio", type="decimal", nullable=false)
     */
    protected $precio;

    /**
     * @var text $detalle
     *
     * @ORM\Column(name="detalle", type="text", nullable=true)
     */
    protected $detalle;

    /**
     * @var decimal $pesoAproximado
     *
     * @ORM\Column(name="peso_aproximado", type="decimal", precision=4, scale=3, nullable=false)
     */
    protected $pesoAproximado;

    /**
     * @var "tipoProducto"
     *
     * @ORM\ManyToOne(targetEntity="TipoProducto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoproducto_id", referencedColumnName="id")
     * })
     */
    protected $tipoProducto;

    
    /** 
     * @var "tipoCoccion"
     * 
     * @ORM\ManyToMany(targetEntity="TipoCoccion")
     */
    protected $tipoCocciones;
    
   
    /**
     * @var string $imagen
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    protected $imagen;
    
    
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
        
    
     /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->imagen = uniqid().'.'.$this->file->guessExtension();
        }
    }
    
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does automatically
        $this->file->move($this->getUploadRootDir(), $this->imagen);

        unset($this->file);
    }
    
    
     /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }



    
    
    public function getAbsolutePath()
    {
        return null === $this->imagen ? null : $this->getUploadRootDir().'/'.$this->imagen;
    }

    public function getWebPath()
    {
        return null === $this->imagen ? null : $this->getUploadDir().'/'.$this->imagen;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir().'/';
        
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'imagenes';
    }

    public function __construct()
    {
        $this->tipoCocciones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function __toString() { return $this->nombre; }
    
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
     * Set precio
     *
     * @param decimal $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * Get precio
     *
     * @return decimal 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set detalle
     *
     * @param text $detalle
     */
    public function setDetalle($detalle)
    {
        $this->detalle = $detalle;
    }

    /**
     * Get detalle
     *
     * @return text 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set pesoAproximado
     *
     * @param string $pesoAproximado
     */
    public function setPesoAproximado($pesoAproximado)
    {
        $this->pesoAproximado = $pesoAproximado;
    }

    /**
     * Get pesoAproximado
     *
     * @return string 
     */
    public function getPesoAproximado()
    {
        return $this->pesoAproximado;
    }

    /**
     * Set tipoProducto
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\TipoProducto $tipoProducto
     */
    public function setTipoProducto(\TodoCerdo\TodoCerdoBundle\Entity\TipoProducto $tipoProducto)
    {
        $this->tipoProducto = $tipoProducto;
    }

    /**
     * Get tipoProducto
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\TipoProducto 
     */
    public function getTipoProducto()
    {
        return $this->tipoProducto;
    }

    /**
     * Add tipoCocciones
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\TipoCoccion $tipoCocciones
     */
    public function addTipoCoccion(\TodoCerdo\TodoCerdoBundle\Entity\TipoCoccion $tipoCocciones)
    {
        $this->tipoCocciones[] = $tipoCocciones;
    }

    /**
     * Get tipoCocciones
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getTipoCocciones()
    {
        return $this->tipoCocciones;
    }
    
    
    /**
     * Set imagen
     *
     * @param string $imagen
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }
    
    public function calcularPrecio(){
        
        return number_format($this->precio * $this->pesoAproximado,2,',','.'); 
    }
}