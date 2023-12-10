<?php
session_start();
$_SESSION = array();
session_destroy();
// Redirectare paginaprincipala produse:
header('Location: login/login.html');
