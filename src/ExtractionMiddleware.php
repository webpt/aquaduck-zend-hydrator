<?php

namespace Webpt\Aquaduck\Zend\Hydrator;

use Webpt\Aquaduck\Exception\InvalidArgumentException;
use Webpt\Aquaduck\Middleware\AbstractMiddleware;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Zend\Stdlib\Hydrator\HydratorInterface;

class ExtractionMiddleware extends AbstractMiddleware
{
    private $hydrator;

    public function __construct(HydratorInterface $hydrator = null)
    {
        if ($hydrator === null) {
            $hydrator = new ArraySerializable();
        }

        $this->hydrator = $hydrator;
    }

    protected function execute($subject)
    {
        if (!is_object($subject)) {
            throw new InvalidArgumentException(
                sprintf('ExtractionMiddleware::execute must be passed an object; received "%s"', gettype($subject))
            );
        }

        return $this->hydrator->extract($subject);
    }
}
