<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\UserToProject;
use AppBundle\Form\UserToProjectType;

/**
 * UserToProject controller.
 *
 * @Route("/usertoproject")
 */
class UserToProjectController extends Controller
{

    /**
     * Lists all UserToProject entities.
     *
     * @Route("/", name="usertoproject")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:UserToProject')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new UserToProject entity.
     *
     * @Route("/{projectId}/", name="usertoproject_create")
     * @Method("POST")
     * @Template("AppBundle:UserToProject:new.html.twig")
     */
    public function createAction($projectId, Request $request)
    {
        $entity = new UserToProject();
        $form = $this->createCreateForm($projectId, $entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $alreadyExist = 0;
            $em = $this->getDoctrine()->getManager();
            $usersInProject = $em->getRepository('AppBundle:Project')->find($projectId)->getUsers();
            foreach ($usersInProject as $userInProject) {
                if ($userInProject->getUser() == $entity->getUser())
                    $alreadyExist = 1;
            }

            if (!$alreadyExist && $entity->getUser()) {
                $em->persist($entity);
                $em->flush();
            }

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('usertoproject_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Creates a form to create a UserToProject entity.
     *
     * @param UserToProject $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm($projectId, UserToProject $entity)
    {
        $form = $this->createForm(new UserToProjectType(), $entity, array(
            'action' => $this->generateUrl('usertoproject_create', array('projectId' => $projectId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UserToProject entity.
     *
     * @Route("/{projectId}/new", name="usertoproject_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($projectId)
    {
        $entity = new UserToProject();
        $form = $this->createCreateForm($projectId, $entity);
        $form->add('project', 'hidden', array('data' => $projectId));

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Finds and displays a UserToProject entity.
     *
     * @Route("/{projectId}/{id}", name="usertoproject_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:UserToProject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserToProject entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UserToProject entity.
     *
     * @Route("/{projectId}/{id}/edit", name="usertoproject_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:UserToProject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserToProject entity.');
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
     * Creates a form to edit a UserToProject entity.
     *
     * @param UserToProject $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm($projectId, UserToProject $entity)
    {
        $form = $this->createForm(new UserToProjectType(), $entity, array(
            'action' => $this->generateUrl('usertoproject_update', array('projectId' => $projectId, 'id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing UserToProject entity.
     *
     * @Route("/{projectId}/{id}", name="usertoproject_update")
     * @Method("PUT")
     * @Template("AppBundle:UserToProject:edit.html.twig")
     */
    public function updateAction(Request $request, $projectId, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:UserToProject')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UserToProject entity.');
        }

        $deleteForm = $this->createDeleteForm($projectId, $id);
        $editForm = $this->createEditForm($projectId, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect("/p/" . $projectId);
            //return $this->redirect($this->generateUrl('usertoproject_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'projectId' => $projectId,
        );
    }

    /**
     * Deletes a UserToProject entity.
     *
     * @Route("/{projectId}/{id}", name="usertoproject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $projectId, $id)
    {
        $form = $this->createDeleteForm($projectId, $id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:UserToProject')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UserToProject entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect("/p/" . $projectId);
        //return $this->redirect($this->generateUrl('usertoproject'));
    }

    /**
     * Creates a form to delete a UserToProject entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($projectId, $id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usertoproject_delete', array('projectId' => $projectId, 'id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm();
    }
}
