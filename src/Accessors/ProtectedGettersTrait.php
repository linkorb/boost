<?php

namespace Boost\Accessors;

use ReflectionObject;

trait ProtectedGettersTrait
{
    public function __callGetters($name, $args)
    {
        if (substr($name, 0, 3) == 'get') {
            $name = lcfirst(substr($name, 3));
            
            $vars = get_object_vars($this);
            $reflectionObject = new ReflectionObject($this);
            if ($reflectionObject->hasProperty($name)) {
                $p = $reflectionObject->getProperty($name);
                if ($p->isProtected()) {
                    $p->setAccessible(true);
                    return $p->getValue($this);
                }
            }
        }
        trigger_error('Call to undefined method '.__CLASS__.'::'.$name.'()', E_USER_ERROR);
    }
}
