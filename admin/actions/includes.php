<?php require "../includes.php"; 

$login->session_verify() == false AND header('location:../index?r=2') . die();