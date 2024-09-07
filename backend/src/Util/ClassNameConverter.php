<?php

namespace App\Util;

class ClassNameConverter
{
    /**
     * Transform class name to slug
     *
     * @param string $className
     * @return string
     * @throws \ReflectionException
     *
     * @author Yurii Martynovych tibet.mart@gmail.com
     */
    public static function toSlug(string $className): string
    {
        $className = (new \ReflectionClass($className))->getShortName();
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $className));
    }
}
