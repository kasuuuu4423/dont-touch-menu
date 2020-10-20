<?php
require_once 'lib_pdo.php';
class Lib_menu{
    public $pdo;
    function __construct(){
        $this->pdo = new Lib_pdo();
    }
}