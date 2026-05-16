<?php
    /*if (!isset($_SESSION['authenticated'])) {
        exit;
    }*/
//echo $_GET['jenis'];
//echo $_GET['nama_file'];
//exit(); 
//echo '<br>';
    //$file = '"../dokumen/'.$_GET['jenis'].'/'.$_GET['nama_file'].'"';
	//$file = "'../dokumen/".$_GET['jenis']."/".$_GET['nama_file']."'";
	$file = '../dokumen/'.$_GET['jenis'].'/'.$_GET['nama_file'];
	//$file = strval($file);
	//echo '<br>';
	//echo $file = '../dokumen/'.$_POST['jenis'].'/test_surat_tugas.docx';
	//echo '<br>';
	//$file = '../dokumen/surtu_draft/0812cfb9ff7a2c724766_ST SIMAK UI a.n. Jaya Miharja.docx';
	//echo basename($file);
	//exit(); 

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
	exit;

/*
	header('Content-Description: File Transfer');
	header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	header('Content-Disposition: inline; filename=' . basename($file));
	header('Content-Length: ' . filesize($file));
	header("Content-Transfer-Encoding: binary");
	header('Accept-Ranges: bytes');
	ob_clean();
    flush();
	readfile($file);
    exit;
*/
?>