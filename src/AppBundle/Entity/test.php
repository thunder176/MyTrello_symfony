<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * test
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class test
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
     * @ORM\Column(name="for_test", type="text")
     */
    private $forTest;


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
     * Set forTest
     *
     * @param string $forTest
     * @return test
     */
    public function setForTest($forTest)
    {
        $this->forTest = $forTest;

        return $this;
    }

    /**
     * Get forTest
     *
     * @return string 
     */
    public function getForTest()
    {
        return $this->forTest;
    }
}
