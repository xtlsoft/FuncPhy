<?php

    require_once("vendor/autoload.php");

    $func = FuncPhy\Manager::load("./testFunc.php");

    $runner = new FuncPhy\Runner($func);

    var_dump([
        $runner->call("testFunc", ["hello"]),

    ]);

    var_dump(
        FuncPhy\Runner::run($func, "jsonEncoder", [new FuncPhy\Context, ["testJson"=>["aaa", "nnn"]]])
    );
