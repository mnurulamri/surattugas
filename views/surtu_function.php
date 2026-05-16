<?php
$sql = "SELECT * FROM surtu_status";
$pdo->query($sql);
$result_status = $pdo->resultset();

function sumber_dana(){
	$_sumber_dana = array(
		'1' => 'PAU',
		'2' => 'PAF',
		'3' => 'Departemen/Prodi',
		'4' => 'Lain-lain'
	);
	return $_sumber_dana;
}

function status($result_status){
	foreach ($result_status as $row){
		$_status[$row['kd_status']] = $row['status'];
	}
	/*
	$_status = array(
		'0' => 'Belum Diajukan',
		'1' => 'Menunggu Konfirmasi Unit Keuangan',
		'2' => 'Menunggu Persetujuan Manajer SDM',
		'3' => 'Menunggu Persetujuan Wadek Bid. DIKLITMA',
		'4' => 'Menunggu Persetujuan Wadek Bid. SUMDAVUM',
		'5' => 'Disetujui'
	);
	*/
	return $_status;
}

function dbToTanggal($tanggal)
{
	if ($tanggal != '0000-00-00 00:00:00') {
		$array = explode('-', $tanggal);
		//set tanggal
	    $d = $array[2];
	    $m = $array[1];
	    $y = (int) $array[0];
		//set hari
		$nama_hari = array( '0' => 'Minggu', '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
		$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
		$hari = $nama_hari[$kd_hari];
		//set bulan
		$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
		$bulan = $nama_bulan[$m];
	    $tanggal = $d.' '.$bulan.' '.$y;
	    return $tanggal;		
	} else {
		# code...
		$tanggal = '';
		return $tanggal;
	}
}

function dateTimeToTanggal($parameter){
	$_tanggal = explode(' ', $parameter);
	$tanggal = $_tanggal[0];
	$array = explode('-', $tanggal);
	//set tanggal
    $d = $array[2];
    $m = $array[1];
    $y = $array[0];
	//set hari
	$nama_hari = array( '0' => 'Minggu', '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
	$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
	$hari = $nama_hari[$kd_hari];
	//set bulan
	$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$bulan = $nama_bulan[$m];
    $tanggal = $d.' '.$bulan.' '.$y;
    return $tanggal;
}
?>