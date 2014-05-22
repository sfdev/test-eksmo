<?php

namespace Wonka\CinemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="hall")
 */
class Hall
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cinema", inversedBy="halls")
     * @ORM\JoinColumn(name="cinema_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $cinema;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    /**
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned"=true})
     */
    protected $places_count;
    
    /**
     * @ORM\OneToMany(targetEntity="Session", mappedBy="hall")
     */
    protected $sessions;
    
    public function __construct()
    {
        $this->sessions = new ArrayCollection();
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
     * @return Hall
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
     * Set cinema
     *
     * @param \Wonka\CinemaBundle\Entity\Cinema $cinema
     * @return Hall
     */
    public function setCinema(\Wonka\CinemaBundle\Entity\Cinema $cinema = null)
    {
        $this->cinema = $cinema;

        return $this;
    }

    /**
     * Get cinema
     *
     * @return \Wonka\CinemaBundle\Entity\Cinema 
     */
    public function getCinema()
    {
        return $this->cinema;
    }

    /**
     * Add sessions
     *
     * @param \Wonka\CinemaBundle\Entity\Session $sessions
     * @return Hall
     */
    public function addSession(\Wonka\CinemaBundle\Entity\Session $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \Wonka\CinemaBundle\Entity\Session $sessions
     */
    public function removeSession(\Wonka\CinemaBundle\Entity\Session $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSessions()
    {
        return $this->sessions;
    }

    /**
     * Set places_count
     *
     * @param integer $placesCount
     * @return Hall
     */
    public function setPlacesCount($placesCount)
    {
        $this->places_count = $placesCount;

        return $this;
    }

    /**
     * Get places_count
     *
     * @return integer 
     */
    public function getPlacesCount()
    {
        return $this->places_count;
    }
}
