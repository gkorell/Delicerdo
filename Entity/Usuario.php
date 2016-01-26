<?php

namespace TodoCerdo\TodoCerdoBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * TodoCerdo\TodoCerdoBundle\Entity\Usuario
 *
 * @ORM\Table(name="Usuario")
 * @ORM\Entity
 */
class Usuario extends BaseUser
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
     * @var string $apellido
     *
     * @ORM\Column(name="apellido", type="string", length=30, nullable=true)
     */
    protected $apellido;

    /**
     * @var string $nombres
     *
     * @ORM\Column(name="nombres", type="string", length=30, nullable=true)
     */
    protected $nombres;

    /**
     * @var string $celular
     *
     * @ORM\Column(name="celular", type="string", length=15, nullable=true)
     */
    protected $celular;

    


    public function __construct()
    {
        parent::__construct();
        //$this->perfiles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set apellido
     *
     * @param string $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set celular
     *
     * @param string $celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }


    /**
     * Agrega un rol al usuario.
     * @throws Exception
     * @param Rol $rol 
     */
    public function setRoles(array $rol)
    {
	$this->roles = array();
	if($rol[0] == 1) {
	  array_push($this->roles, 'ROLE_ADMIN');
	}
	else if($rol[0] == 2) {
	  array_push($this->roles, 'ROLE_USER');
	}
        
    }

}
