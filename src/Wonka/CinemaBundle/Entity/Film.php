<?php

namespace Wonka\CinemaBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="Wonka\CinemaBundle\Entity\FilmRepository")
 * @ORM\Table(name="film")
 */
class Film
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
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $poster;
    
    /**
     * @Gedmo\Slug(fields={"title"}, updatable=false, separator="_")
     * @ORM\Column(length=100, unique=true)
     */
    protected $slug;
    
    /**
     * @ORM\OneToMany(targetEntity="Session", mappedBy="film")
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
     * Set title
     *
     * @param string $title
     * @return Film
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add sessions
     *
     * @param \Wonka\CinemaBundle\Entity\Session $sessions
     * @return Film
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
     * Set slug
     *
     * @param string $slug
     * @return Film
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

    /**
     * Set poster
     *
     * @param string $poster
     * @return Film
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string 
     */
    public function getPoster()
    {
        return $this->poster;
    }
}
