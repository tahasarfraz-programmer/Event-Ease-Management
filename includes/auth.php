<?php
if(session_status()===PHP_SESSION_NONE) session_start();
function logged_in(){ return isset($_SESSION['user']); }
function require_login(){ if(!logged_in()){ header('Location: /EventEase/login.php'); exit; } }
function require_role($role){
 require_login();
 if($_SESSION['user']['role']!==$role){ header('Location: /EventEase/index.php'); exit; }
}
?>