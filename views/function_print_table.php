<?
function print_table($data, $nama_kolom, $jumlah_kolom)
{
	//set nama kolom
    echo '<table>';
    	
    //Give each table column same name is db column name
	echo '<tr><th>no</th>';
	foreach ($data[0] as $k => $v) {
		echo '<th>'.$k.'</th>';
	}
	echo '</tr>';
	$no=1;
	foreach ($data as $row) {
		echo '<tr><td>'.$no.'</td>';
		foreach ($row as $k => $v) {
			echo '<td>'.$v.'</td>';
		}
		echo '</tr>';
		$no++;
	}

    echo ' </table>';

/*
	$nip = $row->nip;
	$nama = $row->nama;
	$jabatan = $row->jabatan;
	$golongan = $row->golongan;
	$unit_kerja = $row->unit_kerja;
*/
}
?>
</pre>
<style type="text/css">
table {
	border-collapse: collapse;
}
table tr td, th {
	border: 1px solid gray;
}
</style>
?>