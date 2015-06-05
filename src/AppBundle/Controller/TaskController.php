<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;

/**
 * Task controller.
 *
 * @Route("/task")
 */
class TaskController extends Controller
{

    /**
     * Lists all Task entities.
     *
     * @Route("/", name="task")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Task')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Task entity.
     *
     * @Route("/{projectId}/{listId}", name="task_create")
     * @Method("POST")
     * @Template("AppBundle:Task:new.html.twig")
     */
    public function createAction($projectId, $listId, Request $request)
    {
        $entity = new Task();
        $form = $this->createCreateForm($projectId, $listId, $entity);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('AppBundle:ListOfTask')->find($listId);
        $entity->setListId($list);
        $entity->setIsHidden(0);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('task_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
            'listId' => $listId,
        );
    }

    /**
     * Creates a form to create a Task entity.
     *
     * @param Task $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm($projectId, $listId, Task $entity)
    {
        $form = $this->createForm(new TaskType(), $entity, array(
            'action' => $this->generateUrl('task_create', array('projectId' => $projectId, 'listId' => $listId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Task entity.
     *
     * @Route("/{projectId}/{listId}/new", name="task_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($projectId, $listId)
    {
        $entity = new Task();
        $form = $this->createCreateForm($projectId, $listId, $entity);
        //$form->add('listId', 'hidden', array('data' => $listId));
        $form->add('is_complete', 'hidden', array('data' => 0));

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
            'listId' => $listId,
        );
    }

    /**
     * Finds and displays a Task entity.
     *
     * @Route("/{projectId}/{listId}/{id}", name="task_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($projectId, $listId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $listId, $id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Task entity.
     *
     * @Route("/{projectId}/{listId}/{id}/edit", name="task_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($projectId, $listId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $editForm = $this->createEditForm($projectId, $listId, $entity);
        $deleteForm = $this->createDeleteForm($projectId, $listId, $id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
            'listId' => $listId,
        );
    }

    /**
     * Creates a form to edit a Task entity.
     *
     * @param Task $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm($projectId, $listId, Task $entity)
    {
        $form = $this->createForm(new TaskType(), $entity, array(
            'action' => $this->generateUrl('task_update', array('projectId' => $projectId, 'listId' => $listId, 'id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));
        //$form->add('listId', 'hidden', array('data' => $entity->getListId()));

        return $form;
    }

    /**
     * Edits an existing Task entity.
     *
     * @Route("/{projectId}/{listId}/{id}", name="task_update")
     * @Method("PUT")
     * @Template("AppBundle:Task:edit.html.twig")
     */
    public function updateAction(Request $request, $projectId, $listId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Task')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $listId, $id);
        $editForm = $this->createEditForm($projectId, $listId, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('task_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
            'listId' => $listId,
        );
    }

    /**
     * Deletes a Task entity.
     *
     * @Route("/{projectId}/{listId}/{id}", name="task_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $projectId, $listId, $id)
    {
        $form = $this->createDeleteForm($projectId, $listId, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Task')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Task entity.');
            }

            //$em->remove($entity);
            $entity->setIsHidden(True);
            $em->flush();
        }

        return $this->redirect("/p/" . $projectId);
        //return $this->redirect($this->generateUrl('task'));
    }

    /**
     * Creates a form to delete a Task entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($projectId, $listId, $id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('task_delete', array('projectId' => $projectId, 'listId' => $listId, 'id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
