<?php

if( session_status() == PHP_SESSION_NONE ) {
    session_start();
}

// Load libraries
require_once "../vendor/autoload.php";

// Load router & routes
require_once "../routes/web.php";