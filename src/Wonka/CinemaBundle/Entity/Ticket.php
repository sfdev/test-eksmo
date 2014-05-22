<?php

namespace Wonka\CinemaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ticket",uniqueConstraints={@ORM\UniqueConstraint(name="ticket_idx", columns={"session_id", "place"})})
 */
class Ticket
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Session", inversedBy="tickets")
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $session;
    
    /**
     * @ORM\ManyToOne(targetEntity="Reserve", inversedBy="tickets")
     * @ORM\JoinColumn(name="reserve_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $reserve;
    
    /**
     * @ORM\Column(type="smallint", nullable=false, options={"unsigned"=true})
     */
    protected $place;

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
     * Set session
     *
     * @param \Wonka\CinemaBundle\Entity\Session $session
     * @return Ticket
     */
    public function setSession(\Wonka\CinemaBundle\Entity\Session $session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \Wonka\CinemaBundle\Entity\Session 
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set place
     *
     * @param integer $place
     * @return Ticket
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return integer 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set reserve
     *
     * @param \Wonka\CinemaBundle\Entity\Reserve $reserve
     * @return Ticket
     */
    public function setReserve(\Wonka\CinemaBundle\Entity\Reserve $reserve)
    {
        $this->reserve = $reserve;

        return $this;
    }

    /**
     * Get reserve
     *
     * @return \Wonka\CinemaBundle\Entity\Reserve 
     */
    public function getReserve()
    {
        return $this->reserve;
    }
}
