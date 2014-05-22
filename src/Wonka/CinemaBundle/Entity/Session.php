<?php

namespace Wonka\CinemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Wonka\CinemaBundle\Entity\SessionRepository")
 * @ORM\Table(name="session",uniqueConstraints={@ORM\UniqueConstraint(name="session_idx", columns={"hall_id", "time"})})
 */
class Session
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Film", inversedBy="sessions")
     * @ORM\JoinColumn(name="film_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $film;
    
    /**
     * @ORM\ManyToOne(targetEntity="Hall", inversedBy="sessions")
     * @ORM\JoinColumn(name="hall_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $hall;
    
    /**
     * @ORM\Column(name="time", type="datetime", nullable=false)
     */
    protected $time;
    
    /**
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="session")
     */
    protected $tickets;
    
    protected $free_places;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->free_places = null;
    }

    /**
     * Set film
     *
     * @param \Wonka\CinemaBundle\Entity\Film $film
     * @return Session
     */
    public function setFilm(\Wonka\CinemaBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \Wonka\CinemaBundle\Entity\Film 
     */
    public function getFilm()
    {
        return $this->film;
    }

    /**
     * Set hall
     *
     * @param \Wonka\CinemaBundle\Entity\Hall $hall
     * @return Session
     */
    public function setHall(\Wonka\CinemaBundle\Entity\Hall $hall = null)
    {
        $this->hall = $hall;

        return $this;
    }

    /**
     * Get hall
     *
     * @return \Wonka\CinemaBundle\Entity\Hall 
     */
    public function getHall()
    {
        return $this->hall;
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
     * Set time
     *
     * @param \DateTime $time
     * @return Session
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Add tickets
     *
     * @param \Wonka\CinemaBundle\Entity\Ticket $tickets
     * @return Session
     */
    public function addTicket(\Wonka\CinemaBundle\Entity\Ticket $tickets)
    {
        $this->tickets[] = $tickets;

        return $this;
    }

    /**
     * Remove tickets
     *
     * @param \Wonka\CinemaBundle\Entity\Ticket $tickets
     */
    public function removeTicket(\Wonka\CinemaBundle\Entity\Ticket $tickets)
    {
        $this->tickets->removeElement($tickets);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}
