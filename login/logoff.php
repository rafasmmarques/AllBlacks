<?php

require_once 'checklog.php';
session_start();

session_destroy();
header('location: ../views/login.php');