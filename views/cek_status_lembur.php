<?php
//ini_set('display_errors', 1);
include "pdo.class.php";
//New PDO object
$pdo = new Database();

#set tahun dan bulan
$nip = $_POST['nip'];
$tahun = $_POST['tahun'];
$bulan = bulan($_POST['bulan']);

$sql = "SELECT DISTINCT status FROM lembur_detail WHERE tahun = '$tahun' AND bulan = '$bulan' AND nip = '$nip'"; 
$stmt = $pdo->query($sql) ; //or die( $pdo->errorInfo()[2] );
$result = $pdo->resultset();
foreach($result as $row){
	echo $status = $row['status'];
}

/*if($status==1){
	echo '<button type="button" class="btn btn-primary" id="approve">Ajukan</button>' + 
				'<button type="button" class="btn btn-warning" id="rollback">Ditolak</button>';
} else {
	echo = '';
}*/
				
function bulan($nama_bulan){
	$array_bulan = array("Januari"=>"01", "Februari"=>"02", "Maret"=>"03",
					   "April"=>"04", "Mei"=>"05", "Juni"=>"06",
					   "Juli"=>"07", "Agustus"=>"08", "September"=>"09",
					   "Oktober"=>"10", "November"=>"11", "Desember"=>"12");
	return $array_bulan[$nama_bulan];
}

?>