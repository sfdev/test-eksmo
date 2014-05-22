<?php

namespace Wonka\CinemaBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

use Wonka\CinemaBundle\Util\FormatNegotiator;

/**
 * This listener handles Accept header format negotiations.
 */
class FormatListener
{
    /**
     * @var FormatNegotiatorInterface
     */
    private $formatNegotiator;

    /**
     * Initialize FormatListener
     */
    public function __construct()
    {
        $this->formatNegotiator = new FormatNegotiator();
    }

    /**
     * Determines and sets the Request format
     *
     * @param GetResponseEvent $event The event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        
        $acceptHeader = $request->headers->get('Accept', 'html');
        
        $available = array('html', 'json');
        
        $format = $this->formatNegotiator->getBestFormat($acceptHeader, $available);
        
        if (!in_array($format, $available)) {
            throw new NotAcceptableHttpException();
        }
        
        $request->setRequestFormat($format);
    }
}
