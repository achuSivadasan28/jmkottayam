<?php
class Dbconn
{
    public static function con()
    {
     // $connect=mysqli_connect("localhost:3306","jmwell_3","q*H97js8","db_jmwell_3");
		$connect=mysqli_connect("localhost:3306","pmna_phy","0S^6m3u9h","db_pmna_phy");
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
    
    
}
?>