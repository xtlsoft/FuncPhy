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

    class Runner {

        protected $name;

        public function __construct($name){

            $this->name = $name;

        }

        public function call($method = "__invoke", $parameters = [], $context = null){

            $id = (string) \Ramsey\Uuid\Uuid::uuid4();

            if($context === null) $context = new Context;

            $a = [
                $context->
                    setCallId($id)
            ];

            $parameters = array_merge($a, $parameters);

            return [
                "id" => $id,
                "context" => $context,
                "result" => self::run($this->name, $method, $parameters)
            ];

        }

        public static function run($name, $method = "__invoke", $parameters = []){

            $class = Manager::get($name);

            return \call_user_func_array([$class, $method], $parameters);

        }

    }