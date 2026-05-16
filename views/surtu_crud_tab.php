<?php
if(!session_id()) session_start();
date_default_timezone_set('Asia/Jakarta');

include "pdo.class.php";
$pdo = new Database();

$crud = $_POST['crud']; 

# semua status
if ($crud==1) {
	$sql = "SELECT COUNT(a.id) as total
		FROM surtu_kegiatan a
		JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang 
		WHERE status > 0";
	$pdo->query($sql);
	$result = $pdo->resultset();
	echo 'Semua Status ('.$result[0]['total'].')';
	
} else if($crud==2){

	# edit total pada tab menunggu persetujuan Wadek
	$sql = "SELECT COUNT(a.id) as total
		FROM surtu_kegiatan a
		JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang 
		WHERE status = 3";
	$pdo->query($sql);
	$result = $pdo->resultset();
	echo 'Disetujui -SDM ('.$result[0]['total'].')';
	
}