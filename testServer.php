<?php

    require_once("vendor/autoload.php");

    FuncPhy\Server::listen("0.0.0.0:32112");

    \Workerman\Worker::runAll();