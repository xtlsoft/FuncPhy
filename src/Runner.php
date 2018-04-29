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

        public function run($name, $method = "__invoke", $parameters = []){

            $class = Manager::get($name);

            return \call_user_func_array([$class, $method], $parameters);

        }

    }