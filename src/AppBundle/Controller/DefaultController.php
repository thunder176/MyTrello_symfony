<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\UserToTask;
use AppBundle\Entity\User;
use AppBundle\Entity\Project;
use AppBundle\Entity\ListOfTask;
use Symfony\Component\Validator\Constraints\True;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     *
     * @param appBundle /Entity/User
     *
     * @return array data
     */
    public function prepareProcessData($user)
    {
        $result = array();
        $utops = $user->getProjects();
        foreach ($utops as $utop) {
            if (!$utop->getProject()->getIsHidden()) {
                $projectId = $utop->getProject()->getId();
                $tasksNum = 0;
                $tasksDoneNum = 0;
                $dueDate = 0;
                $lists = $utop->getProject()->getLists();
                foreach ($lists as $list) {
                    if (!$list->getIsHidden()) {
                        $tasks = $list->getTasks();
                        foreach ($tasks as $task) {
                            if (!$task->getIsHidden()) {
                                $tasksNum += 1;
                                if ($task->getIsComplete()) {
                                    $tasksDoneNum += 1;
                                }
                                if ($task->getDueDate() > $dueDate) {
                                    $dueDate = $task->getDueDate();
                                }
                            }
                        }
                    }
                }
                if ($tasksNum) {
                    $result[] = array('projectId' => $projectId, 'dueDate' => $dueDate, 'process' => array('todo' => $tasksNum,
                        'done' => $tasksDoneNum, 'percent' => $tasksDoneNum / $tasksNum * 100));

                } else {
                    $result[] = array('projectId' => $projectId, 'dueDate' => $dueDate, 'process' => array('todo' => 0,
                        'done' => 0, 'percent' => 0));
                }
            }
        }
        return $result;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function homeAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
            return $this->redirect($this->generateUrl('login'));
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $processData = $this->prepareProcessData($user);
        // get all project name with this user in
        return $this->render('home.html.twig', array('projects' => $user->getProjects(), 'processData' => $processData));
        /*$em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Project')->findAll();
        $projects = $entities;
        return $this->render('home.html.twig', array('projects' => $projects));*/
    }

    /**
     * @Route("/p/{id}", name="projectLists")
     */
    public function projectListsAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
            return $this->redirect($this->generateUrl('login'));
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // get all list by project id
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Project')->find($id);
        $project = $entities;
        $lists = $project->getLists();
        return $this->render('list.html.twig', array('project' => $project, 'members' => $project->getUsers(), 'projectId' => $id, 'lists' => $lists));
    }

    /**
     * Change a task to another list
     *
     * @Route("/p/moveTask/{projectId}/{listId}/{taskId}", name="moveTask")
     */
    public function moveTaskAction($projectId, $listId, $taskId)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository('AppBundle:Task')->find($taskId);
        $list = $em->getRepository('AppBundle:ListOfTask')->find($listId);
        if (!$task || !$list) {
            throw $this->createNotFoundException('Unable to find Task/List entity.');
        }

        // Add relationship between user and task
        $task->setListId($list);
        $em->flush();

        // get all list by project id
        $project = $em->getRepository('AppBundle:Project')->find($projectId);
        $lists = $project->getLists();
        return $this->redirect($this->generateUrl('projectLists', array('project' => $project, 'members' => $project->getUsers(), 'id' => $projectId, 'projectId' => $projectId, 'lists' => $lists)));
    }

    /* only for testing */
    /**
     * @Route("/aaa", name="aaa")
     */
    public function aaaAction()
    {
        $flieds = array('page_title' => "AAA", 'navigation' => array(array("url" => "www.baidu.com", 'label' => "Baidu"),
            array("url" => "www.google.com", 'label' => "Google")));
        return $this->render('aaa.html.twig', $flieds);
    }

    /**
     * @Route("/test", name="aaa")
     */
    public function testAction()
    {
        return $this->render('test.html.twig');
    }

    /**
     * @Route("/api/addlist/{listname}/{cardname}", name="api_addlist")
     */
    public function apiAddlistAction($listname, $cardname)
    {
        return new Response("I got " . $listname . " / " . $cardname . ".");
    }

}