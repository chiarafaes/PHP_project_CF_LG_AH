<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 17/04/2017
 * Time: 21:57
 */

session_start();

spl_autoload_register(function ($class) {
    include_once("../classes/".$class.".php");
});

