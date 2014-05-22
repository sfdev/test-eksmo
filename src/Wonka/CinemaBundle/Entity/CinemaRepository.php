<?php

namespace Wonka\CinemaBundle\Entity;

use Doctrine\ORM\EntityRepository;
 
/**
* CinemaRepository
* 
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class CinemaRepository extends EntityRepository
{
    public function getSheduleByFilmSlug($film_slug)
    {
        $query_parameters = array(
            'film_slug' => $film_slug,
            'time'      => date('Y-m-d H:i:s'),
        );
        $query = $this->getEntityManager()
                ->createQuery(
                        'SELECT c, h, s FROM WonkaCinemaBundle:Cinema c
                        INNER JOIN c.halls h
                        INNER JOIN h.sessions s
                        LEFT JOIN s.tickets t
                        INNER JOIN s.film f
                        WHERE (f.slug LIKE :film_slug)
                        AND (s.time > :time)
                        ORDER BY s.time ASC'
                )->setParameters($query_parameters);
        try {
            return $query->getArrayResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
    
    public function getBySlugAndHallId($slug, $hall_id = null)
    {
        $query_parameters = array(
            'slug' => $slug,
        );
        $hall_cond = null;
        if (intval($hall_id) > 0) {
            $hall_cond = ' AND (h.id = :hall_id)';
            $query_parameters['hall_id'] = $hall_id;
        }
        
        $query = $this->getEntityManager()
                ->createQuery(
                        'SELECT c FROM WonkaCinemaBundle:Cinema c
                        INNER JOIN c.halls h
                        WHERE (c.slug LIKE :slug)
                        '.$hall_cond
                )->setParameters($query_parameters)
                ->setMaxResults(1);
        try {
            return $query->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}
