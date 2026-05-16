<pre>
<?php
echo "test"; exit();
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');

//include "pdo.class.php";
//New PDO object
//$pdo = new Database();

#echo $nip = $_SESSION['user_nip'];

/*
$sql = "SELECT a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, telp, c.email as email
FROM pejabat a
LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang
LEFT OUTER JOIN snapshoot c ON a.nip = REPLACE(c.nip, '\'', '')
WHERE a.nip = '$nip'";
*/
$sql = "SELECT DISTINCT a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, a.telp as telp, a.email as email, a.KodeBidang as KodeBidang
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
$hari = $nama_hari[$kd_hari];
//set bulan
$nama_bulan = array(' ','Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$bulan = $nama_bulan[$m];
$tanggal = $d.' '.$bulan.' '.$y;

?>
</pre>
<div class="container">

	<div class="panel panel-default">
		<!-- data pemohon -->
		<div class="panel-heading">
			<h3 class="panel-title">DATA PEMOHON</h3>
		</div>
		<div class="panel-body">
			<div class="row">
				<form id="frm-pejabat">
				    <div class="col-xs-6 form-group">
				        <label>Nama</label>
				        <!--<input class="form-control" type="text" name="nama" id="nama" onkeyup="lihat(this.value)"/>-->
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
				   <!--
				    <div class="col-xs-12 form-group">
				    	<button type="button" class="btn btn-primary btn-sm pull-right" id="simpan-pejabat" >Simpan</button>
				    </div>
					-->
				</form>
				
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
					<input type="hidden" name="KodeBidang" id="KodeBidang" value="<?=$KodeBidang?>"/>
					<input type="text" name="kd_surtu" id="kd_surtu" value="0"/>
				    <div class="clearfix"></div>
				    <div class="col-xs-8"></div> 
				    <div class="col-xs-4">
				    	<button type="button" class="btn btn-primary btn-sm" id="simpan-kegiatan" >Simpan</button>
				    </div> 
				</form>
			</div>
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
				 	<td>...</td>
				 	<td>...</td>
				 	<td>...</td>
				 	<td>...</td>
				 	<td>...</td>			 		
			 	</tr>
				</table>
			</div>
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
				<h4 class="modal-title" id="inputModalLabel">New message</h4>
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
						<label for="nip">NIP/NUP/NPM</label>
						<input name="nip" id="nip" type="text"  class="form-control" value="" placeholder="NIP/NUP/NPM"/>
					</div>
					<div class="form-group">
						<label for="sebagai">Jabatan</label>
						<input name="sebagai" id="sebagai" type="text"  class="form-control" value="" placeholder="Jabatan/Sebagai"/>
					</div>
					<div class="form-group">
						<label for="bantuan">Bantuan</label>
						<input name="bantuan" id="bantuan" type="text"  class="form-control" value="" placeholder="Bantuan"/>
					</div>				 	
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-warning close-modal-penugasan" data-dismiss="modalx">Batal</button>
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
</style>

<script type="text/javascript">
$(document).ready(function(){

	var kd_surtu = '0';

	$("#simpan-pejabat").on("click", function () {
		var field_pejabat = $("#frm-pejabat input").serializeArray();
		field_pejabat.push({ name: "crud", value: 1 });

		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: field_pejabat,
			success: function(data)   // A function to be called if request succeeds
			{
				$("#results").html(data);
			}					
		});
	})

	$("#simpan-kegiatan").on("click", function () {
		//alert("u n d e r c o n s t r u c t i o n")
		$("#results").html("");
		var field_kegiatan = $("#frm-kegiatan input").serializeArray();
		field_kegiatan.push({ name: "crud", value: 2 });

		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			dataType: "json",
			data: field_kegiatan,
			success: function(data)   // A function to be called if request succeeds
			{
				$("#results").html('<pre>'+data.sql+'</pre>');
				$("#kd_surtu").val(data.kd_surtu)
				kd_surtu = data.kd_surtu
			}			
		});
	})

	$("#inputModal").on("show.bs.modal", function () {
		
		$("#nip").text("")
		$("#nama").text("")
		$("#sebagai").text("")
		$("#bantuan").text("")
		$("#kotaksugest").text("")
		$("#nama").focus()
	})
	
	$(document).on("keyup", "#nama", function(){
		var kata = $("#nama").val()
		
		$.ajax({
			url: "views/surtu_cari_nama.php", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: {q:kata}, 	//  -> Data sent to server, a set of key/value pairs (i.e. form fields and values)
			success: function(data)   // A function to be called if request succeeds
			{
				$("#kotaksugest").html(data);
			}					
		});
	})

	$(document).on("click", ".isi", function(){
		var nip = $(this).children().eq(0).text()
		var nama = $(this).children().eq(1).text()
		$("#kotaksugest").text("")
		$("#nip").val(nip)
		$("#nama").val(nama)
	})
	
	$(document).on("click", "#clear-to-search", function(){
		$("#nama").focus()
		$("#kotaksugest").text("")
	})
	
	$("#simpan-penugasan").click(function(){
		
		var fields = $("#frm-penugasan input").serializeArray();
		fields.push({ name: "crud", value: 3 });
		fields.push({ name: "kd_surtu", value: kd_surtu });
		
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: fields,
			success: function(data)   // A function to be called if request succeeds
			{
				$("#results").html('<pre>'+data+'</pre>');
			}					
		});
		
		$.ajax({
			url: "views/surtu_penugasan_data.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penugasan").html(data)
			},
			complete: function(data) {
                setTimeout(function() { $('#inputModal').modal('hide'); }, 2300);
            }           
		});
		
	})
	
	$(".close-modal-penugasan").click(function(){
		$("#inputModal").modal("hide")
	})
	
	
	//$(document).on("click", ".delete_penugasan", function(){
	$(".delete_penugasan").click(function(){
		var id = $(this).data("id")
		alert(id)
		/*
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: {id:id, crud:13},
			success: function(data)   // A function to be called if request succeeds
			{
				//$("#results").html('<pre>'+data+'</pre>');
				console.log(data)
				alert(data)
			}					
		});
		
		$.ajax({
			url: "views/surtu_penugasan_data.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penugasan").html(data)
			}
		});*/
	})
	
})

$('#tgl1, #tgl2').datepicker({autoclose: true,language: "id"}).on('changeDate', function(){
	var nip = $('#nip').val();
	var tgl1 = $('#tgl1').val();
	var tgl2 = $('#tgl2').val();

	var first = tanggal(tgl1);
	var second = tanggal(tgl2);

	$('.pesan').html('');

	if(parseInt(first.replace(/-/g,""),10) > parseInt(second.replace(/-/g,""),10)){
		$('.pesan').html('<h1 class="label" style="background:#ED4337; font-size:11px">tanggal awal lebih besar dari tanggal akhir!</h1>');
		$('#tgl1').hide().show();
		return false;
	} else {
		$.ajax({
			type: "POST",
			url: "views/form_lembur_presensi_temp.php",
			data: {nip:nip, tgl1:tgl1, tgl2:tgl2},
			success: function(data){
				$('#data').html(data);
				clock.start();
			}
		});	
	}
});

function tanggal(tgl){
	var array = tgl.split(' ');
	var d = array[0];
	var month = array[1];
	var y = array[2];

	var months = {Januari:"01", Februari:"02", Maret:"03", April:"04", Mei:"05", Juni:"06", Juli:"07", Agustus:"08", September:"09", Oktober:"10", November:"11", Desember:"12"};
	var m = months[month];
	var tgl = y + '-' + m + '-' + d;
	return tgl;
}
</script>
