
<?php
if(!session_id()) session_start();
include "pdo.class.php";
//New PDO object
$pdo = new Database();
echo "<br>";
//set nip dan nama
$username = $_SESSION['username'];
$nip = $_SESSION['user_nip'];
$nama = (!empty($_SESSION['name'])) ? $_SESSION['name'] : '' ;

//set no telp, email dan unit kerja mengambil dari database jika tidak ada maka kosongkan
#ambil data user
$sql = "SELECT * FROM master_employee WHERE username = '$username'";
$pdo->query($sql);
$result = $pdo->resultset();
foreach ($result as $row){
	$id = $row['id'];
	$nip = $row['nip'];
	$nama = $row['nama_bergelar'];
	$kodebidang = $row['kodebidang'];
	$telp = $row['telp'];
	$email = $row['email'];
}
/*
$sql = "SELECT * FROM surtu_user WHERE username = '$username'";
$pdo->query($sql);
$result = $pdo->resultset();
foreach ($result as $row){
	$id = $row['id'];
	$nip = $row['nip'];
	$nama = (!empty($row['nama'])) ? $row['nama'] : $_SESSION['name'] ;
	$kodebidang = $row['kodebidang'];
	$telp = $row['telp'];
	$email = $row['email'];
	$KodeBidang = $row['KodeBidang']; //not work
}

$nama = (!empty($nama)) ? $nama : '' ;
*/
//set pilihan departemen dan fakultas
include_once('helper_unit_kerja.php');

