<?php
include "pdo.class.php";
include "fungsi_dbtotanggal.php";
//New PDO object
$pdo = new Database();

$sql = "SELECT a.* , NamaBidang as unit_kerja
		FROM surtu_kegiatan a
		LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang AND status = 0 ";
$pdo->query($sql);
$result = $pdo->resultset();
//print_r($result);

table_header();
table_content($result);



function table_header(){
	$html = '
	<table>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Kegiatan</th>
				<th>Periode</th>
				<th>Unit Kerja</th>
				<th>Sumber Dana</th>
				<th>Status Persetujuan</th>
			</tr>
		</thead>';
	echo $html;
}

function table_content($result){
	$_sumber_dana = array(
		'1' => 'PAU',
		'2' => 'PAF',
		'3' => 'Departemen/Prodi',
		'4' => 'Lain-lain'
	);
	
	$_status = array(
		'0' => 'Menunggu Konfirmasi Unit Keuangan',
		'1' => 'Menunggu Persetujuan Manajer SDM',
		'3' => 'Menunggu Persetujuan Wadek Bid. DIKLITMA',
		'4' => 'Menunggu Persetujuan Wadek Bid. SUMDAVUM',
		'5' => 'Disetujui'
	);
	
	$html='<tbody>';
	$no=1;
	foreach ($result as $row){
		$nama_kegiatan = $row['nama_kegiatan'];
		$sumber_dana = $_sumber_dana[$row['sumber_dana']];
		$start_date = dbToTanggal($row['start_date']);
		$end_date = dbToTanggal($row['end_date']);
		$periode = $start_date.' - '.$end_date;
		$unit_kerja = $row['unit_kerja'];
		$status = $_status[$row['status']];
		
		$html.= '
			<tr>
				<td>'.$no.'</td>
				<td>'.$nama_kegiatan.'</td>
				<td>'.$periode.'</td>
				<td>'.$unit_kerja.'</td>
				<td>'.$sumber_dana.'</td>
				<td>'.$status.'</td>
			</tr>';
		$no++;
	}
	$html.='</tbody></table>';
	
	echo $html;
}



/*set tanggal
$d = date('d');
$m = date('n');
$y = date('Y');
//set hari
$nama_hari = array( '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
$hari = $nama_hari[$kd_hari];
//set bulan
$nama_bulan = array(' ','Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$bulan = $nama_bulan[$m];
$tanggal = $d.' '.$bulan.' '.$y;
*/
?>