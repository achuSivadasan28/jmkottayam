<?php
session_start();

if(isset($_SESSION['staffId']) && ($_SESSION['staffrole'] == 'staff'))
 {
    echo 1;
}else{
    echo 0;
}
?>