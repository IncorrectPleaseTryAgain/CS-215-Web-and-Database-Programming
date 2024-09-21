<?php

ini_set('session.user_strict_mode', 1);

session_start();

if(!isset($_SESSION['last_regeneration'])){
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
} else {
    $interval = 60 * 15;

    if(time() - $_SESSION['last_regeneration'] >= $interval){
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
}