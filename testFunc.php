<?php

    $ins = new \FuncPhy\Instance();
    eval($ins->getHeader());

    class Application extends \FuncPhy\Framework {

        public function testFunc($test){

            return ("hello" . $test);

        }

        public function __invoke(){
            
            return 123;

        }

        public function jsonEncoder($data){

            return json_encode($data, \JSON_PRETTY_PRINT);

        }

    }

    return \FuncPhy\Manager::add($ins->getName(), Application::class);
