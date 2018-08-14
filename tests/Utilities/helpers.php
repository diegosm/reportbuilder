<?php

function getProtectedValue ($instance, $property )
{
    $reflector = new \ReflectionClass($instance);
    $reflector_property = $reflector->getProperty($property);
    $reflector_property->setAccessible(true);

    return $reflector_property->getValue($instance);
}

function getConstant ( $instance, $property )
{
    $object = new \ReflectionClass($instance);
    return $object->getConstant($property);
}