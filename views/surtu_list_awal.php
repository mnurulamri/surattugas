
<?php
ini_set('display_errors', 1);
include "pdo.class.php";
//include "fungsi_dbtotanggal.php";
//New PDO object
$pdo = new Database();

#script untuk surtu list
$nip = $_SESSION['user_nip']; //'090613091'; 
$sql = "SELECT a.* , NamaBidang as unit_kerja
		FROM surtu_kegiatan a
		LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang AND a.KodeBidang IN 
		(
			SELECT KodeBidang
			FROM pejabat
			WHERE nip = '$nip' AND CURDATE() BETWEEN start_date AND end_date
		) ";
$pdo->query($sql);
$result_kegiatan = $pdo->resultset();
//print_r($result);

#set nama unit kerja
foreach ($result_kegiatan as $row){
	$unit_kerja = $row['unit_kerja'];
}

#script untuk form edit
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

#cetak tabel
table_header($unit_kerja);
table_content($result_kegiatan);

function table_header($unit_kerja){
	$html = '
	<table class="table frm-list">
		<label>Daftar Permohohan Surat Tugas<br>'.$unit_kerja.'</label>
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Kegiatan</th>
				<th>Periode</th>
				<th>Sumber Dana</th>
				<th>Status Persetujuan</th>
				<th colspan="2"></th>
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
		$kd_surtu = $row['kd_surtu'];
		$nama_kegiatan = $row['nama_kegiatan'];
		$sumber_dana = $_sumber_dana[$row['sumber_dana']];
		$start_date = dbToTanggal($row['start_date']);
		$end_date = dbToTanggal($row['end_date']);
		$periode = $start_date.' - '.$end_date;
		$status = $_status[$row['status']];
		
		$html.= '
			<tr id="'.$kd_surtu.'">
				<td>'.$no.'</td>
				<td>'.$nama_kegiatan.'</td>
				<td data-tgl1="'.$start_date.'" data-tgl2="'.$end_date.'">'.$periode.'</td>
				<td data-sumber-dana="'.$row['sumber_dana'].'">'.$sumber_dana.'</td>
				<td>'.$status.'</td>
				<td class="edit btn btn-success btn-xs">edit</td>
				<td class="delete btn btn-danger btn-xs">delete</td>
			</tr>';
		$no++;
	}
	$html.='</tbody></table>';
	
	echo $html;
}

function dbToTanggal($tanggal)
{
	$array = explode('-', $tanggal);
	//set tanggal
    $d = $array[2];
    $m = $array[1];
    $y = $array[0];
	//set hari
	$nama_hari = array( '0' => 'Minggu', '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis', '5' => 'Jumat', '6' => 'Sabtu' );
	$kd_hari = date("w", mktime(0, 0, 0, $m, $d, $y));
	$hari = $nama_hari[$kd_hari];
	//set bulan
	$nama_bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$bulan = $nama_bulan[$m];
    $tanggal = $d.' '.$bulan.' '.$y;
    return $tanggal;
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
	<div class="modal-dialog" role="document" style="width:75%;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="editModalLabel">Edit Surat Tugas</h4>
			</div>
			<div class="modal-body" style="overflow:auto">

			<div class="containerx">

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
							   
							    <div class="col-xs-12 form-group">
							    	<button type="button" class="btn btn-primary btn-sm pull-right" id="simpan-pejabat" >Simpan</button>
							    </div>
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
						 		<th>Bantuan</th>
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
			</style>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-warning" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" id="simpan-penugasan" >Simpan</button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$(".edit").click(function(){
		$("#editModal").modal("show")
		var kd_surtu = $(this).parent().attr("id")
		$("#kd_surtu").val(kd_surtu)

		//fetch data kegiatan
		var nama_kegiatan = $(this).parent().find("td").eq(1).text()
		var tgl1 =  $(this).parent().find("td").eq(2).data("tgl1")
		var tgl2 =  $(this).parent().find("td").eq(2).data("tgl2")
		$("#nama_kegiatan").val(nama_kegiatan)
		$("#tgl1").val(tgl1)
		$("#tgl2").val(tgl2)

		//fetch data penugasan
		$.ajax({
			url: "views/surtu_penugasan_data.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penugasan").html(data)
			}         
		});
	})
})
</script>

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

	$("#inputModal").on("shown.bs.modal", function () {
		
		$("#nip").text("")
		$("#nama").text("")
		$("#sebagai").text("")
		$("#bantuan").text("")
		$("#kotaksugest").text("")
		$("#nama").focus()
	})
	
	$("#inputModal").on("hidden.bs.modal", function () {
		$(".frm-list tbody").html("")
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