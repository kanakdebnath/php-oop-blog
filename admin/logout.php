<?php 

if ($_GET['id'] == "logout") {
    include_once('../lib/session.php');
    Session::destroy();
}

 ?>