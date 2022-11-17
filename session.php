<?php
$session = session_start();
if(isset($_SESSION["table"])){
    echo $_SESSION["table"];
}
else{
    $_SESSION = array();
    $_SESSION["table"] = '';
}