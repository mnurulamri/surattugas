
<?php
ini_set('display_errors', 1);
include "pdo.class.php";
//include "fungsi_dbtotanggal.php";
//New PDO object
$pdo = new Database();

$nip = $_SESSION['user_nip']; //'090613091'; 
#script untuk form edit
$sql = "SELECT DISTINCT a.id as id, a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, a.telp as telp, a.email as email, a.KodeBidang as KodeBidang
FROM pejabat a
LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang
WHERE kd_struktur = 1 AND CURDATE() BETWEEN start_date AND end_date 
	AND a.KodeBidang IN (
		SELECT KodeBidang
		FROM pejabat
		WHERE nip = '$nip' AND CURDATE() BETWEEN start_date AND end_date
	)";
$pdo->query($sql);
$result = $pdo->resultset();
foreach ($result as $row){
	$id = $row['id'];
	$nip_pejabat = $row['nip_pejabat'];
	$nama_pejabat = $row['nama_pejabat'];
	$jabatan = $row['jabatan'];
	$unit_kerja = $row['unit_kerja'];
	$telp = $row['telp'];
	$email = $row['email'];
	$KodeBidang = $row['KodeBidang'];
}
#print_r($result);

//set tanggal
$d = date('d');
$m = date('n');
$y = date('Y');
//set hari
$nama_hari = array( '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
//$hari = ($nama_hari[$kd_hari]!=0) ? $nama_hari[$kd_hari] : '0';
//set bulan
$nama_bulan = array(' ','Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$bulan = $nama_bulan[$m];
$tanggal = $d.' '.$bulan.' '.$y;

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

<div class="post-search-panel">
    <input type="hidden" id="page-num" value="">
	<fieldset>
		<legend>Filter</legend>
		<input type="text" id="nama_kegiatan" placeholder="search..."/>
		<input type="text" id="tgl_permohonan" placeholder="tgl_permohonan"/>		
		<select id="status" onchange="searchFilter()">
			<option value="Semua">Semua Status</option>
			<option value="0">Belum Diajukan</option>
			<option value="9">Menunggu Persetujuan Kepala Unit</option>
			<option value="10">Perlu Perbaikan dari Kepala Unit</option>
			<option value="11">Ditolak Kepala Unit</option>
			<option value="1">Menunggu Persetujuan Manajer SDM</option>
			<option value="6">Ditolak Manajer SDM</option>
			<option value="3">Menunggu Persetujuan Wadek Bid. SUMDAVUM</option>
			<option value="8">Ditolak Wadek Wadek Bid. SUMDAVUM</option>
			<option value="4">Disetujui</option>
		</select>
	</fieldset>
</div>

<br>

<!-- cetak list kegiatan
<div style="width:80%; margin:auto">
	<div id="data-kegiatan"></div>
</div> -->

<div class="row text-center">
	<div class="col-xs-12 col-md-12 col-lg-12">
		<div id="data-kegiatan"></div>
	</div>
</div>
<div>
	<br>
	<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
		<li>Silahkan tekan tombol <font class="label label-primary">ajukan</font> untuk mengajukan permohonan penerbitan surat tugas kepada Manajer SDM</li>
		<li>Permohonan yang sudah disetujui oleh Kepala Unit akan merubah status menjadi "Menunggu Persetujuan Manajer SDM</i>
		<li>Silahkan tekan tombol <font class="label label-warning">view</font> untuk melihat detail data permohonan</li>
		<li>Kepala Unit dapat memantau aktifitas pergerakan penerbitan surat tugas melalui status persetujuan yang meliputi:
			<ul>
				<li>Menunggu persetujuan Manajer SDM</li>
				<li>Menunggu persetujuan Wakil Dekan Bidang Sumber Daya, Ventura dan Umum</li>
				<li>Disetujui</li>
				<li>Perlu Perbaikan</li>
				<li>Ditolak</li>
			</ul>
		</li>
		<li>Proses penerbitan surat tugas dinyatakan selesai apabila file surat tugas sudah terupload </li>
	</ul>
</div>

<!-- modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
	<div class="modal-dialog" role="document" style="width:75%;">
		<div class="modal-content" style="font-size:12px">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="editModalLabel">Edit Surat Tugas</h4>
			</div>
			<div class="modal-body" style="overflow:auto">

			<div class="containerx">

				<div class="panel panel-default">
					<!-- data pemohon -->
					<div class="panel-heading">
						<h3 class="panel-title">DATA PEJABAT</h3>
					</div>
					<div class="panel-body">
						<div class="row">

				<input class="form-control" type="hidden" name="id" id="id" value="<?=$id?>" />
				<form id="frm-pejabat">
				    <div class="col-xs-3 form-group">
				        <label>Nama</label>
				    </div>
				    <div class="col-xs-9 form-group">
				        <!--<input class="form-control" type="text" name="nama" id="nama" onkeyup="lihat(this.value)"/>-->
				        <input class="form-control" type="text" name="nama_pejabat" id="nama_pejabat" value="<?=$nama_pejabat?>" disabled/>
				    </div>

				    <div class="col-xs-3 form-group">
				        <label>NIP/NUP</label>
				    </div>
				    <div class="col-xs-9 form-group">
				        <input class="form-control" type="text" name="nip_pejabat" id="nip_pejabat" value="<?=$nip_pejabat?>" disabled/>
				    </div>

				    <div class="col-xs-3 form-group">
				        <label>PAF/Dept/Prodi</label>
				    </div>
				    <div class="col-xs-9 form-group">
				        <input class="form-control" type="text" name="unit_kerja" id="unit_kerja" value="<?=$unit_kerja?>" disabled/>
				    </div>
    
				    <div class="col-xs-3 form-group">
				        <label>Jabatan</label>
				    </div>
				    <div class="col-xs-9 form-group">
				        <input class="form-control" type="text" name="jabatan" id="jabatan" value="<?=$jabatan?>" disabled/>
				    </div>

				    <div class="col-xs-3 form-group">
				        <label>Telepon</label>
				    </div>
				    <div class="col-xs-5 form-group">
				        <input class="form-control" type="text" name="telp" id="telp" value="<?=$telp?>" disabled/>
				    </div>
					<div class="col-xs-4 form-group">
						<div class="btn-simpan-telp" style="display:none">
							<button type="button" class="btn btn-primary btn-sm" id="simpan-telp" >Simpan</button>
							<button type="button" class="btn btn-danger btn-sm" id="batal-simpan-telp">Batal</button>
						</div>
						<div class="btn-edit-telp">
							<button type="button" class="btn btn-success btn-sm" id="edit-telp" >Edit</button>
						</div>
						<div class="pesan-telp">
							
						</div>
						
				    </div>

				<div class="clearfix"></div>

				    <div class="col-xs-3 form-group">
				        <label>Email</label>
				    </div>
				    <div class="col-xs-5 form-group">
				        <input class="form-control" type="text" name="email" id="email" value="<?=$email?>" disabled/>
				    </div>
					<div class="col-xs-4 form-group">
						<div class="btn-simpan-email" style="display:none">
							<button type="button" class="btn btn-primary btn-sm" id="simpan-email" >Simpan</button>
							<button type="button" class="btn btn-danger btn-sm" id="batal-simpan-email">Batal</button>
						</div>
						<div class="btn-edit-email">
							<button type="button" class="btn btn-success btn-sm" id="edit-email" >Edit</button>
						</div>
						<div class="pesan-email">
							
						</div>
						
				    </div>

				</form>

							<!--
							<form id="frm-pejabat">
							    <div class="col-xs-6 form-group">
							        <label>Nama</label>-->
							        <!--<input class="form-control" type="text" name="nama" id="nama" onkeyup="lihat(this.value)"/>-->
									<!--
							        <input class="form-control" type="text" name="nama_pejabat" id="nama_pejabat" value="<?=$nama_pejabat?>"/>
							    </div>
							    <div class="col-xs-6 form-group">
							        <label>PAF/Dept/Prodi</label>
							        <input class="form-control" type="text" name="unit_kerja" id="unit_kerja" value="<?=$unit_kerja?>"/>
							    </div>

							    <div class="clearfix"></div>
							    
							    <div class="col-xs-6 form-group">
							        <label>NPM/NIP/NUP</label>
							        <input class="form-control" type="text" name="nip_pejabat" id="nip_pejabat" value="<?=$nip_pejabat?>"/>
							    </div>
							    <div class="col-xs-6 form-group">
							        <label>Telepon</label>
							        <input class="form-control" type="text" name="telp" id="telp" value="<?=$telp?>"/>
							    </div>

							    <div class="clearfix"></div>
							    
							    <div class="col-xs-6 form-group">
							        <label>Jabatan</label>
							        <input class="form-control" type="text" name="jabatan" id="jabatan" value="<?=$jabatan?>"/>
							    </div>
							    <div class="col-xs-6 form-group">
							        <label>Email</label>
							        <input class="form-control" type="text" name="email" id="email" value="<?=$email?>"/>
							    </div>

							    <div class="clearfix"></div>
							   
							    <div class="col-xs-12 form-group">
							    	<button type="button" class="btn btn-primary btn-sm pull-right" id="simpan-pejabat" >Simpan</button>
							    </div>
							</form>
							-->
						</div>	
					</div>
				</div>

				<!-- data kegiatan -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">DATA KEGIATAN</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<form id="frm-kegiatan">
								<div class="col-xs-2 form-group">
							        <label>Nama Kegiatan</label>
							    </div>
							    <div class="col-xs-10 form-group">
							        <input class="form-control" type="text" name="nama_kegiatan" id="nama_kegiatan"/>
							    </div>

								<div class="clearfix"></div>
							    <div class="col-xs-2 form-group">
							        <label>Periode Penugasan</label>
							    </div>
							    <div class="col-xs-10 form-group">
							        <input class="form-control" type="text" name="tgl_kegiatan" id="tgl_kegiatan"/>
							    </div>
							    <!--
							    <div class="col-xs-2 form-group">
							        <label>Periode Penugasan</label>
							    </div>
							    <div class="col-sm-3 col-md-3 col-lg-3">
									<div class="input-group input-group-sm">
										<span class="input-group-addon">Tanggal Awal</span>
										<input type="text" class="form-control" name="tgl1" id="tgl1" class="tgl1" data-date-format="dd MM yyyy" value="<?=$tanggal?>" />
									</div>
							    </div>
								<div class="col-sm-3 col-md-3 col-lg-3">
									<div class="input-group input-group-sm">
										<span class="input-group-addon">Tanggal Akhir</span>
										<input type="text" class="form-control" name="tgl2" id="tgl2" class="tgl2" data-date-format="dd MM yyyy" value="<?=$tanggal?>" />
									</div>
								</div>
								-->
				
								<div class="clearfix"></div>
				
							    <div class="col-xs-2 form-group">
							        <label>Sumber Dana(*</label>
							    </div>
							    <div class="col-xs-10 form-group">
							    	<label class="checkbox-inline">
							    		<input name="sumber_dana" type="radio" value="1"/>
							    		PAU
							    	</label>
							    	<label class="checkbox-inline">
							    		<input name="sumber_dana" type="radio" value="2" checked="checked"/>
							    		PAF
							    	</label>
							    	<label class="checkbox-inline">
							    		<input name="sumber_dana" type="radio" value="3"/>
							    		Departemen/Prodi
							    	</label>
							    	<label class="checkbox-inline">
							    		<input name="sumber_dana" type="radio" value="4"/>
							    		Lain-lain
							    	</label>
							    </div>
								<input type="hidden" name="KodeBidang" id="KodeBidang" value="<?=$KodeBidang?>"/>
								<input type="hidden" name="kd_surtu" id="kd_surtu" value="0"/>
							    <div class="clearfix"></div>
							    <div class="col-xs-8" id="pesan-kegiatan" style="text-align:right; color:green;"></div> 
							    <div class="col-xs-4">
							    	<button type="button" class="btn btn-primary btn-sm" id="simpan-kegiatan" >Simpan</button>
							    </div> 
							</form>
						</div>
					</div>
				</div>


				<!-- Data Penunjang -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">DATA PENUNJANG</h3>
					</div>
					<div class="panel-body">
						<div id="data-penunjang">
							<table class="table table-bordered">
						 	<tr>
						 		<th>No</th>
						 		<th>Nama File</th>
						 		<th>View</th>
						 		<th>Hapus</th>
						 	</tr>
						 	<tr>
							 	<td>&nbsp;</td>
							 	<td>&nbsp;</td>
							 	<td>&nbsp;</td>
							 	<td>&nbsp;</td>	 		
						 	</tr>
							</table>
						</div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-xs-12 pull-right">
								<button type="button" id="tambah-data-penunjang" class="btn btn-success"><b>Tambah</b></button>
							</div>
						</div>
					</div>
				</div>

				<!-- Data Penugasan -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">DATA PENUGASAN</h3>
					</div>
					<div class="panel-body">
						<div id="data-penugasan"></div>
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-xs-12 pull-right">
								<button type="button" id="tambah-data-penugasan" class="btn btn-success" data-toggle="modal" data-target="#inputModal" data-whatever="@mdo"><b>Tambah</b></button>
							</div>
						</div>
					</div>
				</div>	
			</div>

			<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="inputModalLabel">Data Penugasan</h4>
						</div>
						<div class="modal-body" style="overflow:auto">
							<form id="frm-penugasan">
								<div class="form-group row">
									<div class="col-xs-8">
										<label for="nama">Nama yang Ditugaskan</label>
										<input name="nama" id="nama" type="text"  class="form-control col-xs-4" value="" placeholder="type keywords to search" autocomplete="off"/>
										
									</div>
									<div class="col-xs-3">
										<label for="ex2">&nbsp;</label>
										<input class="form-control btn btn-info btn-sm" type="reset" value="clear to search" id="clear-to-search" >
									</div>						
								</div>
								<div id="kotaksugest" ></div>
								<div class="clearfix"></div>
								<div class="form-group">
									<label for="nip">NPM/NIP/NUP</label>
									<input name="nip" id="nip" type="text"  class="form-control" value="" placeholder="NIP/NUP/NPM"/>
								</div>
								<div class="form-group">
									<label for="sebagai">Jabatan</label>
									<input name="sebagai" id="sebagai" type="text"  class="form-control" value="" placeholder="Jabatan/Sebagai"/>
								</div>
								<div class="form-group">
									<label for="bantuan">Keterangan</label>
									<input name="bantuan" id="bantuan" type="text"  class="form-control" value="" placeholder="Bantuan"/>
								</div>				 	
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-warning close-modal-penugasan" data-dismiss="modalx">Tutup</button>
							<button type="button" class="btn btn-primary" id="simpan-penugasan" >Simpan</button>
						</div>
					</div>
				</div>
			</div>
			<p><b>Results:</b> <span id="results"></span></p>
			<style type="text/css">
			table tr th {
				font-size: 14px;
				text-align:center;
			}
			</style>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-warning" data-dismiss="modal">Tutup</button>
				<!--<button type="button" class="btn btn-primary" id="simpan-penugasan" >Simpan</button>-->
			</div>
		</div>
	</div>
</div>

<!-- modal ajukan -->
<div class="modal fade" id="ajukanModal" tabindex="-1" role="dialog" aria-labelledby="ajukanModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="ajukanModalLabel">Pengajuan Surat Tugas</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="data-pengajuan"></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal View Dokumen -->
<div class="modal fade" id="viewDokumenModal" tabindex="-1" role="dialog" aria-labelledby="viewDokumenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title"style="text-align:center">Dokumen</h4>
        </div>
	      <div class="modal-body">
	        <!--<img src="dokumen/surtu/clipart-6-11-8-29-28.png">-->
	
	        <div id="dokumen-view"></div>
	        <!-- 
	        <div class="embed-responsive embed-responsive-10by1">
	          <iframe src="https://docs.google.com/gview?url=https://remun.ppaa.fisip.ui.ac.id/ijk/dokumen/C-01.doc &embedded=true" frameborder="0"></iframe>
	        </div>
	        -->
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
	      </div>
    	</div>
    </div>
</div>  

<?php include "surtu_list_unit_pagination_script.php"; ?>
<?php include "surtu_upload_modal.php"; ?>

<style>
table.frm-list thead {
	color: #fff;
  background-image: linear-gradient(to right, #614385 , #516395);
}

/* fix problem multiple modal scrollbar */
.modal { overflow: auto !important; }

input {
	border: 1px solid #aea5a5ff;
	font-size: 12px;
}

fieldset
{
	border: 1px solid #ddd !important;
	margin: 0;
	xmin-width: 0;
	padding: 5px;
	position: relative;
	border-radius:4px;
	background-color:#ffffff;
	padding-left:10px!important;
}

legend
{
	font-size:13px;
	font-weight:bold;
	margin-bottom: 0px;
	width: 35%;
	border: 1px solid #ddd;
	border-radius: 4px;
	padding: 2px 2px 2px 5px;
	background-color: #f5f5f5;
	color:
}
</style>