$option = '';
foreach ($array_unit_kerja as $k => $v){
	if($k==$kodebidang){
		$option.= '<option value="'.$k.'" selected>'.$v.'</option>';
	} else {
		$option.= '<option value="'.$k.'">'.$v.'</option>';
	}
}

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

	<!--<div class="alert alert-danger" role="alert" style="text-align:center;font-weight:bold;font-size:14px;">
		Akses untuk penginputan Surat Tugas akan dibuka kembali pada hari Senin tanggal 5 Januari 2026<br>
	</div>-->

	<div class="panel panel-default">
		<!-- data pemohon -->
		<div class="panel-heading">
			<h3 class="panel-title">DATA PEMOHON</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<input class="form-control" type="hidden" name="id" id="id" value="<?=$id?>" />
				<form id="frm-pemohon">
				    <div class="col-xs-3 form-group">
				        <label>Nama</label>
				    </div>
				    <div class="col-xs-9 form-group">
				        <!--<input class="form-control" type="text" name="nama" id="nama" onkeyup="lihat(this.value)"/>-->
				        <input class="form-control" type="text" name="nama_pemohon" id="nama_pemohon" value="<?=$nama?>" />
				    </div>

				    <div class="col-xs-3 form-group">
				        <label>NIP/NUP</label>
				    </div>
				    <div class="col-xs-9 form-group">
				        <input class="form-control" type="text" name="nip_pemohon" id="nip_pemohon" value="<?=$nip?>" />
				    </div>

					<!--
				    <div class="col-xs-3 form-group">
				        <label>PAF/Dept/Prodi</label>
				    </div>
				    <div class="col-xs-9 form-group">
						<select name="unit_kerja" id="unit_kerja" class="form-control">
							<?=$option;?>
						</select>
				    </div>
					--> 

				    <div class="col-xs-3 form-group">
				        <label>PAF/Dept/Prodi</label>
				    </div>
				    <div class="col-xs-5 form-group">				        
						<select name="unit_kerja" id="unit_kerja" class="form-control" disabled>
							<?=$option;?>
						</select>
				    </div>					

					<div class="col-xs-4 form-group">
						<div class="btn-simpan-unit_kerja" style="display:none">
							<button type="button" class="btn btn-primary btn-sm" id="simpan-unit_kerja" >Simpan</button>
							<button type="button" class="btn btn-danger btn-sm" id="batal-simpan-unit_kerja">Batal</button>
						</div>
						<div class="btn-edit-unit_kerja">
							<button type="button" class="btn btn-success btn-sm" id="edit-unit_kerja" >Edit</button>
						</div>
						<div class="pesan-unit_kerja"></div>						
				    </div>
					<div class="clearfix"></div>
    				<!--
				    <div class="col-xs-3 form-group">
				        <label>Jabatan</label>
				    </div>
				    <div class="col-xs-9 form-group">
				        <input class="form-control" type="text" name="jabatan" id="jabatan" value="" disabled/>
				    </div>
					-->

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
			
			<br>
			<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
				<li>Pastikan isian data "PAF/Dept/Prodi" sesuai dengan unit kerja anda atau unit kerja yang akan memberikan persetujuan</li>
			</ul>
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
				        <label>Skala Kegiatan</label>
				    </div>
				    <div class="col-xs-10 form-group">
				    	<label class="checkbox-inline">
				    		<input name="skala" type="radio" value="nasional" checked="checked" id="nasional"/>
				    		Nasional
				    	</label>
				    	<label class="checkbox-inline">
				    		<input name="skala" type="radio" value="internasional" id="internasional"/>
				    		Internasional
				    	</label>
				    </div>
					<div class="clearfix"></div>

					<div class="col-xs-2 form-group">
				        <label>Nama Kegiatan</label>
				    </div>
				    <div class="col-xs-10 form-group">
				        <input class="form-control" type="text" name="nama_kegiatan" id="nama_kegiatan" />
				    </div>
					<!--<div style="padding-left: 250px;">
						<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px; ">
							<li><i>Pada pengisian nama kegiatan, harap menyertakan tempat penyelenggaraan dan nama penyelenggara</i></li>
						</ul>						
					</div>-->
					<div class="clearfix"></div>

					<div class="col-xs-2 form-group">
				        <label>Tempat Penyelenggaraan</label>
				    </div>
				    <div class="col-xs-10 form-group">
				        <input class="form-control" type="text" name="tempat" id="tempat" />
				    </div>
					<div class="clearfix"></div>

					<div class="col-xs-2 form-group">
				        <label>Penyelenggara</label>
				    </div>
				    <div class="col-xs-10 form-group">
				        <input class="form-control" type="text" name="penyelenggara" id="penyelenggara" />
				    </div>
					
				<div class="clearfix"></div>
					<!-- new -->
				    <div class="col-xs-2 form-group">
				        <label>Periode Penugasan</label>
				    </div>
				    <div class="col-xs-10 form-group">
				        <input class="form-control" type="text" name="tgl_kegiatan" id="tgl_kegiatan" />
				    </div>
					<!-- /new -->

					<!--
					<div class="clearfix"></div>
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
					end old -->

					<div class="clearfix"></div>
	
				    <div class="col-xs-2 form-group">
				        <label>Sumber Dana(*</label>
				    </div>
				    <div class="col-xs-10 form-group">
				    	<label class="checkbox-inline">
				    		<input name="sumber_dana" type="radio" value="1" id="sd1"/>
				    		PAU
				    	</label>
				    	<label class="checkbox-inline">
				    		<input name="sumber_dana" type="radio" value="2" checked="checked" id="sd2"/>
				    		PAF
				    	</label>
				    	<label class="checkbox-inline">
				    		<input name="sumber_dana" type="radio" value="3" id="sd3"/>
				    		Departemen/Prodi
				    	</label>
				    	<label class="checkbox-inline">
				    		<input name="sumber_dana" type="radio" value="4" id="sd4"/>
				    		Lain-lain
				    	</label>
				    </div>
					<input type="hidden" name="nip_pejabat" id="nip_pejabat" value="<?=$nip?>"/>
					<input type="hidden" name="KodeBidang" id="KodeBidang" value="<?=$kodebidang?>"/>
					<input type="hidden" name="kd_surtu" id="kd_surtu" value="0"/>
				    <div class="clearfix"></div>
				    <div class="col-xs-8" id="pesan-kegiatan" style="text-align:right; color:green;"></div> 
				    <div class="col-xs-4">
				    	<button type="button" class="btn btn-primary btn-sm" id="simpan-kegiatan" disabled>Simpan</button>
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
			<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
				<li>Data penunjang adalah data yang digunakan sebagai dasar penerbitan surat tugas</li>
				<li>Sebelum mengisi data penunjang, pastikan terlebih dahulu menyimpan data kegiatan</li>
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
			 		<th>Bantuan</th>
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
			<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
				<li>Silahkan tekan tombol <font class="label label-success">tambah</font> untuk mendaftarkan nama yang ditugaskan</li>
			</ul>

		</div>
	</div>
	
    <div class="col-xs-8"></div> 
    <div class="col-xs-4">
    	<a href="https://sdm.fisip.ui.ac.id/surattugas/?aWprPXN1cnR1X2xpc3RfdXNlcg" class="btn btn-info btn-sm">lihat daftar permohonan</a>
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
				<h4 class="modal-title" id="inputModalLabel"></h4>
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
						<label for="bantuan">Bantuan</label>
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
<!-- --><pre><p><b>Results:</b> <span id="results"></span></p></pre>
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

<?php include "surtu_form_user_script.php"; ?>
<?php include "surtu_upload_modal.php"; ?>