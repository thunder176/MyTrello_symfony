<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\UserToTask;
use AppBundle\Form\UserToTaskType;

/**
 * UserToTask controller.
 *
 * @Route("/usertotask")
 */
class UserToTaskController extends Controller
{

    /**
     * Lists all UserToTask entities.
     *
     * @Route("/", name="usertotask")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:UserToTask')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new UserToTask entity.
     *
     * @Route("/{projectId}/{taskId}", name="usertotask_create")
     * @Method("POST")
     * @Template("AppBundle:UserToTask:new.html.twig")
     */
    public function createAction($projectId, $taskId, Request $request)
    {
        $entity = new UserToTask();
        $form = $this->createCreateForm($projectId, $taskId, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('usertotask_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
            'taskId' => $taskId,
        );
    }

    /**
     * Creates a form to create a UserToTask entity.
     *
     * @param UserToTask $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm($projectId, $taskId, UserToTask $entity)
    {
        $form = $this->createForm(new UserToTaskType(), $entity, array(
            'action' => $this->generateUrl('usertotask_create', array('projectId' => $projectId, 'taskId' => $taskId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UserToTask entity.
     *
     * @Route("/{projectId}/{taskId}/new", name="usertotask_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($projectId, $taskId)
    {
        $entity = new UserToTask();
        $form = $this->createCreateForm($projectId, $taskId, $entity);
        $form->add('task', 'hidden', array('data' => $taskId));

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
            'taskId' => $taskId,
        );
    }

    /**
     * Finds and displays a UserToTask entity.
     *
     * @Route("/{projectId}/{id}", name="usertotask_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:UserToTask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserToTask entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UserToTask entity.
     *
     * @Route("/{projectId}/{id}/edit", name="usertotask_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:UserToTask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserToTask entity.');
        }

        $editForm = $this->createEditForm($projectId, $entity);
        $deleteForm = $this->createDeleteForm($projectId, $id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Creates a form to edit a UserToTask entity.
     *
     * @param UserToTask $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm($projectId, UserToTask $entity)
    {
        $form = $this->createForm(new UserToTaskType(), $entity, array(
            'action' => $this->generateUrl('usertotask_update', array('projectId' => $projectId, 'id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing UserToTask entity.
     *
     * @Route("/{projectId}/{id}", name="usertotask_update")
     * @Method("PUT")
     * @Template("AppBundle:UserToTask:edit.html.twig")
     */
    public function updateAction(Request $request, $projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:UserToTask')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserToTask entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $id);
        $editForm = $this->createEditForm($projectId, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('usertotask_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Deletes a UserToTask entity.
     *
     * @Route("/{projectId}/{id}", name="usertotask_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $projectId, $id)
    {
        $form = $this->createDeleteForm($projectId, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:UserToTask')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserToTask entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect("/p/" . $projectId);
        //return $this->redirect($this->generateUrl('usertotask'));
    }

    /**
     * Creates a form to delete a UserToTask entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($projectId, $id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usertotask_delete', array('projectId' => $projectId, 'id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }

    /**
     * Add a user as a member to a task
     *
     * @Route("/addUserToTask/{projectId}/{userId}/{taskId}", name="addUserToTask")
     */
    public function addUserToTaskAction($projectId, $userId, $taskId)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('AppBundle:Task')->find($taskId);
        if (!$task) {
            throw $this->createNotFoundException('Unable to find Task entity.');
        }

        // Add relationship between user and task
        $alreadyExist = 0;
        $usersInTask = $task->getUsers();
        foreach ($usersInTask as $userIntask) {
            if ($userIntask->user->getId() == $userId)
                $alreadyExist = 1;
        }

        if (!$alreadyExist) {
            $user = $em->getRepository('AppBundle:User')->find($userId);
            if (!$user) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $utot = new UserToTask();
            $utot->setUser($user);
            $utot->setTask($task);
            $em->persist($utot);
            $em->flush();
        }

        // get all list by project id
        $project = $em->getRepository('AppBundle:Project')->find($projectId);
        $lists = $project->getLists();
        return $this->redirect($this->generateUrl('projectLists', array('project' => $project, 'members' => $project->getUsers(), 'id' => $projectId, 'projectId' => $projectId, 'lists' => $lists)));
    }
}
