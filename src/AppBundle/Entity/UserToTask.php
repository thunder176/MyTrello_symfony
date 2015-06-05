<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserToTask
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserToTaskRepository")
 */
class UserToTask
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User",inversedBy="tasks")
     * @ORM\JoinColumn(name="uesr_id", referencedColumnName="id")
     */
    public $user;

    /**
     * @ORM\ManyToOne(targetEntity="Task",inversedBy="users")
     * @ORM\JoinColumn(name="task_id", referencedColumnName="id")
     */
    public $task;

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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return UserToTask
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set task
     *
     * @param \AppBundle\Entity\Task $task
     * @return UserToTask
     */
    public function setTask(\AppBundle\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task
     *
     * @return \AppBundle\Entity\Task 
     */
    public function getTask()
    {
        return $this->task;
    }
}
