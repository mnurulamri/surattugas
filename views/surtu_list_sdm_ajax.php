<?php
//echo 'testing';
//
//ini_set('display_errors', 1);
if(!session_id()) session_start();

include "pdo.class.php";
$pdo = new Database();
include "surtu_function.php";

#script untuk surtu list
#$nip = '196510211993032001';
#$nip = $_SESSION['user_nip']; //'090613091'; 
$sql = "SELECT a.* , a.id as id, NamaBidang as unit_kerja
		FROM surtu_kegiatan a
		JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang 
		WHERE status > 0 AND status <> 9
		ORDER BY tgl_permohonan DESC
		LIMIT 200";
$pdo->query($sql);
$result_kegiatan = $pdo->resultset();

//query cek draft surat
$sql = "SELECT * FROM surtu_file WHERE flag > 0";
$pdo->query($sql);
$result_draft_file = $pdo->resultset();
foreach ($result_draft_file as $row) {
	$draft_st[$row['kd_surtu']] = 1;
	$nama_file[$row['kd_surtu']] = $row['file_name'];
}

//print_r($result_kegiatan);
//exit();
#ambil data array
$_sumber_dana = sumber_dana();
$_status = status($result_status);

$html = '
	<br>
	<h4 style="text-align:center">Daftar Permohohan Surat Tugas<br></h4>
	<hr>

	<div class="filters">
	    <div class="filter-container">
	        <b style="color:#516395">&nbsp;&nbsp;Filter&nbsp;&nbsp;</b> <input autocomplete="off" class="filter" name="Perihal" placeholder="Perihal" data-col="Perihal" />
			<input autocomplete="off" class="filter" name="Status" placeholder="Status" data-col="Status" />
	    </div>
	</div>
	<br>
	<table class="table frm-list" style="font-size:12px">
		<thead>
			<tr>
				<th>No</th>
				<th>Perihal</th>
				<th>Tgl. Permohonan</th>
				<th>No. Surat</th>
				<th>Periode</th>
				<th>Sumber Dana</th>
				<th>Status</th>
				<th>Unit Kerja Pemohon</th>
				<th></th>
				<th colspan="3" style="text-align:center">Draft</th>
				<th colspan="2">Final</th>
			</tr>
		</thead>
		<tbody>';
		$no=1;
		foreach ($result_kegiatan as $row){
			$nip = $row['nip'];
			$kd_surtu = $row['kd_surtu'];
			$nama_kegiatan = $row['nama_kegiatan'];
			$tgl_kegiatan = $row['tgl_kegiatan'];
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
				$catatan = '<i style="color:green"> (dari Wadek) '.html_entity_decode($row['catatan_perbaikan_wadek2']).'</i>';
			} else if($row['status']==8){
				$catatan = '<i style="color:red"> (dari Wadek) '.html_entity_decode($row['catatan_tolak_wadek2']).'</i>';
			} else {
				$catatan = '';
			}
			$status = $_status[$row['status']].$catatan;
			$unit_kerja = $row['unit_kerja'];
			
			#jika status belum diajukan maka tampilkan tombol ajukan, edit dan delete
			if($row['status'] == 1){
				$kolom_crud = '<td><div class="approval btn btn-primary btn-xs" data-nip="'.$nip.'">Approval</div></td>';
			} else if($row['status'] == 7){
				$kolom_crud = '<td><div class="review btn btn-success btn-xs" data-nip="'.$nip.'">Review</div></td>';
			} else {
				$kolom_crud = '<td><div class="view btn btn-warning btn-xs" data-nip="'.$nip.'">View</div></td>';
			}
			
			//cek file arsipnya udah ada apa nggak
			if($row['file_arsip']!=''){
				if($row['file_ext']=='.pdf'){
					$icon = '<div class="view_file_arsip fa fa-file-pdf-o" style=" color:red; font-size:20px; cursor:pointer" data-id="'.$row['id'].'"></div>';
				} else {
					$icon = '<div class="view_file_arsip fa fa-file-text-o" style=" color:#aa72b8; font-size:20px;" data-id="'.$row['id'].'"></div>';
				}
				$status = 'Selesai';
			} else {
				$icon = '';
			}
			
			if($draft_st[$row['kd_surtu']]==1){
				$url = 'https://docs.google.com/gview?url=https://sdm.fisip.ui.ac.id/surattugas/dokumen/surtu_draft/' . $kd_surtu.'_'.$nama_file[$kd_surtu];
				/*
				$view_draft = '<a href="'.$url.'" class="fa fa-file-word-o" target="_blank" style="color:blue; font-size:18px; cursor:pointer"></a>';
				*/
				
				$view_draft = '<div class="view_file_draft fa fa-file-word-o" style="color:blue; font-size:18px; cursor:pointer" data-id="'.$kd_surtu.'"></div>';
				$download_draft = '<div class="download fa fa-arrow-circle-o-down" data-jenis="surtu_draft" data-nama_file="'.$kd_surtu.'_'.$nama_file[$row['kd_surtu']].'" data-tt="tooltip" title="download draft surat" style="color:#5dade2; font-size:20px; cursor:pointer"></div>';

				//$download_draft = '<a href="dokumen/surtu_draft/'.$nama_file[$row['kd_surtu']].'" class="download-draft fa fa-arrow-circle-o-down" data-surtu="'.$kd_surtu.'" data-tt="tooltip" title="download draft surat" style="color:#5dade2; font-size:20px; cursor:pointer"></a>';
			} else {
				$view_draft = '<div class="fa fa-file-text-o" style="color:#C0C0C0; font-size:20px;"></div>';
				$download_draft = '<div class="fa fa-arrow-circle-o-down" data-tt="tooltip" title="download draft surat" style="color:#C0C0C0; font-size:20px;"></div>';
			}
			
			$upload_draft = '<div class="upload-draft fa fa-arrow-circle-o-up" data-surtu="'.$kd_surtu.'" data-tt="tooltip" title="upload draft surat" style="color:#00a8a8; font-size:20px; cursor:pointer"></div>';
			$upload_arsip = '<div class="upload-arsip fa fa-arrow-circle-o-up" data-surtu="'.$kd_surtu.'" data-tt="tooltip" title="upload final surat" style="color:#008080; font-size:20px; cursor:pointer"></div>';
			
			$html.= '
				<tr id="'.$kd_surtu.'">
					<td>'.$no.'</td>
					<td>'.$nama_kegiatan.'</td>
					<td>'.$tgl_permohonan.'</td>
					<td>'.$no_surat.'</td>
					<td data-tgl_kegiatan="'.$tgl_kegiatan.'">'.$tgl_kegiatan.'</td>
					<!--
					<td data-tgl1="'.$start_date.'" data-tgl2="'.$end_date.'">'.$periode.'</td>-->
					<td data-sumber-dana="'.$row['sumber_dana'].'">'.$sumber_dana.'</td>
					
					<td>'.$status.'</td>
					<td>'.$unit_kerja.'</td>'.
					$kolom_crud.'
					<td>'.$view_draft.'</td>
					<td>'.$upload_draft.'</td>
					<td>'.$download_draft.'</td>
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

<script type="text/javascript" src="../../lib/js/multifilter.min.js"></script>
<script>
$(document).ready(function(){

	//multifilter
	$('.filter').multifilter();

})
</script>