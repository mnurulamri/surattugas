<?php
include_once("../models/conn.php");
//if(!session_id()) session_start();
//$kd_organisasi = $_SESSION["kode"];
$kata = $_POST['q'];
#$query = mysql_query("select distinct namapengajar, nip from kalban where kodeorganisasi='$kd_organisasi' and namapengajar like '%$kata%' limit 10");
//$query = mysql_query("select distinct nama_pengajar, nip, ket from master_pengajar where nama_pengajar like '%$kata%' limit 10");
//$query = mysql_query("select distinct nama_pengajar, nip from gaji_detail_2 where nama_pengajar like '%$kata%' limit 10");

/*$sql = "SELECT DISTINCT nama_pengajar, nip FROM gaji_detail_2 WHERE nama_pengajar like '%$kata%' limit 15
UNION DISTINCT
SELECT namapengajar, nip FROM kalban WHERE tahun>= 2018 AND namapengajar like '%$kata%' limit 15";*/
$sql = "SELECT nama as nama_pengajar, user_nip as nip FROM view_nama_pengajar WHERE nama like '%$kata%' limit 15";
$query = mysql_query($sql) or die(mysql_error());

//echo "<div class='suggestionsBox'><div class='suggestionList'>";
echo '
<table class="autocomplete">
	<tr>
		<th>Nama</th>
		<th>NPM/NIP/NUP</th>
	</tr>';
	while($k = mysql_fetch_array($query)){
		echo '

		<tr class="isi" id="'.$k[1].'">
			<td>'.$k[0].'</td>
			<td>'.$k[1].'</td>
		</tr>';
	}
echo '
	</table>';
?>

<style>
table.autocomplete {
	width:400px;
	position: absolute;
	z-index: 99;
}
table.autocomplete tr {
	cursor: pointer;
}
table.autocomplete tr th {
	background-color: lightgray;
	border: 1px solid lightgray;
	padding: 5px;	
}
table.autocomplete tr td {
	background-color: #fafafa;
	border: 1px solid lightgray;
	padding: 5px;
}
</style>
