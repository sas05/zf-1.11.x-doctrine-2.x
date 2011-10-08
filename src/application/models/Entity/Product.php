<?php
/**
 * @category    
 * @package     
 * @copyright   
 * @author      Saeed Ahmed <saeed.sas@gmail.com>
 * @date        7/5/11 2:50 PM
 */
 
namespace Entity;

/**
 * @Entity(repositoryClass="Repository\ProductRepository")
 * @Table(name="products", indexes={@index(columns={"name"})})
 */

class Product
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
     * @Column(type="text")
     */
    protected $description;

    /**
     * @Column(length=10)
     */
    protected $price;


    /**
     * @Column(type="datetime")
     */
    protected $created;

    /**
     * @ManyToOne(targetEntity="Entity\Customer", cascade = {"all"})
     * @JoinColumn(name="customer_id", onDelete = "cascade", onUpdate="cascade", nullable=false)
     */
    protected $customer;

    public function __construct()
    {
        $this->created = new \DateTime("now");
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
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

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCustomer(\Entity\Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
    }
}