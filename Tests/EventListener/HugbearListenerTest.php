<?php

namespace Mop\HugbearBundle\Tests\EventListener;

use Mop\HugbearBundle\EventListener\HugbearListener;
use Symfony\Component\HttpFoundation\Response;

class HugbearListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testHugbearInBody()
    {
        $listener = new HugbearListener($this->getTemplatingMock(), false, 'hugbear', '', array());
        $response = new Response();
        $response->setContent('<html><body></body></html>');

        $this->hugResponse($listener, $response);

        $this->assertEquals('<html><body>HUGBEAR</body></html>', $response->getContent());
    }

    public function testHugbearNonHtml()
    {
        $listener = new HugbearListener($this->getTemplatingMock(), false, 'hugbear', '', array());
        $response = new Response();
        $response->headers->set('Content-Type', 'text/javascript');
        $response->setContent('<html><body></body></html>');

        $this->hugResponse($listener, $response);

        $this->assertEquals('<html><body></body></html>', $response->getContent());
    }

    private function hugResponse(HugbearListener $listener, Response $response)
    {
        $m = new \ReflectionMethod($listener, 'hugResponse');
        $m->setAccessible(true);
        $m->invoke($listener, $response);
    }
    
    protected function getTemplatingMock()
    {
        $templating = \Mockery::mock('Symfony\Bundle\TwigBundle\TwigEngine');
        $templating->shouldReceive('render')->andReturn('HUGBEAR');

        return $templating;
    }
}
