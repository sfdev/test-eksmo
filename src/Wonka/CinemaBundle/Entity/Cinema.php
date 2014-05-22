<?php

namespace Wonka\CinemaBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Wonka\CinemaBundle\Entity\CinemaRepository")
 * @ORM\Table(name="cinema")
 */
class Cinema
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    protected $address;
    
    /**
     * @Gedmo\Slug(fields={"name"}, updatable=false, separator="_")
     * @ORM\Column(length=100, unique=true)
     */
    protected $slug;


    /**
     * @ORM\OneToMany(targetEntity="Hall", mappedBy="cinema")
     */
    protected $halls;
    
    public function __construct()
    {
        $this->halls = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Cinema
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
     * Set address
     *
     * @param string $address
     * @return Cinema
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Add halls
     *
     * @param \Wonka\CinemaBundle\Entity\Hall $halls
     * @return Cinema
     */
    public function addHall(\Wonka\CinemaBundle\Entity\Hall $halls)
    {
        $this->halls[] = $halls;

        return $this;
    }

    /**
     * Remove halls
     *
     * @param \Wonka\CinemaBundle\Entity\Hall $halls
     */
    public function removeHall(\Wonka\CinemaBundle\Entity\Hall $halls)
    {
        $this->halls->removeElement($halls);
    }

    /**
     * Get halls
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHalls()
    {
        return $this->halls;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Cinema
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
