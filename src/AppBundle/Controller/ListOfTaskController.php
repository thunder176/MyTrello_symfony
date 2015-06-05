<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\ListOfTask;
use AppBundle\Form\ListOfTaskType;

/**
 * ListOfTask controller.
 *
 * @Route("/listoftask")
 */
class ListOfTaskController extends Controller
{

    /**
     * Lists all ListOfTask entities.
     *
     * @Route("/", name="listoftask")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:ListOfTask')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new ListOfTask entity.
     *
     * @Route("/{projectId}/", name="listoftask_create")
     * @Method("POST")
     * @Template("AppBundle:ListOfTask:new.html.twig")
     */
    public function createAction($projectId, Request $request)
    {
        $entity = new ListOfTask();
        $form = $this->createCreateForm($projectId, $entity);
        $form->handleRequest($request);
        $entity->setIsHidden(0);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('listoftask_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Creates a form to create a ListOfTask entity.
     *
     * @param ListOfTask $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm($projectId, ListOfTask $entity)
    {
        $form = $this->createForm(new ListOfTaskType(), $entity, array(
            'action' => $this->generateUrl('listoftask_create', array('projectId' => $projectId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ListOfTask entity.
     *
     * @Route("/{projectId}/new", name="listoftask_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($projectId)
    {
        $entity = new ListOfTask();
        $entity->setProjectId($projectId);
        $form = $this->createCreateForm($projectId, $entity);
        $form->add('projectId', 'hidden', array('data' => $projectId));

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Finds and displays a ListOfTask entity.
     *
     * @Route("/{projectId}/{id}", name="listoftask_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ListOfTask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListOfTask entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ListOfTask entity.
     *
     * @Route("/{projectId}/{id}/edit", name="listoftask_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ListOfTask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListOfTask entity.');
        }

        $editForm = $this->createEditForm($projectId, $entity);
        $editForm->add('projectId', 'hidden', array('data' => $projectId));
        $deleteForm = $this->createDeleteForm($projectId, $id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Creates a form to edit a ListOfTask entity.
     *
     * @param ListOfTask $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm($projectId, ListOfTask $entity)
    {
        $form = $this->createForm(new ListOfTaskType(), $entity, array(
            'action' => $this->generateUrl('listoftask_update', array('projectId' => $projectId, 'id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing ListOfTask entity.
     *
     * @Route("/{projectId}/{id}", name="listoftask_update")
     * @Method("PUT")
     * @Template("AppBundle:ListOfTask:edit.html.twig")
     */
    public function updateAction(Request $request, $projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:ListOfTask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ListOfTask entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $id);
        $editForm = $this->createEditForm($projectId, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('listoftask_edit', array('projectId' => $projectId, 'id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Deletes a ListOfTask entity.
     *
     * @Route("/{projectId}/{id}", name="listoftask_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $projectId, $id)
    {
        $form = $this->createDeleteForm($projectId, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:ListOfTask')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ListOfTask entity.');
            }

            //$em->remove($entity);
            $entity->setIsHidden(True);
            $em->flush();
        }

        return $this->redirect("/p/" . $projectId);
        //return $this->redirect($this->generateUrl('ListOfTask'));
    }

    /**
     * Creates a form to delete a ListOfTask entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($projectId, $id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('listoftask_delete', array('projectId' => $projectId, 'id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
