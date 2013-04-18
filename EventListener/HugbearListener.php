<?php
namespace Mop\HugbearBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Response;

class HugbearListener implements EventSubscriberInterface
{
    private $twigEngine;
    private $autoplay;
    private $objname;
    private $hugbearConfig;
    private $asset;

    public function __construct(TwigEngine $twigEngine, $autoplay, $objname, $asset, array $hugbearConfig)
    {
        $this->twigEngine    = $twigEngine;
        $this->autoplay      = $autoplay;
        $this->objname       = $objname;
        $this->asset         = $asset;
        $this->hugbearConfig = $hugbearConfig;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $response = $event->getResponse();
        $request = $event->getRequest();

        if ($request->isXmlHttpRequest()
            || 'html' !== $request->getRequestFormat()
        ) {
            return;
        }

        $this->hugResponse($response);
    }

    private function hugResponse(Response $response)
    {
        if ($response->isRedirect()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
        ) {
            return;
        }
        $content = $response->getContent();
        if (($pos = strpos($content, '<body')) !== false && in_array(substr($content, $pos+5, 1), array('>', ' '))) {
            $insertPosition = strpos($content, '>', $pos) + 1;
            
            $arguments = array('autoplay'      => $this->autoplay,
                               'objname'       => $this->objname,
                               'asset'         => $this->asset,
                               'hugbearconfig' => $this->hugbearConfig,
                              );
            $hugbear = $this->twigEngine->render('MopHugbearBundle:Hugbear:hugbear.html.twig', $arguments);
            $response->setContent(substr($content, 0, $insertPosition) . $hugbear . substr($content, $insertPosition));
        }
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::RESPONSE => array('onKernelResponse'),
        );
    }
}
