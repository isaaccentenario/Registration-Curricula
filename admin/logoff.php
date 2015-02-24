<?php 

ob_start(); session_start(); session_destroy(); session_write_close(); header('location:../admin/?r=3'); ob_end_flush();