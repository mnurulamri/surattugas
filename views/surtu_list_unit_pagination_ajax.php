<?php
ini_set('display_errors', 1);
session_start();
include "pdo.class.php";
$pdo = new Database();
include "surtu_function.php";

#script untuk surtu list
#$nip = '196510211993032001';
$nip = $_SESSION['user_nip']; //'090613091'; 
/*$sql = "SELECT a.* , NamaBidang as unit_kerja, c.nama as nama_pemohon
		FROM surtu_kegiatan a
		JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang AND a.KodeBidang IN 
		(
			SELECT KodeBidang
			FROM pejabat
			WHERE nip = '$nip' AND CURDATE() BETWEEN start_date AND end_date
		) 
		JOIN surtu_user c ON user_pemohon = username";
$sql = "SELECT a.* , NamaBidang as unit_kerja, c.nama as nama_pemohon
		FROM surtu_kegiatan a
		JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang AND a.KodeBidang IN 
		(
			SELECT KodeBidang
			FROM pejabat
			WHERE nip = '091603022' AND CURDATE() BETWEEN start_date AND end_date
		) 
		JOIN surtu_user c ON user_pemohon = username";*/

if($_SESSION['username']=='sutji.lantyka'){
	$kode_bidang = "'006', '012'";
} else {
	$kode_bidang = "SELECT KodeBidang
			FROM pejabat
			WHERE nip = '$nip' AND CURDATE() BETWEEN start_date AND end_date";
}

echo $sql = "SELECT a.* , NamaBidang as unit_kerja, c.nama_bergelar as nama_pemohon
		FROM surtu_kegiatan a
		JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang AND a.KodeBidang IN 
		(
			$kode_bidang
		) 
		JOIN master_employee c ON user_pemohon = username
		WHERE status>0
		ORDER BY tgl_permohonan DESC
		";

$pdo->query($sql);
$result_kegiatan = $pdo->resultset();
//print_r($result);


#set nama unit kerja
foreach ($result_kegiatan as $row){
	$unit_kerja = $row['unit_kerja'];
}


#cetak tabel
#ambil data array
$_sumber_dana = sumber_dana();
$_status = status($result_status);

