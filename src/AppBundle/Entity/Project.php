<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table(name = "projecttable")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProjectRepository")
 */
class Project
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=255)
     */
    private $info;

    /**
     * @var integer
     *
     * @ORM\Column(name="owner_id", type="integer")
     */
    private $ownerId;

    /**
     * @ORM\OneToMany(targetEntity="ListOfTask", mappedBy="projectId")
     */
    public $lists;

    /**
     * @ORM\OneToMany(targetEntity="UserToProject",mappedBy="project")
     */
    public  $users;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_hidden", type="boolean")
     */
    private $isHidden;

    public function __toString()
    {
        return $this->getName()?$this->getName() : '无类别数据';
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
     * Set ownerId
     *
     * @param integer $ownerId
     * @return Project
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    /**
     * Get ownerId
     *
     * @return integer
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Project
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add lists
     *
     * @param \AppBundle\Entity\ListOfTask $lists
     * @return Project
     */
    public function addList(\AppBundle\Entity\ListOfTask $lists)
    {
        $this->lists[] = $lists;

        return $this;
    }

    /**
     * Remove lists
     *
     * @param \AppBundle\Entity\ListOfTask $lists
     */
    public function removeList(\AppBundle\Entity\ListOfTask $lists)
    {
        $this->lists->removeElement($lists);
    }

    /**
     * Get lists
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lists = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set info
     *
     * @param string $info
     * @return Project
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Add userIds
     *
     * @param \AppBundle\Entity\UserToProject $userIds
     * @return Project
     */
    public function addUserId(\AppBundle\Entity\UserToProject $userIds)
    {
        $this->userIds[] = $userIds;

        return $this;
    }

    /**
     * Remove userIds
     *
     * @param \AppBundle\Entity\UserToProject $userIds
     */
    public function removeUserId(\AppBundle\Entity\UserToProject $userIds)
    {
        $this->userIds->removeElement($userIds);
    }

    /**
     * Get userIds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserIds()
    {
        return $this->userIds;
    }

    /**
     * Add users
     *
     * @param \AppBundle\Entity\UserToProject $users
     * @return Project
     */
    public function addUser(\AppBundle\Entity\UserToProject $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \AppBundle\Entity\UserToProject $users
     */
    public function removeUser(\AppBundle\Entity\UserToProject $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set isHidden
     *
     * @param boolean $isHidden
     * @return Project
     */
    public function setIsHidden($isHidden)
    {
        $this->isHidden = $isHidden;

        return $this;
    }

    /**
     * Get isHidden
     *
     * @return boolean 
     */
    public function getIsHidden()
    {
        return $this->isHidden;
    }
}
