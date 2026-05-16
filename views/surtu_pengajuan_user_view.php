<?php
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');
if(!session_id()) session_start();
include "pdo.class.php";
$pdo = new Database();

#set variabel
$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
$nip = $_SESSION['user_nip']; //'090613091';
$username = $_SESSION['username'];
$flag = htmlspecialchars($_POST['flag']);

# script untuk form edit -> mengambil data user pertama yang nginput
//$sql = "SELECT * FROM surtu_user WHERE username = '$username';";
$sql = "SELECT * FROM master_employee WHERE username = '$username'";
$pdo->query($sql);
$result = $pdo->resultset();
foreach ($result as $row){
	$nip = $row['nip'];
	$nama = $row['nama'];
	$telp = $row['telp'];
	$email = $row['email'];
	$kodebidang = $row['kodebidang'];
}

# array unit kerja
include_once('helper_unit_kerja.php');

#fetch kegiatan
$sql = "SELECT *
		FROM surtu_kegiatan a
		WHERE kd_surtu = '$kd_surtu'";
$pdo->query($sql);
$result_kegiatan = $pdo->resultset();

$_sumber_dana = array(
	'1' => 'PAU',
	'2' => 'PAF',
	'3' => 'Departemen/Prodi',
	'4' => 'Lain-lain'
);

foreach ($result_kegiatan as $row){
	$nama_kegiatan = $row['nama_kegiatan'];
	$tgl_kegiatan = $row['tgl_kegiatan'];
	$sumber_dana = $_sumber_dana[$row['sumber_dana']];
	$start_date = $row['start_date']; //$start_date = dbToTanggal($row['start_date']);
	$end_date = $row['end_date'];
	$periode = $start_date.' - '.$end_date;
}
#print_r($result_kegiatan);

#fetch penugasan
$sql = " SELECT * FROM surtu_penugasan WHERE kd_surtu = '$kd_surtu' "; 
$pdo->query($sql);
$result_penugasan = $pdo->resultset();
#print_r($result_penugasan);

#cetak data

echo 
'<table class="table-ajukan">
	<tr>
		<th colspan="2" class="head-label">Data Pemohon</th>
	</tr>
	<tr>
		<td>Nama</td><td>: '.$nama.'</td>
	</tr>
	<tr>
		<td>NPM/NIP/NUP</td><td>: '.$nip.'</td>
	</tr>
	<tr>
		<td>PAF/Dept/Prodi</td><td>: '.$array_unit_kerja[$kodebidang].'</td>
	</tr>
	<tr>
		<td>Telp</td><td>: '.$telp.'</td>
	</tr>
	<tr>
		<td>e-Mail</td><td>: '.$email.'</td>
	</tr>
	<tr>
		<td colspan="2" class="kosong">&nbsp;</td>
	</tr>
	<tr>
		<th colspan="2" class="head-label">Data Kegiatan</th>
	</tr>
	<tr>
		<td>Nama Kegiatan</td><td id="_nama_kegiatan">: '.$nama_kegiatan.'</td>
	</tr>
	<tr>
		<td>Periode Penugasan</td><td>: '.$tgl_kegiatan.'</td>
	</tr>
	<!--
	<tr>
		<td>Periode Penugasan</td><td>: '.$periode.'</td>
	</tr>
	-->
	<tr>
		<td>Sumber Dana(*</td><td>: '.$sumber_dana.'</td>
	</tr>
	<tr>
		<td colspan="2" class="kosong">&nbsp;</td>
	</tr>
	<tr>
		<th colspan="2" class="head-label">Data Penugasan</th>
	</tr>
	<tr>
		<td colspan="2">
			<table>
				<tr style="font-weight:bold">
					<td>No</td>
					<td>Nama yg Ditugaskan</td>
					<td>NIP/NUP</td>
					<td>Jabatan/Sebagai</td>
					<td>Keterangan</td>
				</tr>';
				$no=1;
				foreach ($result_penugasan as $row){
					echo '
					<tr>
						<td>'.$no.'</td>
						<td>'.$row['nama'].'</td>
						<td>'.$row['nip'].'</td>
						<td>'.$row['sebagai'].'</td>
						<td>'.$row['bantuan'].'</td>
					</tr>';
					$no++;
				}
		echo '
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="kosong" style="border-top:1px solid #fff; border-bottom:1px solid #fff;">&nbsp;</td>
	</tr>';
	
if($flag==0){ // jika user menekan tombol view
	echo '
	<tr>
		<td style="border-top:1px solid #fff; border-bottom:1px solid #fff;">
			<div class="pesan">&nbsp;</div>
		</td>
		<td style="text-align:right; padding-right:10px; border-top:1px solid #fff; border-bottom:1px solid #fff">
			<button type="button" class="btn btn-warning" data-dismiss="modal">tutup</button>
		</td>
	</tr>
</table>';
	
} else { // jika user menekan tombol ajukan
	echo '
	<tr>
		<td style="border-top:1px solid #fff; border-bottom:1px solid #fff;">
			<div class="pesan">&nbsp;</div>
		</td>
		<td style="text-align:right; padding-right:10px; border-top:1px solid #fff; border-bottom:1px solid #fff">
			<button type="button" class="btn btn-primary" id="ajukan" >ajukan</button>
			<button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Batal</button>
		</td>
	</tr>
</table>';
}

function dbToTanggal($tanggal)
{
	if ($tanggal != '0000-00-00') {
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
	} else {
		# code...
	}
}
?>

<script>
//eksekusi pengajuan
	$("#ajukan").click(function(){
		var kd_surtu = "<?php echo $kd_surtu; ?>"
		//var nama_kegiatan = "<?php echo $nama_kegiatan; ?>"
		var nama_kegiatan = $("#_nama_kegiatan").text()
		var crud = 26
		//alert(kd_surtu + ' ' + nama_kegiatan)
		
		//eksekusi data yang diajukan
		var r = confirm("Anda akan mengajukan surat tugas " + nama_kegiatan + "?");
		if (r == true) {
			$.ajax({
				url: "views/surtu_crud.php",
				type: "POST",
				data: {kd_surtu:kd_surtu, crud:crud},
				success: function(data)
				{
					$(".pesan").html(data)
				},
				complete: function(data)
				{
					//$(".pesan").html("data sudah diajukan")
					setTimeout(function() { $('#ajukanModal').modal('hide'); }, 300);
				}
			})
		}
		
	})
</script>

<style>
.table-ajukan {
	margin:auto;
	font-size:12px;
	font-weight: bold;
	color:#555;
}
.table-ajukan tr th{
    /*background: #dedede; #35A9DB;    
    font-weight: bold;    
    border-top: 1px solid #fcfcfc;
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;*/
    text-align: center;
    color: #fff;
}
.table-ajukan tr td{
	padding: 5px;
	border-bottom: 1px solid #dcdcdc;
}
table.table-ajukan tr:nth-child(even) {
    /*background-color: #fcfcfc;*/
}
.kosong{
    border-left: 1px solid #fff;
    border-right: 1px solid #fff;
    border-top: 1px solid #fff;
    border-bottom: 1px solid #fff;
}
.head-label{
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
table.data-penunjang thead tr th, table.data-penugasan thead tr th{
	background: #eeeeee;
	color: #555;
}
</style>