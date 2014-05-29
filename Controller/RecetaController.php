<?php

namespace TodoCerdo\TodoCerdoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use TodoCerdo\TodoCerdoBundle\Entity\Receta;
use TodoCerdo\TodoCerdoBundle\Form\RecetaType;

/**
 * Receta controller.
 *
 */
class RecetaController extends Controller
{
    /**
     * Lists all Receta entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TodoCerdoTodoCerdoBundle:Receta')->findAll();

        return $this->render('TodoCerdoTodoCerdoBundle:Receta:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Receta entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('TodoCerdoTodoCerdoBundle:Receta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Receta entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TodoCerdoTodoCerdoBundle:Receta:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),

        ));
    }
    
        public function descripcionAction(){
      
            $id=$this->getRequest()->get("id");
        
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('TodoCerdoTodoCerdoBundle:Receta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Receta entity.');
            }
            
            return $this->render('TodoCerdoTodoCerdoBundle:Receta:descripcion_ajax.html.twig', array(
            'receta' => $entity));
        
  }

    /**
     * Displays a form to create a new Receta entity.
     *
     */
    public function newAction()
    {
        $entity = new Receta();
        $form   = $this->createForm(new RecetaType(), $entity);

        return $this->render('TodoCerdoTodoCerdoBundle:Receta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Receta entity.
     *
     */
    public function createAction()
    {
        $entity  = new Receta();
        $request = $this->getRequest();
        $form    = $this->createForm(new RecetaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            //$file = $form['imagen']->getData(); 
            //$file->move('../Resources/public/images/',$file->getClientOriginalName());
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('receta_show', array('id' => $entity->getId())));
            
        }

        return $this->render('TodoCerdoTodoCerdoBundle:Receta:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Receta entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('TodoCerdoTodoCerdoBundle:Receta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Receta entity.');
        }

        $editForm = $this->createForm(new RecetaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TodoCerdoTodoCerdoBundle:Receta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Receta entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('TodoCerdoTodoCerdoBundle:Receta')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Receta entity.');
        }

        $editForm   = $this->createForm(new RecetaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('receta_edit', array('id' => $id)));
        }

        return $this->render('TodoCerdoTodoCerdoBundle:Receta:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Receta entity.
     *
     */
    public function deleteAction($id)
    {   
        
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('TodoCerdoTodoCerdoBundle:Receta')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Receta entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('receta'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
