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

    class Server {

        const VERSION = "v0.1.0-alpha1";

        protected $reqCount = 1;

        protected $worker;

        protected function __construct($addr){

            $this->worker = new \Workerman\Worker("tcp://" . $addr);

            $this->handle($this->worker);

        }

        public static function listen($addr){

            return new self($addr);

        }

        protected function handle($worker){

            $worker->onConnect = [$this, "onConnect"];
            $worker->onMessage = [$this, "onMessage"];
            $worker->onClose = [$this, "onClose"];

            return $this;

        }

        public function onConnect($conn){

            $conn->send(
                $this->buildRequest(
                    "notify", 
                    [
                        "message" => 
                            (
                                "FuncPhy Server " . 
                                self::VERSION
                            )
                    ], 
                    true
                )
            );

        }

        public function onClose($conn){

            $conn->send(
                $this->buildRequest(
                    "notify",
                    [
                        "message" => 
                            (
                                "Bye"
                            )
                    ],
                    true
                )
            );

        }

        public function onMessage($conn, $msg){

            static $routerList = [
                "add" => "execAdd",
                "exit" => "execExit",
                "run" => "execRun"
            ];

            $msg = $this->parseRequest($msg, $conn);

            if(!$msg){
                return;
            }

            if(!isset($routerList[$msg['method']])){
                $conn->send($this->buildError(
                    [
                        "code" => -32600,
                        "message" => "Invalid Request"
                    ],
                    $msg['id']
                ));
                return;
            }

            $conn->send($this->buildResponse(
                call_user_func([$this, $routerList[$msg['method']]], $msg['param']),
                $msg['id']
            ));

        }

        function execAdd($args){

            $code = $args['code'];

            $id = Manager::load($code);

            return $id;

        }


        function execExit(){

            return "Unsupported Now";    

        }

        function execRun($args){

            $func = $args['function'];
            $method = isset($args['method']) ? $args['method'] : "__invoke";
            $context = isset($args['context']) ? $args['context'] : [];
            $params = isset($args['params']) ? $args['params'] : [];

            $ctx = new Context;

            foreach($context as $k=>$v){
                $ctx->{"set" . $k}($v);
            }

            $fn = new Runner($func);
            $rslt = $fn->call($method, $params, $ctx);

            return ["id" => $rslt['id'], "result" => $rslt['result']];

        }

        public function parseRequest($req, $conn){

            $req = json_decode($req, 1);

            // var_dump($req);

            @$method = $req['method'];

            @$param = $req['params'];

            @$id = $req['id'];

            if(!$method || !$id || @$req['jsonrpc'] != "2.0"){
                $conn->send($this->buildError(
                    [
                        "code" => -32600,
                        "message" => "Invalid Request"
                    ],
                    $id
                ));
                return false;
            }

            return ['method' => $method, 'param' => $param, 'id' => $id];

        }

        protected function buildRequest($type, $params, $isNotify = false){

            return json_encode([
                "jsonrpc" => "2.0",
                "method" => $type,
                "params" => $params,
                "id" => ($isNotify ? null : (++$this->reqCount))
            ]) . "\r\n";

        }

        protected function buildResponse($result, $id){

            return json_encode([
                "jsonrpc" => "2.0",
                "result" => $result,
                "id" => $id
            ]) . "\r\n";

        }

        protected function buildError($error, $id){

            return json_encode([
                "jsonrpc" => "2.0",
                "error" => $error,
                "id" => $id
            ]) . "\r\n";

        }

    }