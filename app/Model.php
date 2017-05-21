<?php
namespace App;

use DI\ContainerBuilder;

class Model
{
    protected static $container;

    public static function instance($class = '')
    {
        $classesMap = self::$container->get('classes_map');

        if (!empty($classesMap[$class])) { // if a class declared in the mapper just take it
            $class = $classesMap[$class];
        } else { // prefix class name with App, and try to load it
            $class = self::prepareClassName($class);
        }

        if (!empty($class)) {
            try {
                $container = self::getDIContainer();

                return $container->get($class);
            } catch (\DI\NotFoundException $e) {
                // TODO: implement error handling logic
            }
        }

        return null;
    }

    protected static function prepareClassName($class = '', $namespace = '')
    {
        $className = '';

        if (!empty($class) && is_string($class)) {
            $className = 'App\\' . implode(
                '',
                array_map(
                    'ucfirst',
                    explode('_', $class)
                )
            );
        }

        return $className;
    }

    public static function getDIContainer()
    {
        if (null === self::$container) {
            self::$container = ContainerBuilder::buildDevContainer();
        }

        return self::$container;
    }
}
