<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="UserToProject",mappedBy="user")
     */
    public  $projects;

    /**
     * @ORM\OneToMany(targetEntity="UserToTask",mappedBy="user")
     */
    public  $tasks;

    public function __toString()
    {
        return $this->getUsername()?$this->getUsername() : '无类别数据';
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Add projects
     *
     * @param \AppBundle\Entity\UserToProject $projects
     * @return User
     */
    public function addProject(\AppBundle\Entity\UserToProject $projects)
    {
        $this->projects[] = $projects;

        return $this;
    }

    /**
     * Remove projects
     *
     * @param \AppBundle\Entity\UserToProject $projects
     */
    public function removeProject(\AppBundle\Entity\UserToProject $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add tasks
     *
     * @param \AppBundle\Entity\UserToTask $tasks
     * @return User
     */
    public function addTask(\AppBundle\Entity\UserToTask $tasks)
    {
        $this->tasks[] = $tasks;

        return $this;
    }

    /**
     * Remove tasks
     *
     * @param \AppBundle\Entity\UserToTask $tasks
     */
    public function removeTask(\AppBundle\Entity\UserToTask $tasks)
    {
        $this->tasks->removeElement($tasks);
    }

    /**
     * Get tasks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
