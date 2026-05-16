<?php
$array_bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$array_bulan2 = array('O1'=>'Januari','O2'=>'Februari','O3'=>'Maret','O4'=>'April','O5'=>'Mei', 'O6'=>'Juni','O7'=>'Juli','O8'=>'Agustus','O9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$m = date('n')-1;
$day = date('d');
$tahun = date('Y');
$tahun_1 = date('Y')-1;
$tahun_2 = date('Y')+1;

if ($day <= 11){
	$bulan = $array_bulan[ $m-1 ];
} else {
	$bulan = $array_bulan[ $m ];
}

$opt_bulan = '';
foreach($array_bulan as $k => $v){
	$selected = ($v == $bulan) ? 'selected' : '' ;
	$opt_bulan .= '<option value="'.$v.'" '.$selected.'>'.$v.'</option>';
}

$opt_tahun = '';
for($i=$tahun_1; $i <= $tahun_2; $i++ ){
	$selected = ($i == $tahun) ? 'selected' : '' ;
	$opt_tahun .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
}
?>