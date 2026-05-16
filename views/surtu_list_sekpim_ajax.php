<?php
//echo 'testing';
//
ini_set('display_errors', 1);
session_start();

include "pdo.class.php";
$pdo = new Database();
include "surtu_function.php";

#script untuk surtu list
#$nip = '196510211993032001';
#$nip = $_SESSION['user_nip']; //'090613091'; 
$sql = "SELECT a.* , NamaBidang as unit_kerja
		FROM surtu_kegiatan a
		JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang 
		WHERE status IN (4)";
$pdo->query($sql);
$result_kegiatan = $pdo->resultset();
#print_r($result_kegiatan);

#ambil data array
$_sumber_dana = sumber_dana();
$_status = status($result_status);

$html = '
	<br>
	<h4 style="text-align:center">Daftar Surat Tugas Sudah Disetujui Wakil Dekan<br></h4>
	<hr>
	<table class="table frm-list" style="font-size:12px">
		<thead>
			<tr>
				<th>No</th>
				<th>Perihal</th>
				<th>Tgl. Permohonan</th>
				<th colspan="2">No. Surat</th>
				<th>Periode</th>
				<th>Sumber Dana</th>
				<th>Status</th>
				<th>Unit Kerja</th>
				<th colspan="2"></th>
				<th colspan="2">Final</th>
			</tr>
		</thead>
		<tbody>';
		$no=1;
		foreach ($result_kegiatan as $row){
			$id = $row['id'];
			$nip = $row['nip'];
			$kd_surtu = $row['kd_surtu'];
			$nama_kegiatan = $row['nama_kegiatan'];
			$tgl_permohonan = dateTimeToTanggal($row['tgl_permohonan']);
			$no_surat = $row['no_surat2'];
			$sumber_dana = $_sumber_dana[$row['sumber_dana']];
			$start_date = dbToTanggal($row['start_date']);
			$end_date = dbToTanggal($row['end_date']);
			$periode = $start_date.' - '.$end_date;
			if($row['status']==5){
				$catatan = '<i style="color:green">'.html_entity_decode($row['catatan_perbaikan_sdm']).'</i>';
			} else if($row['status']==6){
				$catatan = '<i style="red">'.html_entity_decode($row['catatan_tolak_sdm']).'</i>';
			} else if($row['status']==7){
				$catatan = '<i style="color:green">'.html_entity_decode($row['catatan_perbaikan_wadek2']).'</i>';
			} else if($row['status']==8){
				$catatan = '<i style="color:red">'.html_entity_decode($row['catatan_tolak_wadek2']).'</i>';
			} else {
				$catatan = '';
			}
			$status = $_status[$row['status']].$catatan;
			$unit_kerja = $row['unit_kerja'];
			
			#jika status belum diajukan maka tampilkan tombol ajukan, edit dan delete
			if($row['status'] == 3){
				$kolom_crud = '<td><div class="approval btn btn-primary btn-xs" data-nip="'.$nip.'">Approval</div></td>';
			} else {
				$kolom_crud = '<td><div class="view btn btn-warning btn-xs" data-nip="'.$nip.'">View</div></td>';
			}
			
			//cek file arsipnya udah ada apa nggak
			if($row['file_arsip']!=''){
				$icon = '<div class="view_file_arsip fa fa-file-text-o" style=" color:#aa72b8; font-size:20px;" data-id="'.$row['id'].'"></div>';
			} else {
				$icon = '';
			}
			
			$upload_arsip = '<div class="upload-arsip fa fa-arrow-circle-o-up" data-surtu="'.$kd_surtu.'" data-tt="tooltip" title="upload final surat" style="color:#008080; font-size:20px; cursor:pointer"></div>';

			$html.= '
				<tr id="'.$id.'">
					<td>'.$no.'</td>
					<td>'.$nama_kegiatan.'</td>
					<td>'.$tgl_permohonan.'</td>
					<td><input type="text" id="no_surat-'.$id.'" name="no_surat" value="'.$no_surat.'" ></td>
					<td width="65px">
						<!--<div class="edit_nomor_surat btn btn-success btn-xs" data-kd_surtu="'.$kd_surtu.'">edit</div>-->

						<div class="btn-simpan-no_surat-'.$id.'" style="display:none">
							<button type="button" class="btn btn-primary btn-xs simpan" id="simpan-no_surat-'.$id.'"><i class="fa fa-check"/></button>
							<button type="button" class="btn btn-danger btn-xs batal" id="batal-simpan-no_surat-'.$id.'"><i class="fa fa-times"/></button>
						</div>
						<div class="btn-edit-no_surat-'.$id.'">
							<button type="button" class="btn btn-success btn-xs edit" id="edit-no_surat-'.$id.'" >edit</button>
						</div>
						<div class="pesan-no_surat"></div>
					</td>
					<td data-tgl1="'.$start_date.'" data-tgl2="'.$end_date.'">'.$periode.'</td>
					<td data-sumber-dana="'.$row['sumber_dana'].'">'.$sumber_dana.'</td>
					<td>'.$status.'</td>
					<td>'.$unit_kerja.'</td>'.
					$kolom_crud.'
					<td>'.$icon.'</td>
					<td>'.$upload_arsip.'</td>
				</tr>';

			$no++;
		}
		$html.= '
		</tbody>
	</table>';
	
	echo $html;

?>