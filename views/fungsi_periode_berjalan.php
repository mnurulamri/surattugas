<?php
#Fungsi ini digunakan untuk membandingkan periode pada data lembur
#jika periode berjalan Iebih besar dari pada periode pada record lembur 
#maka fungsi edit dan approval dinonaktifkan
$array_bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$array_bulan1 = array('Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05', 'Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12');
$array_bulan2 = array('O1'=>'Januari','O2'=>'Februari','O3'=>'Maret','O4'=>'April','O5'=>'Mei', 'O6'=>'Juni','O7'=>'Juli','O8'=>'Agustus','O9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$m = date('n')-1;
$b = date ('m');
$day = date('d');
$tahun = date('Y');
$tahun_1 = date('Y')-1;
$tahun_2 = date('Y')+1;

if ($day <= 11){
	$bulan = $array_bulan[ $m-1 ];
} else {
	$bulan = $array_bulan[ $m ];
}

echo $periode_berjalan = $tahun.$array_bulan1[$bulan];

/*
echo $periode = '2019'.'08';
if ($periode_berjalan > $periode ){
	echo 'true';
} else {
	echo 'false';
}
*/
?>