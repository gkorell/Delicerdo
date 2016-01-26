<?php

// src/TodoCerdo/TodoCerdoBundle/Entity/Contacto.php
//Clase que maneja los mensajes al correo electronico del administrador del sitio

namespace TodoCerdo\TodoCerdoBundle\Entity;

//Esto use se exportan para los validadores, es decir para hacer la validacion de lo datos del formulario
use Symfony\Component\Validator\Constraints as Assert;

class Contacto {
    

    /**
     *
     * @Assert\NotBlank 
     */
    protected $nombre;
    
    /**
     * @Assert\Email(
     *     message = "El email '{{ value }}' no es válido.",
     *     checkMX = true
     * )
     */
    protected $email;
    
    /**
     *
     * @Assert\NotBlank 
     * @Assert\Length(
     *      max = "50",
     *      maxMessage = "El asunto no puede ser mayor a  {{ limit }} caracteres."
     * )
     */     
    protected $asunto;
    
    /**
     *
     * @Assert\Length(
     *      min = "20",
     *      minMessage = "El mensaje no puede ser menor a  {{ limit }} caracteres."
     * )
     */     
    protected $mensaje;

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getAsunto() {
        return $this->asunto;
    }

    public function setAsunto($asunto) {
        $this->asunto = $asunto;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }


}
