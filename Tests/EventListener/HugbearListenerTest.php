<?php

namespace Mop\HugbearBundle\Tests\EventListener;

use Mop\HugbearBundle\EventListener\HugbearListener;
use Symfony\Component\HttpFoundation\Response;

class HugbearListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testHugbearInBody()
    {
        $listener = new HugbearListener($this->getTemplatingMock(), false, 'hugbear', array());
        $response = new Response();
        $response->setContent('<html><body></body></html>');

        $m = new \ReflectionMethod($listener, 'hugResponse');
        $m->setAccessible(true);
        $m->invoke($listener, $response);

        $this->assertEquals('<html><body>HUGBEAR</body></html>', $response->getContent());
    }
    
    protected function getTemplatingMock()
    {
        $templating = $this->getMock('Symfony\Bundle\TwigBundle\TwigEngine', array(), array(), '', false);
        $templating->expects($this->any())
            ->method('render')
            ->will($this->returnValue('HUGBEAR'));

        return $templating;
    }
}
