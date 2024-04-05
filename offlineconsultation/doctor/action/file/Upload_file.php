<?php
date_default_timezone_set( 'Asia/Kolkata' );
$date = date( 'd-m-Y' );
$time = date( 'h:i:s A' );
$count = count($_FILES['files']['name']);
$upload_dir = "../../assets/images/profile_pic/";
for($x=0; $x<$count;$x++)
{
    $filename=$_FILES['files']['name'][$x];

    //get extenshion
    $ext = pathinfo($filename,PATHINFO_EXTENSION);

    //vald image extenshion
	
    $valid_ext = array("jpg","jpeg","png");
    if(in_array($ext,$valid_ext))
    {
        // echo "haii";
        $path=$upload_dir.$filename;
        compressFile($_FILES['files']['tmp_name'][$x],$path,55);
        echo 1;
    }else{
	insertnormal($_FILES['files']['tmp_name'][$x],$_FILES['files']['name'][$x]);
		echo 1;
	}
}
function compressFile($source,$destination,$quaity)
{
    $info = getimagesize($source);
    if($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);
    elseif($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);
    elseif($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image , $destination , $quaity);
    //echo $image;
}
function insertnormal($x,$y)
{
    move_uploaded_file($x,'assets/images/profile_pic/'.$y);
}
?>