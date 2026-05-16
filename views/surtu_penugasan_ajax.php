<?php
ini_set('display_errors', 1);
include "pdo.class.php";
$pdo = new Database();
$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
//$kd_surtu = 'bc320e2a2a23746f95d6';
$sql = " SELECT * FROM surtu_penugasan WHERE kd_surtu = '$kd_surtu' "; 
$pdo->query($sql);
$result = $pdo->resultset();

//print_r($result);
	$html = '
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama yg Ditugaskan</th>
				<th>NPM/NIP/NUP</th>
				<th>Jabatan/Sebagai</th>
				<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>';
	$no=1;
	foreach ($result as $row){
		$html.= '
			<tr>
				<td>'.$no.'</td>
				<td>'.$row['nama'].'</td>
				<td>'.$row['nip'].'</td>
				<td>'.$row['sebagai'].'</td>
				<td>'.$row['bantuan'].'</td>
				<td class="edit_penugasan" data-id="'.$row['id'].'" data-nama="'.$row['nama'].'" data-nip="'.$row['nip'].'" data-sebagai="'.$row['sebagai'].'" data-bantuan="'.$row['bantuan'].'"><div class="btn btn-success btn-xs">edit</div></td>
				<td class="delete_penugasan" data-id="'.$row['id'].'" data-surtu="'.$row['kd_surtu'].'" ><div class="btn btn-danger btn-xs">delete</div></td>
			</tr>';
			$no++;
	}
	$html.='</tbody></table>';
	echo $html;

?>