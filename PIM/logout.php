<?php
/**
 * Created by PhpStorm.
 * User: cserrao
 * Date: 17/03/2017
 * Time: 20:44
 */

session_start();

session_destroy();

header("Location:index.php");
?>