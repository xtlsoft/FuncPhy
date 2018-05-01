<?php

    namespace _FUNCPHY_NAMESPACE_;
    $ins = @@@GetInstanceVariable();

    class Application extends \FuncPhy\Framework {

        public function testFunc($ctx, $test){

            return ("hello" . $test . $ctx->getCallId());

        }

        public function __invoke($ctx){
            
            return 123;

        }

        public function jsonEncoder($ctx, $data){

            return json_encode($data, \JSON_PRETTY_PRINT);

        }

    }

    return \FuncPhy\Manager::add($ins->getName(), Application::class);
