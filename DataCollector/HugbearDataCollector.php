<?php

namespace Mop\HugbearBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HugbearDataCollector extends DataCollector
{
    private $objname;

    public function __construct($autoplay, $objname)
    {
        $this->objname  = $objname;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = array('objname' => $this->objname);
    }

    public function getAutoplay()
    {
        return $this->autoplay;
    }

    public function getObjname()
    {
        return $this->data['objname'];
    }

    public function getName()
    {
        return 'hugbear';
    }
}
