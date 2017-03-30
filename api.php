<?php
// web service tongcerdas 3
// link to mysql5, php7, nginx

require 'connect.php';
 
if ($_SERVER ['REQUEST_METHOD'] == "POST") {
	// TODO: gunakan authentication	
	// $au = $_SERVER['PHP_AUTH_USER'];
	// baca input dari arduino through esp8266
	
	$json = file_get_contents ( 'php://input' );
	
	$obj = json_decode ( $json );
	if ($obj != NULL) {
		// baca kiriman dari esp8266 jika jarak user dekat sampah
		// parsing json
		$idtong = $obj->{'idtong'};	//harus selalu ada nilai
		$idopener = $obj->{'idopener'};
		$typesampah = $obj->{'typesampah'};
		
		//TODO: jika idopener not null maka simpan ke db sesuai idtong
		//transaksinya
		if($idopener!=null){
			$sql = "INSERT INTO transaksi (idtong, idopener, typesampah, ket) VALUES ('$idtong', '$idopener', '$typesampah', now())";
			$result = $mysqli->query ( $sql );						
		}
		
		//baca dari db statusopen, idopener utk idtong yg diminta
		$sql="SELECT * FROM tong WHERE id='$idtong'";
		$result = $mysqli->query($sql);
		
		$row = $result->fetch_array(MYSQLI_NUM);
		
		$statusopen = $row[1]; //0 close, 1 open
		$idopener = $row[2];
		
		$result->close();
		
				
		// kirim ke esp8266
		$value = [ 
				"idtong" => $idtong,
				"statusopen" => $statusopen,
				"idopener" => $idopener
		];
		
		writeRespon ( $value );
		
	} else {		
		
		$data = array ();
		parse_str ( $json, $data );
		
		$submit = $data ['Submit'];
		$out = $data['Out'];
		$namaq = $data ['namaq'];
		$passwordq = $data ['passwordq'];
		$idtong = $data ['idtong'];
		
		if ($submit=== 'Login') {
			// cek login
			$sql="SELECT * FROM pengguna WHERE nama='$namaq' and password='$passwordq'";
			$result = $mysqli->query($sql);
			
			$row = $result->fetch_array(MYSQLI_NUM);
			$idopener = $row[0];
			$count= $result->num_rows;
			$result->close();
			
			var_dump($row_cnt);
			if($count===1){
				// simpan ke db, update statusopen=1 dan idopener pada idtong
				$sql = "UPDATE tong SET statusopen=1,idopener='$idopener' WHERE id='$idtong'";
				$result = $mysqli->query($sql);
							
				session_start ();
				$_SESSION ['namaq'] = $namaq;
				$_SESSION ['id'] = $idopener;
				$_SESSION ['idtong'] = $idtong;
			
			}
			header("location:index.php");
		}
		
		if($out === 'Logout'){
			session_start();
			
			$idtong = $_SESSION ['idtong'];
			//simpan ke db, update statusopen=0 dan idopener pada idtong
			$sql = "UPDATE tong SET statusopen=0,idopener=NULL WHERE id='$idtong'";
			var_dump($sql);
			$result = $mysqli->query($sql);
						
			session_destroy();
			header("location:index.php");
		}
	}
	
	
	writeRespon ( $value );
}

function writeRespon($value) {
	header ( 'Content-type: application/json' );
	// return JSON array
	exit ( json_encode ( $value ) );
}
?>
