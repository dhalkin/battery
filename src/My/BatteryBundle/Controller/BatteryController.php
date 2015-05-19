<?php

namespace My\BatteryBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use My\BatteryBundle\Entity\Battery;
use My\BatteryBundle\Form\BatteryType;

/**
 * Battery controller.
 *
 */
class BatteryController extends Controller
{

    /**
     * Lists all Battery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MyBatteryBundle:Battery')->findAll();

        return $this->render('MyBatteryBundle:Battery:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Battery entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Battery();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('battery_show', array('id' => $entity->getId())));
        }

        return $this->render('MyBatteryBundle:Battery:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Battery entity.
     *
     * @param Battery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Battery $entity)
    {
        $form = $this->createForm(new BatteryType(), $entity, array(
            'action' => $this->generateUrl('battery_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Battery entity.
     *
     */
    public function newAction()
    {
        $entity = new Battery();
        $form   = $this->createCreateForm($entity);

        return $this->render('MyBatteryBundle:Battery:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Battery entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyBatteryBundle:Battery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Battery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MyBatteryBundle:Battery:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Battery entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyBatteryBundle:Battery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Battery entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MyBatteryBundle:Battery:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Battery entity.
    *
    * @param Battery $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Battery $entity)
    {
        $form = $this->createForm(new BatteryType(), $entity, array(
            'action' => $this->generateUrl('battery_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Battery entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MyBatteryBundle:Battery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Battery entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('battery_edit', array('id' => $id)));

        }

        return $this->render('MyBatteryBundle:Battery:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Battery entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MyBatteryBundle:Battery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Battery entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('battery'));
    }

    /**
     * Creates a form to delete a Battery entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('battery_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Show stats.
     *
     */
    public function statsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $stat = $em->getRepository('MyBatteryBundle:Battery')->getStatistics();

        return $this->render('MyBatteryBundle:Battery:stats.html.twig', array(
            'stat' => $stat,
        ));
    }

    /**
     * Delete all.
     *
     */
    public function deleteAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->getRepository('MyBatteryBundle:Battery')->deleteAll();

        return $this->redirect($this->generateUrl('battery'));
    }

}
