<?php

include_once("Utils.class.php");


class A {
    public $a = "aaaa";
    public $b = 111;
}

class B {
    public $c = "cccc";
    public $d = null; // A array
}

$a = new A();

$b = new B();

$b->b = array($a, $a);

var_dump(Utils::Object2Array($b));
