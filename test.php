<?php

    require_once("vendor/autoload.php");

    $func = FuncPhy\Manager::load("./testFunc.php");

    var_dump(
        FuncPhy\Runner::run($func),
        FuncPhy\Runner::run($func, "testFunc", ["hey"]),
        FuncPhy\Runner::run($func, "jsonEncoder", [["testJson"=>["aaa", "nnn"]]])
    );