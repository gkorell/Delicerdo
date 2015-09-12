<?php

namespace TodoCerdo\TodoCerdoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * TodoCerdo\TodoCerdoBundle\Entity\Receta
 *
 * @ORM\Table(name="Receta")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Receta
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
     * @var string $titulo
     *
     * @ORM\Column(name="titulo", type="string", length=30, nullable=false)
     */
    protected  $titulo;

    /**
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=true)
     */
    protected  $descripcion;
    
      /**
     * @var string $autor
     *
     * @ORM\Column(name="autor", type="string", length=50, nullable=true)
     */
    protected  $autor;

    /**
     * @var text $detalle
     *
     * @ORM\Column(name="detalle", type="text", nullable=true)
     */
    protected  $detalle;

    /**
     * @var "tipococcion_id"
     *
     * @ORM\ManyToOne(targetEntity="TipoCoccion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipococcion_id", referencedColumnName="id")
     * })
     */
    protected  $tipococcion_id;
    
    /**
     * @var "producto_id"
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * })
     */
    protected  $producto_id;



    /**
     * @var string $imagen
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    protected  $imagen;
    
    
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
     * Set titulo
     *
     * @param string $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
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
     * Set autor
     *
     * @param string $autor
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
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
     * Set tipococcion
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\TipoCoccion $tipococcion
     */
    public function setTipococcionId(\TodoCerdo\TodoCerdoBundle\Entity\tipococcion $tipococcion)
    {
        $this->tipococcion_id = $tipococcion;
    }

    /**
     * Get tipococcion
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\TipoCoccion 
     */
    public function getTipococcionId()
    {
        return $this->tipococcion_id;
    }
    

    /**
     * Set producto_id
     *
     * @param TodoCerdo\TodoCerdoBundle\Entity\Producto $productoId
     */
    public function setProductoId(\TodoCerdo\TodoCerdoBundle\Entity\Producto $productoId)
    {
        $this->producto_id = $productoId;
    }

    /**
     * Get producto_id
     *
     * @return TodoCerdo\TodoCerdoBundle\Entity\Producto 
     */
    public function getProductoId()
    {
        return $this->producto_id;
    }
}