$unit_kerja = (!empty($unit_kerja)) ? $unit_kerja : '';
/*
$_sumber_dana = array(
	'1' => 'PAU',
	'2' => 'PAF',
	'3' => 'Departemen/Prodi',
	'4' => 'Lain-lain'
);

$_status = array(
	'0' => 'Belum Diajukan',
	'1' => 'Menunggu Konfirmasi Unit Keuangan',
	'2' => 'Menunggu Persetujuan Manajer SDM',
	'3' => 'Menunggu Persetujuan Wadek Bid. DIKLITMA',
	'4' => 'Menunggu Persetujuan Wadek Bid. SUMDAVUM',
	'5' => 'Disetujui'
);
*/
	
	$html = '
	<br>
	<div style="text-align:center">Daftar Permohohan Surat Tugas<br>'.$unit_kerja.'</div>
	<hr>
	<table class="table frm-list" style="font-size:12px; border="0">
		
		<thead>
			<tr>
				<th>No</th>
				<th>Pemohon</th>
				<th>Nama Kegiatan</th>
				<th>Skala Kegiatan</th>
				<th>Tempat</th>
				<th>Penyelenggara</th>
				<th>Periode</th>
				<th>Sumber Dana</th>
				<th>Status</th>
				<th colspan="3"></th>
				<th style="text-align:center">File<br>Surat Tugas</th>
			</tr>
		</thead>
		<tbody>';
		$no=1;
		foreach ($result_kegiatan as $row){
			$kd_surtu = $row['kd_surtu'];
			$nama_pemohon = $row['nama_pemohon'];
			$nama_kegiatan = $row['nama_kegiatan'];
			$tgl_kegiatan = $row['tgl_kegiatan'];
			$sumber_dana = $_sumber_dana[$row['sumber_dana']];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$periode = $start_date.' - '.$end_date;
			$file_arsip = $row['file_arsip'];
			$user_pemohon = $row['user_pemohon'];
			$skala = $row['skala'];
			$tempat = $row['tempat'];
			$penyelenggara = $row['penyelenggara'];
			/*
			if($row['status']==5){
				$catatan = '<i style="color:green">'.html_entity_decode($row['catatan_perbaikan_sdm']).'</i>';
			} else if($row['status']==6){
				$catatan = '<i style="red">'.html_entity_decode($row['catatan_tolak_sdm']).'</i>';
			} else if($row['status']==7){ 
				$catatan = '<i style="color:green">'.html_entity_decode($row['catatan_perbaikan_wadek2']).'</i>';
			} else if($row['status']==8){
				$catatan = '<i style="red">'.html_entity_decode($row['catatan_tolak_wadek2']).'</i>';
			} else {
				$catatan = '';
			}
			
			#jika wadek minta perbaikan maka untuk sementara tampilkan status menunggu persetujuan wadek sampai diperbaiki SDM bila memungkinkan
			if($row['status']==7){
				$status = $_status[$row['status']].$catatan;
				//$status = $_status[3];
			} else {
				$status = $_status[$row['status']].$catatan;
			}
			*/
			
			/* -----------------------------------------------------------------------------------------------
				perbaikan dan penolakan pada algoritma di bawah ini hanya berlaku pada sisi permohonannya saja
				untuk mekanisme perbaikan dan penolakan draft surat ada pada sistem andieni
			   ----------------------------------------------------------------------------------------------- */
			
			#set catatan
			if($row['status']==10){
				#jika perbaikan datang dari Kepala Unit
				#ambil record catatan perbaikan dari Kepala Unit
				$catatan = '<i style="color:green">'.html_entity_decode($row['catatan_perbaikan_unit']).'</i>';
			} else if($row['status']==11){
				#jika penolakan datang dari Kepala Unit
				#ambil record catatan penolakan dari Kepala Unit
				$catatan = '<i style="color:red">'.html_entity_decode($row['catatan_tolak_unit']).'</i>';
			} else if($row['status']==5){
				#jika perbaikan datang dari SDM
				#ambil record catatan perbaikan dari SDM
				$catatan = '<i style="color:green">'.html_entity_decode($row['catatan_perbaikan_sdm']).'</i>';
			} else if($row['status']==6){
				#jika penolakan datang dari SDM
				#ambil record catatan penolakan dari SDM
				$catatan = '<i style="red">'.html_entity_decode($row['catatan_tolak_sdm']).'</i>';
			} else if($row['status']==7){
				#jika perbaikan datang dari Wadek
				#ambil record catatan perbaikan dari Wadek
				$catatan = '<i style="color:green">'.html_entity_decode($row['catatan_perbaikan_wadek2']).'</i>';
				#jika wadek minta perbaikan maka untuk sementara tampilkan status menunggu persetujuan wadek sampai diperbaiki SDM bila memungkinkan
				//(enggak perlu lagi krn dibatasi pada ruang lingkup permohonan saja)
				//$status = $_status[$row['status']].$catatan;
			} else if($row['status']==8){
				#jika penolakan datang dari Wadek
				#ambil record catatan penolakan dari Wadek
				$catatan = '<i style="red">'.html_entity_decode($row['catatan_tolak_wadek2']).'</i>';
			} else {
				$catatan = '';
				
			}
			
			$status = $_status[$row['status']].$catatan;
			
			#jika status belum diajukan atau baru diajukan user pertama maka tampilkan tombol ajukan, edit dan delete
			if($row['status'] == 0 or $row['status'] == 5 or $row['status'] == 7 or $row['status'] == 9 or $row['status'] == 10){
				$kolom_crud = '
				<td class="ajukan"><div class="btn btn-primary btn-xs">approval</div></td>
				<td class="edit"><div class="btn btn-success btn-xs">edit</div></td>
				<td class="delete"><div class="btn btn-danger btn-xs">delete</div></td>';
			}  else if ($row['status'] == 1 or $row['status'] == 2 or $row['status'] == 3 or $row['status'] == 4 or $row['status'] == 8 or $row['status'] == 11){
				# jika status sudah disetujui wadek dan masih menunggu untuk diajukan kepala unit kepada manajer SDM
				$kolom_crud = '
				<td class="view"><div class="btn btn-warning btn-xs">View</div></td>
				<td></td>
				<td></td>';
			} else {
				$kolom_crud = '
				<td></td>
				<td></td>
				<td></td>';
			}
			
			# cek file arsipnya udah ada apa nggak
			if($row['file_arsip']!=''){
				if($row['file_ext']=='.pdf'){
					$icon = '<div class="view_file_arsip fa fa-file-pdf-o" style="color:red; font-size:20px; cursor:pointer;" data-id="'.$row['id'].'"></div>';
					$download = '<a href="dokumen/surtu_arsip/'.$kd_surtu.'_'.$file_arsip.'" class="download-draft fa fa-arrow-circle-o-down" data-surtu="'.$kd_surtu.'" data-tt="tooltip" title="download surat tugas" style="color:#5dade2; font-size:20px; cursor:pointer"></a>';
				} else {
					$icon = '<div class="view_file_arsip fa fa-file-text-o" style="color:#aa72b8; font-size:20px; cursor:pointer;" data-id="'.$row['id'].'"></div>';
					$download = '<a href="dokumen/surtu_arsip/'.$kd_surtu.'_'.$file_arsip.'" class="download-draft fa fa-arrow-circle-o-down" data-surtu="'.$kd_surtu.'" data-tt="tooltip" title="download surat tugas" style="color:#5dade2; font-size:20px; cursor:pointer"></a>';
				}
				$status = 'Selesai';
			} else {
				$icon = '<div class="fa fa-file-text-o" style="color:#C0C0C0; font-size:20px;" ></div>';
				$download = '<div class="fa fa-arrow-circle-o-down" data-tt="tooltip" title="download surat tugas" style="color:#C0C0C0; font-size:20px;"></div>';
			}
			
			
			$html.= '
				<tr id="'.$kd_surtu.'">
					<td>'.$no.'</td>
					<td>'.$nama_pemohon.'</td>
					<td>'.$nama_kegiatan.'</td>
					<td>'.$skala.'</td>
					<td>'.$tempat.'</td>
					<td>'.$penyelenggara.'</td>
					<td data-tgl_kegiatan="'.$tgl_kegiatan.'">'.$tgl_kegiatan.'</td>
					<td data-sumber-dana="'.$row['sumber_dana'].'">'.$sumber_dana.'</td>
					<td>'.$status.'</td>'.
					$kolom_crud.'
					<td style="text-align:center">'.$icon.'</td>
					<!--<td>'.$download.'</td>-->
				</tr>';
			$no++;
		}
		echo '
		</tbody>
	</table>';
	
	echo $html;
?>