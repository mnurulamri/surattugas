<?php
function dbToTanggal($tanggal)
{
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
    $tanggal = $hari.', '.$d.' '.$bulan.' '.$y;
    return $tanggal;
}
?>