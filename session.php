<?php
session_start();
function flash($name) {
    if(isset($_SESSION[$name])) {
        echo "<p>{$_SESSION[$name]}</p>";
        unset($_SESSION[$name]);
    }
}
?>
