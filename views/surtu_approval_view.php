
<?php
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');
session_start();

include "pdo.class.php";
$pdo = new Database();
include "surtu_function.php";

#set variabel
$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
$nip = htmlspecialchars($_POST['nip']);
#echo $kd_surtu.' '.$nip;

#fetch pejabat
/*$sql = "SELECT DISTINCT a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, a.telp as telp, a.email as email, a.KodeBidang as KodeBidang
FROM pejabat a
LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang
WHERE a.nip = '$nip'";
*/

# fetch pejabat versi 2
/*$sql = "SELECT DISTINCT a.id as id, a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, a.telp as telp, a.email as email, a.KodeBidang as KodeBidang
FROM pejabat a
LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang
WHERE kd_struktur = 1 AND CURDATE() BETWEEN start_date AND end_date 
	AND a.KodeBidang IN (
		SELECT kodebidang FROM master_employee WHERE nip = '$nip'
	)";
*/

/*  
	fetch pejabat versi 3
	data pejabat diambil dari kegiatan yang sudah disetujui oleh kepala unit
	cek dulu apakah kegiatannya sudah disetujui kepala unit
	jika sudah disetujui maka ambil data dari tabel surtu_kegiatan
	jika belum maka ambil data dari pejabat/kepala unit yang bertugas saat ini dari tabel pejabat
*/

# cek apakah apakah kegiatannya sudah disetujui kepala unit
$sql = "SELECT nip_approval_unit FROM surtu_kegiatan WHERE kd_surtu = '$kd_surtu'";
$pdo->query($sql);
$result = $pdo->resultset();
foreach ($result as $row){
	$nip_pejabat = $row['nip_approval_unit'];
}

# set pejabat
if ($nip_pejabat != '') {
	# jika ada nip maka ambil data dari tabel surtu_kegiatan
	$sql = "SELECT DISTINCT b.id as id, a.nip_approval_unit as nip_pejabat, b.nama as nama_pejabat, a.KodeBidang as KodeBidang, jabatan, b.telp as telp, b.email as email, NamaBidang as unit_kerja
	FROM surtu_kegiatan a
	LEFT JOIN pejabat b ON a.nip_approval_unit = b.nip
	LEFT JOIN TblBidangDetail c ON a.KodeBidang = c.KodeBidang
	WHERE kd_surtu = '$kd_surtu'";	
} else {
	# jika tidak ada nip maka ambil data dari pejabat/kepala unit yang bertugas saat ini
	$sql = "SELECT DISTINCT a.id as id, a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, a.telp as telp, a.email as email, a.KodeBidang as KodeBidang
	FROM pejabat a
	LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang
	WHERE kd_struktur = 1 AND CURDATE() BETWEEN start_date AND end_date 
		AND a.KodeBidang IN (
			SELECT kodebidang FROM master_employee WHERE nip = '$nip'
		)";
}

# eksekusi query
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

#fetch kegiatan
$_sumber_dana = sumber_dana();
$sql = "SELECT *
		FROM surtu_kegiatan a
		WHERE kd_surtu = '$kd_surtu'";
$pdo->query($sql);
$result_kegiatan = $pdo->resultset();
foreach ($result_kegiatan as $row){
	$nama_kegiatan = $row['nama_kegiatan'];
	$tgl_kegiatan = $row['tgl_kegiatan'];
	$sumber_dana = $_sumber_dana[$row['sumber_dana']];
	$start_date = $row['start_date'];
	$end_date = $row['end_date'];
	$periode = $start_date.' - '.$end_date;
}

#fetch data penunjang
$sql = " SELECT * FROM surtu_penunjang WHERE kd_surtu = '$kd_surtu' "; 
$pdo->query($sql);
$result_penunjang = $pdo->resultset();

#print_r($result_penunjang);

#fetch penugasan
$sql = " SELECT * FROM surtu_penugasan WHERE kd_surtu = '$kd_surtu' "; 
$pdo->query($sql);
$result_penugasan = $pdo->resultset();
#print_r($result_penugasan);

echo '
<input type="hidden" id="kode-surtu" value="'.$kd_surtu.'">
<table class="table-ajukan">
	<tr>
		<th colspan="2" class="head-label">Data Pejabat</th>
	</tr>
	<tr>
		<td>Nama</td><td>: '.$nama_pejabat.'</td>
	</tr>
	<tr>
		<td>NIP/NUP</td><td>: '.$nip_pejabat.'</td>
	</tr>
	<tr>
		<td>Jabatan</td><td>: '.$jabatan.'</td>
	</tr>
	<tr>
		<td>PAF/Dept/Prodi</td><td>: '.$unit_kerja.'</td>
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
		<td>Nama Kegiatan</td><td>: '.$nama_kegiatan.'</td>
	</tr>
	<tr>
		<td>Periode Penugasan</td><td>: '.$tgl_kegiatan.'</td>
	</tr>
	<tr>
		<td>Sumber Dana(*</td><td>: '.$sumber_dana.'</td>
	</tr>
	<tr>
		<td colspan="2" class="kosong">&nbsp;</td>
	</tr>
	<tr>
		<th colspan="2" class="head-label">Data Penunjang</th>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom: 1px solid #fff;">';
		
$html = '
	<table class="table table-bordered data-penunjang">
		<thead>
			<tr>
		 		<th>No</th>
		 		<th>Nama File</th>
		 		<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>';
	$no=1;
	if(count($result_penunjang)>0){
		foreach ($result_penunjang as $row){
			$html.= '
				<tr>
					<td>'.$no.'</td>
					<td>'.$row['file_name'].'</td>
					<td class="view_dok" data-id="'.$row['id'].'"><div class="btn btn-info btn-xs">view</div></td>
				</tr>';
				$no++;
		}
		$html.='</tbody></table>';
		echo $html;
	} else {
		$html.=  '
				<tr>
				 	<td>&nbsp;</td>
				 	<td>&nbsp;</td>
				 	<td>&nbsp;</td>
				 	<td>&nbsp;</td>		 		
			 	</tr>
			</tbody>
		</table>';
		echo $html;
	}
echo '
		</td>
	</tr>
	<tr>
		<th colspan="2" class="head-label">Data Penugasan</th>
	</tr>
	<tr>
		<td colspan="2" style="border-bottom: 1px solid #fff;">
			<table class="data-penugasan">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama yg Ditugaskan</th>
						<th>NPM/NIP/NUP</th>
						<th>Jabatan/Sebagai</th>
						<th>Bantuan</th>
					</tr>
				</thead>
				<tbody>';
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
				</tbody>
			</table>
		</td>
	</tr>
</table>';
?>

<div id="test-script"></div>
<script type="text/javascript">

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
	border-bottom: 1px solid #ccc;
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