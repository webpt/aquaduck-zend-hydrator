<?php

namespace Webpt\Aquaduck\Zend\Hydrator;

use Webpt\Aquaduck\Exception\InvalidArgumentException;
use Webpt\Aquaduck\Middleware\AbstractMiddleware;
use Zend\Stdlib\Hydrator\ArraySerializable;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ArrayObject;

class HydrationMiddleware extends AbstractMiddleware
{
    private $hydrator;
    private $objectPrototype;

    public function __construct(HydratorInterface $hydrator = null, $objectPrototype = null)
    {
        if ($hydrator === null) {
            $hydrator = new ArraySerializable();
        }

        $this->hydrator        = $hydrator;
        $this->objectPrototype = $this->resolveObjectPrototype($objectPrototype);
    }

    private function resolveObjectPrototype($objectPrototype)
    {
        if (is_object($objectPrototype)) {
            return $objectPrototype;
        }

        if ($objectPrototype === null) {
            return new ArrayObject();
        }

        if (is_string($objectPrototype)) {
            if (!class_exists($objectPrototype)) {
                throw new InvalidArgumentException(
                    sprintf(
                        '%s expects a valid object prototype class name; received "%s"; class not found;',
                        __METHOD__,
                        $objectPrototype
                    )
                );
            }

            return new $objectPrototype;
        }

        throw new InvalidArgumentException(
            sprintf('Object Prototype must be an object or valid string; received "%s"', gettype($objectPrototype))
        );
    }

    protected function execute($subject)
    {
        if (!is_array($subject)) {
            throw new InvalidArgumentException(
                sprintf('ExtractionMiddleware::execute must be passed an array; received "%s"', gettype($subject))
            );
        }

        return $this->hydrator->hydrate($subject, clone $this->objectPrototype);
    }
}
