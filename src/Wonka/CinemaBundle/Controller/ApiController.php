<?php

namespace Wonka\CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Wonka\CinemaBundle\Entity\Cinema;
use Wonka\CinemaBundle\Entity\Hall;
use Wonka\CinemaBundle\Entity\Film;
use Wonka\CinemaBundle\Entity\Session;
use Wonka\CinemaBundle\Entity\Ticket;
use Wonka\CinemaBundle\Entity\Reserve;

class ApiController extends Controller
{
    public function cinemaScheduleAction(Request $request, $cinema_slug, $hall_id)
    {
        $cinema = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Cinema')
                ->getBySlugAndHallId($cinema_slug, $hall_id);
        
        if (!$cinema) {
            throw $this->createNotFoundException();
        }
        
        $schedule = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Film')
                ->getSheduleByCinemaIdAndHallId($cinema['id'], $hall_id);
        
        $data = array('data' => array(
            'schedule'  => $schedule,
            'cinema'    => $cinema,
        ));
        
        $format = $request->getRequestFormat('html');
        
        $content = $this->renderView('WonkaCinemaBundle:Api:cinemaSchedule.'.$format.'.twig', $data);
        return new Response($content);
    }
    
    
    public function filmScheduleAction(Request $request, $film_slug)
    {
        $film = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Film')
                ->getOneBySlug($film_slug);
        
        if (!$film) {
            throw $this->createNotFoundException();
        }
        
        $schedule = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Cinema')
                ->getSheduleByFilmSlug($film_slug);
        
        $data = array('data' => array(
            'schedule'  => $schedule,
            'film'      => $film,
        ));
        
        $format = $request->getRequestFormat('html');
        
        $content = $this->renderView('WonkaCinemaBundle:Api:filmSchedule.'.$format.'.twig', $data);
        return new Response($content);
    }
    
    
    public function sessionPlacesAction(Request $request)
    {
        $session = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Session')
                ->getOneByIdJoinAll($request->get('session_id'));
        
        if (!$session) {
            throw $this->createNotFoundException();
        }
        
        $format = $request->getRequestFormat('html');
        
        $places = array();
        for ($i = 1; $i <= $session['hall']['places_count']; $i++) {
            $places[] = $i;
        }
        foreach ($session['tickets'] as $ticket) {
            unset($places[array_search($ticket['place'], $places)]);
        }
        $free_places = array_values($places);
        
        if ($request->isMethod('post')) {
            $places = explode(',', $request->get('places'));
            $error_places = array_diff($places, $free_places);
            $data = array('data' => array(
                'plases' => $places,
            ));
            if (!count($error_places)) {
                $reserve = $this->processBuy($request, $session['id'], $places);
                $message = 'Вами забронированы места: '.implode(',', $places).'. '
                        . 'Код для удаления: '.$reserve->getCode();
                $request->getSession()->getFlashBag()->add('notice', $message);
                if ($format == 'json') {
                    $data['data']['reject_code'] = $reserve->getCode();
                    $content = $this->renderView('WonkaCinemaBundle:Api:sessionPlaces.json.twig', $data);
                    return new Response($content);
                }
                return new RedirectResponse($this->generateUrl('wonka_cinema_homepage'));
            }
            $message = 'Места '.implode(',', $error_places).' забронированы другими посетителями.';
            $request->getSession()->getFlashBag()->set('error', $message);
            if ($format == 'json') {
                $data['data']['error'] = $message;
                $content = $this->renderView('WonkaCinemaBundle:Api:sessionPlaces.json.twig', $data);
                return new Response($content);
            }
        }
        
        $data = array('data' => array(
            'session'       => $session,
            'free_places'   => $free_places,
        ));
        
        $content = $this->renderView('WonkaCinemaBundle:Api:sessionPlaces.'.$format.'.twig', $data);
        return new Response($content);
    }
    
    private function processBuy(Request $request, $session_id, $places)
    {
        $em = $this->getDoctrine()->getManager();
        
        $session = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Session')
                ->find($session_id);
        
        $reserve = new Reserve();
        $reserve->setCode(md5(uniqid(rand(), true)));
        $em->persist($reserve);
        
        $tickets = array();
        
        foreach ($places as $place) {
            $ticket = new Ticket();
            $ticket
                    ->setPlace($place)
                    ->setReserve($reserve)
                    ->setSession($session);
            $em->persist($ticket);
            array_push($tickets, $ticket);
        }
        
        $em->flush();
        
        return $reserve;
    }
    
    public function ticketsRejectAction(Request $request)
    {
        $reserve = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Reserve')
                ->findOneBy(array(
                    'code' => $request->get('code'),
                ));
        if (!$reserve) {
            throw $this->createNotFoundException();
        }
        
        $session = $this->getDoctrine()
                ->getRepository('WonkaCinemaBundle:Session')
                ->getOneByReserveId($reserve->getId());
        if (!$session) {
            throw $this->createNotFoundException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($reserve);
        $em->flush();
        
        $format = $request->getRequestFormat('html');
        
        if ($format == 'json') {
            $data = array('data' => array(
                'success' => true,
            ));
            $content = $this->renderView('WonkaCinemaBundle:Api:sessionPlaces.json.twig', $data);
            return new Response($content);
        }
        
        $message = 'Бронь успешно снята';
        $request->getSession()->getFlashBag()->add('notice', $message);
        return new RedirectResponse($this->generateUrl('wonka_cinema_homepage'));
    }
}
