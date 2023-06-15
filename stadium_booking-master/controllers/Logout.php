<?php
session_start();
$_SESSION["auth"] = false;
$_SESSION["key"] = null;
session_unset();
if(session_destroy()){
    header('Location: ../');
}


?>