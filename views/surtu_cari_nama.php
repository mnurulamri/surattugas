
<?php
include "pdo.class.php";
$pdo = new Database();

//ambil data karwayan
$kata = $_POST['q'];
$sql = "SELECT REPLACE(nip, '\'','') as nip, nama_bergelar as nama
FROM master_employee
WHERE nama LIKE '%$kata%'
LIMIT 20";
$pdo->query($sql);
$result = $pdo->resultset();
foreach ($result as $row){
	$nip = $row['nip'];
	$nama = $row['nama'];
}
#print_r($result);

if(count($result)>0){
echo '
<table class="autocomplete" cellspacing="0">
	<tr>
		<th>NPM/NIP/NUP</th>
		<th>Nama</th>
	</tr>';
	foreach ($result as $row){
		echo '

		<tr class="isi" id="'.$nip.'">
			<td>'.$row['nip'].'</td>
			<td>'.$row['nama'].'</td>
		</tr>';
	}
echo '
	</table>';
} else {
	echo '';
}
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
	font-size: 12px;
}
table.autocomplete tr td {
	background-color: #fafafa;
	border-bottom: 1px solid lightgray;
	padding: 5px;
	font-size: 12px;
}
</style>