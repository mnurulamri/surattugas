<?php
ini_set('display_errors', 1);
if(!session_id()) session_start();
include "pdo.class.php";
$pdo = new Database();
include "surtu_function.php";


$nip = $_SESSION['user_nip']; //'090613091';
$username =  $_SESSION['username']; //'mnurulamri';

if(isset($_POST['page']))
{
    # Include pagination class file
    include('Pagination.ajax.class.user.php');

  	# set start and limit
    $start = !empty($_POST['page'])?$_POST['page']:0;
    if (!empty($_POST['page']))
    {
    	$start = $_POST['page'];
    	$no = ($_POST['page'])+1;
    } else {
    	$start = 0;
    	$no = 1;
    }

    $limit = 30;

    # set conditions for search
    $whereSQL = $orderSQL = '';
    $nama_kegiatan = '%'.$_POST['nama_kegiatan'].'%';
    $tgl_permohonan = '%'.$_POST['tgl_permohonan'].'%';
    if($_POST['status'] == 'Semua'){
        $status = '(0,1,2,3,4,5,6,7,8,9,10,11)';
    } else {
        $status = '('.$_POST['status'].')';
    }
        
        
    $whereSQL = "WHERE nama_kegiatan LIKE '$nama_kegiatan' AND CONCAT(
                DAY(tgl_permohonan), ' ',
                CASE MONTH(tgl_permohonan)
                    WHEN 1 THEN 'Januari'
                    WHEN 2 THEN 'Februari'
                    WHEN 3 THEN 'Maret'
                    WHEN 4 THEN 'April'
                    WHEN 5 THEN 'Mei'
                    WHEN 6 THEN 'Juni'
                    WHEN 7 THEN 'Juli'
                    WHEN 8 THEN 'Agustus'
                    WHEN 9 THEN 'September'
                    WHEN 10 THEN 'Oktober'
                    WHEN 11 THEN 'November'
                    WHEN 12 THEN 'Desember'
                END, ' ', YEAR(tgl_permohonan)) LIKE '$tgl_permohonan' AND status IN $status";


    $orderSQL = " ORDER BY tgl_permohonan DESC ";

    # get number of rows
  	$sql_count = "SELECT COUNT(*) AS postNum   
            FROM surtu_kegiatan a
            JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang AND a.KodeBidang AND user_pemohon = '$username' 
        $whereSQL";   
    
    $pdo->query($sql_count);
    $resultNum = $pdo->resultset();
    $rowCount = $resultNum[0]['postNum']; 
    # initialize pagination class
    $pagConfig = array(
        'currentPage' => $start,
        'totalRows' => $rowCount,
        'perPage' => $limit,
        'link_func' => 'searchFilter'
    );

    $pagination =  new Pagination($pagConfig);

    # get row
    $sql = "SELECT a.* , NamaBidang as unit_kerja
            FROM surtu_kegiatan a
            JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang AND a.KodeBidang AND user_pemohon = '$username'
            $whereSQL $orderSQL LIMIT $start, $limit";
   
   
    $pdo->query($sql);
    $result_kegiatan = $pdo->resultset();
     
    //query cek draft surat berdasarkan kd_surtu yang ada di result_kegiatan
    $result_draft_file = [];
    $draft_st = [];
    $nama_file = [];

    $kd_surtu_list = array_column($result_kegiatan, 'kd_surtu');
    
    if(!empty($kd_surtu_list)){
        $kd_surtu_value = "'".implode("','", $kd_surtu_list)."'";
        $sql_draft = "SELECT * FROM surtu_file WHERE flag > 0 AND kd_surtu IN ($kd_surtu_value)";
        $pdo->query($sql_draft);
        //$pdo->execute($kd_surtu_list);
        $result_draft_file = $pdo->resultset();
        foreach ($result_draft_file as $row) {
            $draft_st[$row['kd_surtu']] = 1;
            $nama_file[$row['kd_surtu']] = $row['file_name'];
        }
    }

    #set nama unit kerja
    foreach ($result_kegiatan as $row){
        $unit_kerja = $row['unit_kerja'];
    }


    #cetak tabel
    #ambil data array
    $_sumber_dana = sumber_dana();
    $_status = status($result_status);

    $unit_kerja = (!empty($unit_kerja)) ? $unit_kerja : '';
   //echo '<pre>';print_r($sql_draft);print_r($result_kegiatan); exit(); 

    if(!empty($result_kegiatan)){
        
	$html = '
	<table class="table frm-list" style="font-size:12px; width:100%" border="0">		
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Kegiatan</th>
				<th>Tgl. Permohonan</th>
				<th>Skala Kegiatan</th>
				<th>Tempat</th>
				<th>Penyelenggara</th>
				<th>Periode</th>
				<th width="130px">Sumber Dana</th>
				<th>Status</th>
				<th colspan="4"></th>
				<th style="text-align:center">File</th>
			</tr>
		</thead>
		<tbody>';
		
		foreach ($result_kegiatan as $row){
			$kd_surtu = $row['kd_surtu'];
			$nama_kegiatan = $row['nama_kegiatan'];
			$tgl_permohonan = dateTimeToTanggal($row['tgl_permohonan']);
			$skala = $row['skala'];
			$tempat = $row['tempat'];
			$penyelenggara = $row['penyelenggara'];
			$tgl_kegiatan = $row['tgl_kegiatan'];
			$sumber_dana = $_sumber_dana[$row['sumber_dana']];
			$start_date = $row['start_date'];  //$start_date = dbToTanggal($row['start_date']);
			$end_date = $row['end_date'];  //$end_date = dbToTanggal($row['end_date']);
			$periode = $start_date.' - '.$end_date;
			$file_arsip = $row['file_arsip'];
			
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
			
			/*  
				perbaikan dan penolakan pada algoritma di bawah ini hanya berlaku pada sisi permohonannya saja
				untuk mekanisme perbaikan dan penolakan draft surat ada pada sistem andieni
			*/
			
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
			
			/*
			#jika status belum diajukan maka tampilkan tombol ajukan, edit dan delete
			if($row['status'] == 0 or $row['status'] == 5 or $row['status'] == 7){
				$kolom_crud = '
				<td class="view"><div class="btn btn-warning btn-xs">View</div></td>
				<td class="ajukan"><div class="btn btn-primary btn-xs">ajukan</div></td>
				<td class="edit"><div class="btn btn-success btn-xs">edit</div></td>
				<td class="delete"><div class="btn btn-danger btn-xs">delete</div></td>';
			} else if ($row['status'] == 1 or $row['status'] == 2 or $row['status'] == 3 or $row['status'] == 4 or $row['status'] == 9){
				# jika status sudah disetujui atau masih menunggu untuk diajukan kepala unit kepada manajer SDM
				$kolom_crud = '
				<td class="view"><div class="btn btn-warning btn-xs">View</div></td>
				<td></td>
				<td></td>
				<td></td>';
			} else {
				$kolom_crud = '
				<td></td>
				<td></td>
				<td></td>
				<td></td>';
			}
			*/
			
			if($row['status'] == 0 or $row['status'] == 5 or $row['status'] == 7 or $row['status'] == 10){
				$kolom_crud = '
				<td class="view"><div class="btn btn-warning btn-xs">View</div></td>
				<td class="ajukan"><div class="btn btn-primary btn-xs">ajukan</div></td>
				<td class="edit"><div class="btn btn-success btn-xs">edit</div></td>
				<td class="delete"><div class="btn btn-danger btn-xs">delete</div></td>';
			} else {
				$kolom_crud = '
				<td class="view"><div class="btn btn-warning btn-xs">View</div></td>
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
					<td>'.$nama_kegiatan.'</td>
					<td>'.$tgl_permohonan.'</td>
					<td>'.$skala.'</td>
					<td>'.$tempat.'</td>
					<td>'.$penyelenggara.'</td>
					<td data-tgl_kegiatan="'.$tgl_kegiatan.'"">'.$tgl_kegiatan.'</td>
					<!--
					<td data-tgl1="'.$start_date.'" data-tgl2="'.$end_date.'">'.$periode.'</td>
					-->
					<td data-sumber-dana="'.$row['sumber_dana'].'">'.$sumber_dana.'</td>
					<td>'.$status.'</td>'.
					$kolom_crud.'
					<td style="text-align:center">'.$icon.'</td>
					<!--<td>'.$download.'</td>-->
				</tr>';
			$no++;
		}
		$html.= '
		</tbody>
	</table>
    <div style="text-align:center; padding-top:10px;   font-size:12px; font-family: \"Trebuchet MS", Arial, Helvetica, sans-serif;\">'.$pagination->createLinks().'</div> ';
	
	echo $html;
    } else {
        echo '<br><div style="text-align:center">Data tidak ditemukan</div>';
    }
} else {
    echo 'Tidak ada data';
}