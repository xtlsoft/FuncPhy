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

    class Context {

        protected $data;

        public function __call($name, $param){

            if(substr($name, 0, 3) == "get"){
                return $this->data[substr($name, 3)];
            }else if(substr($name, 0, 3) == "set"){
                $this->data[substr($name, 3)] = $param[0];
                return $this;
            }else{
                throw new \Exception("Undefined method: $name");
            }

        }

    }