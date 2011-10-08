<?php
 /**
 *
 *
 * @category    Entity class
 * @package     Customer Entity
 * @copyright
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/4/11 1:32 PM
 */

namespace Entity;

/**
 * @Entity(repositoryClass="Repository\CustomerRepository")
 * @Table(name="customers")
 */

class Customer
{
    /**
     * @id
     * @Column(type="integer")
     * @generatedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(unique=true, length=50)
     */
    protected $name;

    /**
     * @Column(type="datetime")
     */
    protected $created;

    public function __construct()
    {
        $this->created = new \DateTime("now");
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}