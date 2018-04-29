<?php
    /**
     * FuncPhy Project
     * 
     * @author Tianle Xu <xtl@xtlsoft.top>
     * @license MIT
     * @package FuncPhy
     * 
     */

    namespace FuncPhy;

    class Manager {

        protected static $functions = [];

        public static function add($name, $class){

            self::$functions[$name] = new $class;

            return $name;

        }

        public static function load($file){

            return @include($file);

        }

        public static function get($name){

            if(isset(self::$functions[$name])){
                return self::$functions[$name];
            }else{
                throw new \Exception("Undefined Cloud Function: $name");
            }

        }

    }