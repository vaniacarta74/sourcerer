<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace vaniacarta74\Sourcerer\tests\classes;

/**
 * Description of Reflections
 *
 * @author Vania
 */
class Reflections
{
    /**
     * @param object $object
     * @param array|null $args
     * @return void
     */
    public static function invokeConstructor(object &$object, ?array $args = []): void
    {
        $class = new \ReflectionClass($object);

        $constructor = $class->getConstructor();

        $constructor->invokeArgs($object, $args);
    }

    /**
     * @param object $object
     * @param string $methodName
     * @param array|null $args
     * @return mixed
     */
    public static function invokeMethod(object &$object, string $methodName, ?array $args = []): mixed
    {
        $class = new \ReflectionClass($object);

        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $args);
    }

    /**
     * @param object $object
     * @param string $methodName
     * @param array|null $args
     * @return mixed
     */
    public static function invokeStaticMethod(object &$object, string $methodName, ?array $args = []): mixed
    {
        $class = new \ReflectionClass($object);

        $method = $class->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs(null, $args);
    }

    /**
     * @param object $object
     * @param string $propertyName
     * @return mixed
     */
    public static function getProperty(object &$object, string $propertyName): mixed
    {
        $class = new \ReflectionClass($object);

        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * @param object $object
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     */
    public static function setProperty(object &$object, string $propertyName, mixed $value): mixed
    {
        $class = new \ReflectionClass($object);

        $property = $class->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->setValue($object, $value);
    }

    /**
     * @param string $className
     * @param string $propertyName
     * @return mixed
     */
    public static function getStaticProperty(string $className, string $propertyName): mixed
    {
        $property = new \ReflectionProperty($className, $propertyName);
        $property->setAccessible(true);

        return $property->getValue(null);
    }

    /**
     * @param string $className
     * @param string $propertyName
     * @param mixed $value
     * @return mixed
     */
    public static function setStaticProperty(string $className, string $propertyName, mixed $value): mixed
    {
        $property = new \ReflectionProperty($className, $propertyName);
        $property->setAccessible(true);

        return $property->setValue(null, $value);
    }
}
