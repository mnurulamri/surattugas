
<?php
include "pdo.class.php";
//New PDO object
$pdo = new Database();

$nip = $_SESSION['user_nip'];
//$nip = '196510211993032001';
$sql = "SELECT DISTINCT a.id as id, a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, a.telp as telp, a.email as email, a.KodeBidang as KodeBidang
FROM pejabat a
LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang
WHERE kd_struktur = 1 AND CURDATE() BETWEEN start_date AND end_date 
	AND a.KodeBidang IN (
		SELECT kodebidang FROM surtu_user WHERE nip = '$nip'
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
//print_r($result);

//set tanggal
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

?>

<div class="container" style="width:75%; font-size:12px">
		<!-- data pemohon -->
		<div class="panel-heading">
			<h3 class="panel-title">DATA PEMOHON</h3>
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
				
			</div>	
		</div>
	</div>

	<!--
	<div class="panel panel-default">
		 data pemohon 
		<div class="panel-heading">
			<h3 class="panel-title">DATA PEMOHON</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<form id="frm-pejabat">
				    <div class="col-xs-2 form-group">
				        <label>Nama</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="nama" id="nama" onkeyup="lihat(this.value)"/>
				        <input class="form-control" type="text" name="nama_pejabat" id="nama_pejabat" value="<?=$nama_pejabat?>"/>
				    </div>
				    <div class="col-xs-2 form-group">
				        <label>PAF/Dept/Prodi</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="unit_kerja" id="unit_kerja" value="<?=$unit_kerja?>"/>
				    </div>

				    <div class="clearfix"></div>

				    <div class="col-xs-2 form-group">
				        <label>NIP/NUP</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="nip_pejabat" id="nip_pejabat" value="<?=$nip_pejabat?>"/>
				    </div>
				    <div class="col-xs-2 form-group">
				        <label>Telepon</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="telp" id="telp" value="<?=$telp?>"/>
				    </div>

				    <div class="clearfix"></div>
				    
				    <div class="col-xs-2 form-group">
				        <label>Jabatan</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="jabatan" id="jabatan" value="<?=$jabatan?>"/>
				    </div>
				    <div class="col-xs-2 form-group">
				        <label>Email</label>
				    </div>
				    <div class="col-xs-4 form-group">
				        <input class="form-control" type="text" name="email" id="email" value="<?=$email?>"/>
				    </div>

				    <div class="clearfix"></div>

				    <div class="col-xs-8 form-group">
				        <label></label>
				    </div>
				</form>
				
			</div>	
		</div>
	</div>
	-->
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
				    <div class="col-sm-3 col-md-3 col-lg-3">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Tanggal Awal</span>
							<input type="text" class="form-control" name="tgl1" id="tgl1" class="tgl1" data-date-format="dd MM yyyy" value="<?=$tanggal?>" />
						</div><!-- /input-group -->
				    </div>
					<div class="col-sm-3 col-md-3 col-lg-3">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Tanggal Akhir</span>
							<input type="text" class="form-control" name="tgl2" id="tgl2" class="tgl2" data-date-format="dd MM yyyy" value="<?=$tanggal?>" />
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
	
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
					<input type="hidden" name="nip_pejabat" id="nip_pejabat" value="<?=$nip_pejabat?>"/>
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
					<button type="button" id="tambah-data-penunjang" class="btn btn-success" disabled="true"><b>Tambah</b></button>
				</div>
			</div>
			<br>
			<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;" id="info-persetujuan">
				<li>Data penunjang adalah data yang digunakan sebagai dasar penerbitan surat tugas</li>
				<li>Silahkan tekan tombol <font class="label label-success">tambah</font> untuk mengisi data penunjang</li>
			</ul>
		</div>
	</div>
	
	
	<!-- Data Penugasan -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">DATA PENUGASAN</h3>
		</div>
		<div class="panel-body">
			<div id="data-penugasan">
				<table class="table table-bordered">
			 	<tr>
			 		<th>No</th>
			 		<th>Nama yang ditugaskan</th>
			 		<th>NIP/NUP/NPM</th>
			 		<th>Jabatan/Sebagai</th>
			 		<th>Keterangan</th>
			 	</tr>
			 	<tr>
				 	<td>&nbsp;</td>
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
					<button type="button" id="tambah-data-penugasan" class="btn btn-success" data-toggle="modal" data-target="#inputModal" data-whatever="@mdo" disabled="true"><b>Tambah</b></button>
				</div>
			</div>
			<br>
			<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;" id="info-persetujuan">
				<li>Silahkan tekan tombol <font class="label label-success">tambah</font> untuk mendaftarkan nama yang ditugaskan</li>
			</ul>
		</div>
	</div>
	
    <div class="col-xs-8"></div> 
    <div class="col-xs-4">
    	<a href="https://sdm.fisip.ui.ac.id/surattugas/?aWprPXN1cnR1X2xpc3Q" class="btn btn-info btn-sm">daftar pengajuan</a>
    </div> 
	<br><br><br>
	<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
		<li>Setelah mengisi kelengkapan data permohonan, selanjutnya silahkan tekan tombol <font class="label label-info">daftar pengajuan</font> untuk melihat daftar permohonan yang sudah diinput</li>
	</ul>
	
</div>

<div class="modal fade" id="inputModal" tabindex="-1" role="dialog" aria-labelledby="inputModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="inputModalLabel">Test</h4>
			</div>
			<div class="modal-body">
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
						<label for="nip">NIP/NUP/NPM</label>
						<input name="nip" id="nip" type="text"  class="form-control"value="" placeholder="NIP/NUP/NPM"/>
					</div>
					<div class="form-group">
						<label for="sebagai">Jabatan</label>
						<input name="sebagai" id="sebagai" type="text"  class="form-control"value="" placeholder="Jabatan/Sebagai"/>
					</div>
					<div class="form-group">
						<label for="bantuan">Keterangan</label>
						<input name="bantuan" id="bantuan" type="text"  class="form-control"value="" placeholder="Bantuan"/>
					</div>				 	
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-warning" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" id="simpan-penugasan" >Simpan</button>
				
			</div>
		</div>
	</div>
</div>
<!--<p><b>Results:</b> <span id="results"></span></p>-->
<style type="text/css">
table tr th {
	font-size: 14px;
	text-align:center;
}
.panel-heading{
	background: #1CA9C9;
	background: linear-gradient(to bottom, #1CA9C9 0%, #0D9ABA 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #1CA9C9), color-stop(100%, #0D9ABA));
	background: -webkit-linear-gradient(top, #1CA9C9 0%, #0D9ABA 100%);
	background: -moz-linear-gradient(top, #1CA9C9 0%, #0D9ABA 100%);
	background: -o-linear-gradient(top, #1CA9C9 0%, #0D9ABA 100%);
	background: -ms-linear-gradient(top, #1CA9C9 0%, #0D9ABA 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#1CA9C9', endColorstr='#0D9ABA', GradientType=0);
	border: 1px solid #008BAB;
	box-shadow: inset 0 1px 0 #2BB8D8;
	-webkit-box-shadow: inset 0 1px 0 #2BB8D8;
	-moz-box-shadow: inset 0 1px 0 #2BB8D8;
}
h3 {
	text-align: center;
	color: #fff !important;
	text-shadow: -1px 0 #0D9ABA, 0 1px #0D9ABA, 1px 0 #0D9ABA, 0 -1px #0D9ABA !important;
	font-weight: bold;
}
#data-penugasan, #data-penunjang {
	overflow : auto;
}
</style>

<?php include "surtu_form_script.php"; ?>
<?php include "surtu_upload_modal.php"; ?>