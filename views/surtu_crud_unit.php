
<?php
if(!session_id()) session_start();
date_default_timezone_set('Asia/Jakarta');

include "pdo.class.php";
$pdo = new Database();

$crud = htmlspecialchars($_POST['crud']); 

#approval kepala unit untuk merubah status ke menunggu persetujuan manajer SDM
if($crud == 1){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$tgl_sistem = date("Y-m-d H:i:s");
	$sql = "UPDATE surtu_kegiatan SET status = 1, tgl_approval_unit = '$tgl_sistem' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

#perlu perbaikan kepala unit
if($crud == 2){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$catatan_perbaikan_unit = htmlspecialchars($_POST['catatan_perbaikan_unit']);
	$sql = "UPDATE surtu_kegiatan SET status = 10, catatan_perbaikan_unit = '$catatan_perbaikan_unit' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

#penolakan kepala unit
if($crud == 3){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$catatan_tolak_unit = htmlspecialchars($_POST['catatan_tolak_unit']);
	$sql = "UPDATE surtu_kegiatan SET status = 11, catatan_tolak_unit = '$catatan_tolak_unit' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}


?>