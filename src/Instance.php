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

    use Ramsey\Uuid\Uuid;

    class Instance {

        protected $name;

        public function __construct(){

            $this->name = (string) Uuid::uuid4();

        }

        public function getNamespace(){

            return "FuncPhy\\Instances\\Temp\\T" . sha1($this->name);

        }

        public function getName(){

            return $this->name;

        }

    }