<?php
session_start();
if(isset($_SESSION['adminLogId'] )!="" and ($_SESSION['adminrole'] == 'admin'))
 {
    echo 1;
}else{
    echo 0;
}
?>