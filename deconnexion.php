<?php
session_start();
session_unset();
session_destroy();
setcookie('id');
unset($_COOKIE['id']);
setcookie('connexion_auto');
unset($_COOKIE['connexion_auto']);
header('Location: accueil');
exit();
?>