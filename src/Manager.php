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
        protected static $globalContext = null;

        public static function getContext(){

            return self::$globalContext;

        }

        public static function __init__(){
            self::$globalContext = new GlobalContext;
        }

        public static function add($name, $class){

            self::$functions[$name] = new $class (clone self::$globalContext, $name);

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

    Manager::__init__();