<?php
require_once 'session.cfg.php';
session_unset();
session_destroy();

header("Location: ../mp-before-login.php");