<?php
// $authToken = 'OAuth 2.0 token here';

// id tong, hardcode
const idtong = 2;
function postTong($postData) {
	// Setup cURL
	$ch = curl_init ( 'http://localhost/tongcerdas/api.php' );
	curl_setopt_array ( $ch, array (
			CURLOPT_POST => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HTTPHEADER => array (
					// 'Authorization: '.$authToken,
					'Content-Type: application/json' 
			),
			CURLOPT_POSTFIELDS => json_encode ( $postData ) 
	) );
	
	// Send the request
	$response = curl_exec ( $ch );
	
	// Check for errors
	if ($response === FALSE) {
		die ( curl_error ( $ch ) );
	}
	
	// Decode the response
	return $responseData = json_decode ( $response, TRUE );
}

// The data to send to the API
$postData = [ 
		'idtong' => idtong  // ,
			                   // 'idopener' => 44,
			                   // 'typesampah' => 1
];

$responseData = postTong ( $postData );
// Print the date from the response
// echo 'id tong= ' . $responseData ['idtong'];
$statusopen = $responseData ['statusopen'];
$idopener = $responseData ['idopener'];

if ($idopener != null) {
	// TODO: kirim transaksi, perhatikan tipe sampah, per 5 detik, sebelum
	// status open = 0
	$postData = [ 
			'idtong' => idtong,
			'idopener' => $idopener,
			'typesampah' => 0 
	];
	$responseData = postTong ( $postData );
	var_dump ( $responseData );
} else {
	echo 'kosong';
}

?>