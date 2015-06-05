<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 *
 * @ORM\Table(name = "tasktable")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TaskRepository")
 */
class Task
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
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_complete", type="boolean")
     */
    private $isComplete;

    /**
     * @var string
     *
     * @ORM\Column(name="due_date", type="text")
     */
    private $dueDate;

    /**
     * @ORM\ManyToOne(targetEntity="ListOfTask", inversedBy="tasks")
     * @ORM\JoinColumn(name="list_id", referencedColumnName="id")
     */
    public $listId;

    /**
     * @ORM\OneToMany(targetEntity="UserToTask",mappedBy="task")
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
        return $this->getText()?$this->getText() : '无类别数据';
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
     * Set listId
     *
     * @param integer $listId
     * @return Task
     */
    public function setListId($listId)
    {
        $this->listId = $listId;

        return $this;
    }

    /**
     * Get listId
     *
     * @return integer 
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Task
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set isComplete
     *
     * @param boolean $isComplete
     * @return Task
     */
    public function setIsComplete($isComplete)
    {
        $this->isComplete = $isComplete;

        return $this;
    }

    /**
     * Get isComplete
     *
     * @return boolean 
     */
    public function getIsComplete()
    {
        return $this->isComplete;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add users
     *
     * @param \AppBundle\Entity\UserToTask $users
     * @return Task
     */
    public function addUser(\AppBundle\Entity\UserToTask $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \AppBundle\Entity\UserToTask $users
     */
    public function removeUser(\AppBundle\Entity\UserToTask $users)
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
     * @return Task
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
