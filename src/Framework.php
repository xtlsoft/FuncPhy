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

    abstract class Framework {

        protected $context;

        public function __construct(\FuncPhy\GlobalContext $ctx, $uuid){

            $this->context = $ctx;
            $this->context->setFunctionUUID($uuid);

        }

    }