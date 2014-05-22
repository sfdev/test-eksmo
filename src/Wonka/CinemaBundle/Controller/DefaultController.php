<?php

namespace Wonka\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function cinemasAction()
    {
        $cinemas = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Cinema')
                ->findAll();
        $content = $this->renderView('WonkaCinemaBundle:Default:cinemas.html.twig', array(
            'cinemas'   => $cinemas,
        ));
        return new Response($content);
    }
    
    public function filmsAction()
    {
        $films = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Film')
                ->findAll();
        $content = $this->renderView('WonkaCinemaBundle:Default:films.html.twig', array(
            'films' => $films,
        ));
        return new Response($content);
    }
}
