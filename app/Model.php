<?php

namespace App;

use DI\ContainerBuilder;

class Model
{
    protected static $container;

    public static function instance($class = '')
    {
        $class = self::prepareClassName($class);

        if (!empty($class)) {
            $container = self::getDIContainer();
            return $container->get($class);
        }

        return null;
    }

    protected static function prepareClassName($class = '')
    {
        $className = '';

        if (!empty($class) && is_string($class)) {
            $className = '\\App\\' . implode(
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
