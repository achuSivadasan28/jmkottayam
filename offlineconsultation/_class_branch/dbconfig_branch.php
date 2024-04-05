<?php
class Dbconn_branch
{
		private $user_name = 'ktm_con';
		private $password = 'sG^56c50w';
		private $db_name = 'db_ktm_con';
    public static function con()
    {
		global $branch;
		$self = new static;
		if($branch == 4){
			$self->user_name = 'jmwell_con';
			$self->password = '0J6es7a%9';
			$self->db_name = 'db_jmwell_con';
		}else if($branch == 5){
			//echo "hello";exit();
			$self->user_name = 'pala_consulation';
			$self->password = '20tY3@5oa';
			$self->db_name = 'db_pala_consulation';
		}else if($branch == 7){
			$self->user_name = 'kannur_consult';
			$self->password = 'lC%6i73w6';
			$self->db_name = 'db_kannur_consultation';
		}else if($branch == 8){
			$self->user_name = 'trvl_con';
			$self->password = 'sy65H^c72';
			$self->db_name = 'db_trvl_con';
		}else if($branch == 9){
			$self->user_name = 'tvm_con';
			$self->password = '9@Afyk058';
			$self->db_name = 'db_tvm_con';
		}
		else if($branch == 10){
			$self->user_name = 'blr_con';
			$self->password = 'S?szv7597';
			$self->db_name = 'db_blr_con';
		}
		else if($branch == 11){
			$self->user_name = 'kottakal_con';
			$self->password = 'm0y29~Q7l';
			$self->db_name = 'db_kottakal_con';
		}
		else if($branch == 12){
			$self->user_name = 'kkz_con';
			$self->password = 'nLe0%2j71';
			$self->db_name = 'db_kkz_con';
		}
		else if($branch == 13){
			$self->user_name = 'tdpa_con';
			$self->password = 'Ng5i_05p9';
			$self->db_name = 'db_tdpa_con';
		}else if($branch == 14){
			$self->user_name = 'calicut_con';
			$self->password = 'm@135zDz3';
			$self->db_name = 'db_calicut_con';
		}else if($branch == 15){
			$self->user_name = 'pbvr_con';
			$self->password = 'x0z_87jW7';
			$self->db_name = 'db_pbvr_con';
		}else if($branch == 16){
			$self->user_name = 'pmna_con';
			$self->password = '4hH~3ao84';
			$self->db_name = 'db_pmna_con';
		}else if($branch == 17){
			$self->user_name = 'ksrd_con';
			$self->password = 'C7ri~d917';
			$self->db_name = 'db_ksrd_con';
		}else if($branch == 18){
			$self->user_name = 'ktnm_con';
			$self->password = 'm66c*0Th6';
			$self->db_name = 'db_ktnm_con';
		}else if($branch == 19){
			$self->user_name = 'db_pune_con';
			$self->password = '3r5x4Fa7!';
			$self->db_name = 'pune_con';
		}else if($branch == 20){
			$self->user_name = 'wynd_con';
			$self->password = '!89oqP90z';
			$self->db_name = 'db_wynd_con';
		}else if($branch == 21){
			$self->user_name = 'trsr_con';
			$self->password = '0&r8zw0C1';
			$self->db_name = 'db_trsr_con';
		}else if($branch == 23){
			$self->user_name = 'ktm_con';
			$self->password = 'sG^56c50w';
			$self->db_name = 'db_ktm_con';
		}
		
      $connect=mysqli_connect("localhost:3306","$self->user_name","$self->password","$self->db_name");
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
    
    
}
?>