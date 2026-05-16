<?php
echo test;
include('../models/conn.php');

//tanggal
$shift_tgl1 = '15 Juni 2017';
$shift_tgl2 = '31 Januari 2018';


$sql = "SELECT KodeShift, TglAwal, TglAkhir, H01, H02, H03
		FROM TblShift
		WHERE KodeShift in ('023','024','025') AND YEAR(TglAwal) = '2017'";
$result = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_assoc($result))
{
	$array_shift[$row['KodeShift']] = $row;
}

function shift_satpam($shift_tgl1, $shift_tgl2, $nip, $kode_bidang, $array_waktu_kerja)
{
	//rubah format tanggal
	$tanggal1 = tanggalToDb($shift_tgl1);
	$tanggal2 = tanggalToDb($shift_tgl2);

	if(!empty($array_shift)){
		$begin = new DateTime( $array_shift['TglAwal'] ); 
		
		$shift[0] = $array_shift['H01'];
		$shift[1] = $array_shift['H02'];
		$shift[2] = $array_shift['H03'];
	} else {
		//echo "test";
		$begin = new DateTime( '2017-01-02' ); 
		
		$shift[0] = '01';
		$shift[1] = '01';
		$shift[2] = '01';
		$shift[3] = '01';
		$shift[4] = '02';
		$shift[5] = '00';
		$shift[6] = '00';
	}

/*
	if ($kode_bidang == '023') {
		$SATPAM_1[0] = "04";
		$SATPAM_1[1] = "00";
		$SATPAM_1[2] = "03";
	} elseif ($kode_bidang == '024') {
		$SATPAM_1[0] = "00";
		$SATPAM_1[1] = "03";
		$SATPAM_1[2] = "04";
	} else {
		$SATPAM_1[0] = "03";
		$SATPAM_1[1] = "04";
		$SATPAM_1[2] = "00";
	}
*/

	//iterasi tanggal
	$begin = new DateTime( $tanggal1 ); 
	$end = new DateTime( $tanggal2 ); 
	$j=0;
	for($i = $begin; $i <= $end; $i->modify('+1 day')){ 
	    //$item_tgl[$i->format("Y-m-d")] = $array_waktu[$i->format("Y-m-d")];
	     
	    if ($j > 2) {
	    	$j = 0;
	    }
	    $shift_tgl[$i->format("Y-m-d")] = $SATPAM_1[$j];
	    $j++;
	}
	return $shift_tgl;
}

function shift($array_shift){
	$end = new DateTime( date('Y-m-d') ); 
	if(!empty($array_shift)){
		$begin = new DateTime( $array_shift['TglAwal'] ); 
		
		$shift[0] = $array_shift['H01'];
		$shift[1] = $array_shift['H02'];
		$shift[2] = $array_shift['H03'];
		$shift[3] = $array_shift['H04'];
		$shift[4] = $array_shift['H05'];
		$shift[5] = $array_shift['H06'];
		$shift[6] = $array_shift['H07'];
	} else {
		echo "test";
		$begin = new DateTime( '2017-01-02' ); 
		
		$shift[0] = '01';
		$shift[1] = '01';
		$shift[2] = '01';
		$shift[3] = '01';
		$shift[4] = '02';
		$shift[5] = '00';
		$shift[6] = '00';
	}
	//iterasi tanggal
	$j=0;
	for($i = $begin; $i <= $end; $i->modify('+1 day'))
	{    
	    if ($j > 6) {
	    	$j = 0;
	    }
	    $shift_tgl[$i->format("Y-m-d")] = $shift[$j];
	    $j++;
	}
	return $shift_tgl;
	
}
	
function tanggalToDb($tgl_kegiatan)
{
	$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
	$tgl_array = explode(" ", $tgl_kegiatan);
	$d = $tgl_array[0]; 
	$month = array_search($tgl_array[1], $bulan) + 1;
	$m = (strlen($month)==2) ? $month : '0'.$month; 
	$y = $tgl_array[2];
	$tgl = $y."-".$m."-".$d;
	$tgl_kegiatan = $tgl;
	return $tgl;
}

echo '<pre>';
print_r($array_shift);
echo '</pre>';
?>