
<?php
if(!session_id()) session_start();
date_default_timezone_set('Asia/Jakarta');

include "pdo.class.php";
$pdo = new Database();

/*
	pada saat menekan tombol simpan pada fitur tambah data penugasan terdapat tiga tabel yang terlibat yaitu tabel surtu_pejabat, surtu_kegiatan dan surtu_penugasan
	untuk tabel surtu_pejabat berisi informasi pejabat berperasn sebagai pemohon dimana hanya disimpan satu kali saja
	bila data pejabat sudah ada maka tambahkan fitur edit untuk mengupdate informasi detail pejabat
	untuk tabel surtu_kegiatan prosesnya kurang lebih hampur sama dengan tabel surtu_pejabat
*/

$crud = $_POST['crud']; 
if ($crud==1) {
	#simpan data pejabat kalo ada perubahan
	$nip_pejabat = htmlspecialchars($_POST['nip_pejabat']);

	//$var = '';
	foreach($_POST as $k => $v){
		if($k!='crud'){
			$var[] = $k ."='". htmlspecialchars($v)."'" ;
		}		
	}

	$values = implode(", ", $var) ;

	$sql = "UPDATE pejabat SET $values WHERE nip = '$nip_pejabat' ";
} else if($crud==2) {
	//print_r(json_encode(array('post'=>$_POST, JSON_PRETTY_PRINT))); exit();
	#simpan data kegiatan
	$nip = htmlspecialchars($_POST['nip_pejabat']);
	$nama_kegiatan = addslashes($_POST['nama_kegiatan']);
	$tgl_kegiatan = $_POST['tgl_kegiatan'];
	$start_date = tanggal($_POST['tgl1']);
	$end_date = tanggal($_POST['tgl2']);
	$sumber_dana = htmlspecialchars($_POST['sumber_dana']);
	$KodeBidang = htmlspecialchars($_POST['KodeBidang']);
	$username = $_SESSION['username'];
	
	$tgl_sistem = date("Y-m-d H:i:s");

	$skala = addslashes($_POST['skala']);
	$tempat = addslashes($_POST['tempat']);
	$penyelenggara = addslashes($_POST['penyelenggara']);
	
	#cek data: jika tidak ada datanya maka insert, selainnya maka update
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$sql = "SELECT * FROM surtu_kegiatan WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$result = $pdo->resultset();
	$rowcount = count($result);
	
	if($rowcount == 0){ //insert data
		
        #set data
        $kd_surtu = substr(md5(uniqid(mt_rand(), true)) , 0, 20);
        //print_r(json_encode(array('kd_surtu'=>$_POST['kd_surtu'], JSON_PRETTY_PRINT))); exit();
        //print_r(json_encode(array('kd_surtu'=>$kd_surtu, 'sql'=>$sql))); exit();
        $data = array(
        	'kd_surtu' => $kd_surtu,
        	'nip' => $nip,
        	'nama_kegiatan' => $nama_kegiatan,
			'tgl_kegiatan' => $tgl_kegiatan,
        	'sumber_dana' => $sumber_dana,
        	//'start_date' => $start_date,
        	//'end_date' => $end_date,
        	'tgl_sistem' => $tgl_sistem,
        	'tgl_permohonan' => $tgl_sistem,
        	'KodeBidang' => $KodeBidang,
        	'skala' => $skala,
        	'tempat' => $tempat,
        	'penyelenggara' => $penyelenggara,
        	'user_pemohon' => $username
        );
        
        #set nama field
        foreach($data as $k => $v){
			$field[] = $k;
		}
		
		#set nilai
		foreach($data as $k => $v){
			$value[] = $v;
		}
		
		#rekatkan nama field dan nilai
		$fields = implode(", ",$field);
		$values = "'".implode("', '",$value)."'";
		
		$sql = " INSERT INTO surtu_kegiatan ($fields) VALUES ($values) ";
		//print_r(json_encode(array('kd_surtu'=>$sql, JSON_PRETTY_PRINT))); exit();

	} else if($rowcount > 0){  //update data
		#set data
		$kd_surtu = $_POST['kd_surtu'];
		$data = array(
        	'nama_kegiatan' => $nama_kegiatan,
			'tgl_kegiatan' => $tgl_kegiatan,
        	'sumber_dana' => $sumber_dana,
        	//'start_date' => $start_date,
        	//'end_date' => $end_date,
        	'skala' => $skala,
        	'tempat' => $tempat,
        	'penyelenggara' => $penyelenggara,
        	'tgl_sistem' => $tgl_sistem
        );
        
        foreach($data as $k => $v){
        	$value[] = $k ."='". $v."'" ;
        }
        
        $values = implode(", ", $value) ;

		$sql = "UPDATE surtu_kegiatan SET $values WHERE kd_surtu = '$kd_surtu' ";
	}
	
	$pdo->query($sql);
	$pdo->execute();
	
		$result = array('sql'=>$sql, 'kd_surtu'=>$kd_surtu);
		print_r(json_encode($result));
	
}

#simpan data penugasan
if($crud == 3){
	#set data
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$data = array(
		'tgl_sistem' => date("Y-m-d H:i:s"),
		'nama' => addslashes($_POST['nama']),
		'nip' => htmlspecialchars($_POST['nip']),
		'sebagai' => addslashes($_POST['sebagai']),
		'bantuan' => addslashes($_POST['bantuan']),
		'kd_surtu' => $kd_surtu
	);
	
	#set nama field
	foreach($data as $k => $v){
		$field[] = $k;
	}

	#set nilai
	foreach($data as $k => $v){
		$value[] = $v;
	}

	#rekatkan nama field dan nilai
	$fields = implode(", ",$field);
	$values = "'".implode("', '",$value)."'";
	$sql = " INSERT INTO surtu_penugasan ($fields) VALUES ($values) ";
	$pdo->query($sql);
	$pdo->execute();
	
	#refresh data
	$sql = " SELECT * FROM surtu_penugasan WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$result = $pdo->resultset();
	//print_r($result);
	//echo "data sudah disimpan";
}

#delete data surat tugas -> Menghapus data dari tabel kegiatan dan penugasan
if($crud == 4){
	#set data
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);

	#delete tabel surtu kegiatan
	echo $sql = "DELETE FROM surtu_kegiatan WHERE kd_surtu = '$kd_surtu'";
	$pdo->query($sql);
	$pdo->execute();

	#delete tabel surtu penugasan
	echo $sql = "DELETE FROM surtu_penugasan WHERE kd_surtu = '$kd_surtu'";
	$pdo->query($sql);
	$pdo->execute();
}

#Pengajuan data surat tugas dari user
if($crud == 5){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$temp = htmlspecialchars($_POST['nip_pejabat']);
	$nip_pejabat = str_replace(': ', '', $temp);
	$tgl_sistem = date("Y-m-d H:i:s");
	$sql = "UPDATE surtu_kegiatan SET status = 1, nip_approval_unit = '$nip_pejabat', tgl_approval_unit = '$tgl_sistem' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

#edit data penugasan
if($crud == 6){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$id = htmlspecialchars($_POST['edit_id']);
	$tgl_sistem = date("Y-m-d H:i:s");
	$nama = addslashes($_POST['edit_nama']);
	$nip = htmlspecialchars($_POST['edit_nip']);
	$sebagai = htmlspecialchars($_POST['edit_sebagai']);
	$bantuan = htmlspecialchars($_POST['edit_bantuan']);

	$sql = "UPDATE surtu_penugasan SET nip = '$nip', nama = '$nama', sebagai = '$sebagai', bantuan = '$bantuan', tgl_sistem = '$tgl_sistem' WHERE id = '$id' ";
	$pdo->query($sql);
	$pdo->execute();
}

#delete data penugasan
if($crud == 13){
	$id = htmlspecialchars($_POST['id']);

	$sql = "DELETE FROM surtu_penugasan WHERE id = '$id' ";
	$pdo->query($sql);
	$pdo->execute();
}

#delete data penunjang
if($crud == 14){
	$id = htmlspecialchars($_POST['id']);

	$sql = "DELETE FROM surtu_penunjang WHERE id = '$id' ";
	$pdo->query($sql);
	$pdo->execute();
}

#approval Manajer SDM
if($crud == 7){
	#set no surat
	$sql = "SELECT max(no_surat)+1 as no_surat FROM `surtu_kegiatan` WHERE 1";
	$pdo->query($sql);
	$result = $pdo->single();
	foreach ( $result as $row) {
		$no_surat = $row['no_surat'];
	}

	$tgl_sistem = date("Y-m-d H:i:s");
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$nip_approval_sdm = $_SESSION['user_nip'];
	$sql = "UPDATE surtu_kegiatan SET status = 3, no_surat = '$no_surat', tgl_approval_sdm = '$tgl_sistem', nip_approval_sdm = '$nip_approval_sdm'  WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

#penolakan Manajer SDM
if($crud == 8){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$catatan_tolak_sdm = htmlspecialchars($_POST['catatan_tolak_sdm']);
	$sql = "UPDATE surtu_kegiatan SET status = 6, catatan_tolak_sdm = '$catatan_tolak_sdm' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

#perlu perbaikan Manajer SDM
if($crud == 9){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$catatan_perbaikan_sdm = htmlspecialchars($_POST['catatan_perbaikan_sdm']);
	$sql = "UPDATE surtu_kegiatan SET status = 5, catatan_perbaikan_sdm = '$catatan_perbaikan_sdm' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

#approval Wadek
if($crud == 10){
	$tgl_sistem = date("Y-m-d H:i:s");
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$nip_approval_wadek = $_SESSION['user_nip'];
	//$no_surat = 0;
	//$sql = "UPDATE surtu_kegiatan SET status = 4, no_surat = '$no_surat', tgl_approval_wadek2 = '$tgl_sistem', nip_approval_wadek = '$nip_approval_wadek'  WHERE kd_surtu = '$kd_surtu' "
	echo $sql ="UPDATE surtu_kegiatan SET status=4, tgl_approval_wadek2='$tgl_sistem', nip_approval_wadek='$nip_approval_wadek' WHERE kd_surtu='$kd_surtu'";

	$pdo->query($sql);
	$pdo->execute();
}

#penolakan Wadek
if($crud == 11){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$catatan_tolak_wadek = htmlspecialchars($_POST['catatan_tolak_wadek']);
	$sql = "UPDATE surtu_kegiatan SET status = 8, catatan_tolak_wadek2 = '$catatan_tolak_wadek' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

#perlu perbaikan Wadek
if($crud == 12){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$catatan_perbaikan_wadek = htmlspecialchars($_POST['catatan_perbaikan_wadek']);
	$sql = "UPDATE surtu_kegiatan SET status = 7, catatan_perbaikan_wadek2 = '$catatan_perbaikan_wadek' WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
}

/*test sql
$sql = "SELECT a.nip as nip_pejabat, a.nama as nama_pejabat, TopJabatan as jabatan, NamaBidang as unit_kerja, telp, c.email as email
FROM pejabat a
LEFT JOIN TblBidangDetail b ON a.KodeBidang = b.KodeBidang
LEFT OUTER JOIN snapshoot c ON a.nip = REPLACE(c.nip, '\'', '')
WHERE a.nip = '$nip_pejabat'";
$pdo->query($sql);
$pdo->resultset();
$rowcount = $pdo->rowCount();
print_r($rowcount);
*/

if($crud == 20){
	#set variabel data
	$nama_pejabat = $_POST['nama_pejabat'];
	$unit_kerja = $_POST['unit_kerja'];
	$nip_pejabat = $_POST['nip_pejabat'];
	$telp = $_POST['telp'];
	$jabatan = $_POST['jabatan'];
	$email = $_POST['email'];
	$nama_kegiatan = $_POST['nama_kegiatan'];
	$nama = $_POST['nama'];
	$nip = $_POST['nip'];
	$sebagai = $_POST['sebagai'];
	$bantuan = $_POST['bantuan'];
	

	$kd_surtu = substr(md5(uniqid(mt_rand(), true)) , 0, 20);
	$tgl_sistem = date("Y-m-d H:i:s");

	#cek apakah data pejabat sudah ada bila tidak ada insert data
	$sql = "SELECT * FROM surtu_pejabat WHERE nip = '$nip_pejabat'";
	$pdo->query($sql);
	$pdo->resultset();
	$rowcount = $pdo->rowCount();

	#jika tidak ada data maka insert
	if ($rowcount==0) {
		#prepare data
		$data = array(
			'',
			$kd_surtu,
			$nip_pejabat,
			$jabatan,
			$unit_kerja,
			$telp,
			$email,
			$tgl_sistem
		);
		$value = "'".implode("', '",$data)."'";

		#eksekusi query
		$sql = "INSERT INTO surtu_pejabat VALUES ($value)";
	} else {
		echo 'ada data';
	}
	
} else {
	//echo 0;
}

#update field pejabat
if($crud == 21){
	$key = htmlspecialchars($_POST['key']);
	$field = htmlspecialchars($_POST['field']);
	$value = htmlspecialchars($_POST['value']);
	$sql = "UPDATE pejabat SET $field = '$value' WHERE id = $key";
	$pdo->query($sql);
	$pdo->execute();
	
}

#ambil data telepon dan email
if($crud == 22){
	$key = htmlspecialchars($_POST['key']);
	$sql = "SELECT * FROM pejabat WHERE id = $key";
	$pdo->query($sql);
	$result = $pdo->resultset();
	#echo json_encode($result);
	#echo $result;
	foreach($result as $row){
		$telp = $row['telp'];
		$email = $row['email'];
	}
	$array = array('telp' => $telp, 'email' => $email);
	echo json_encode($array);
	
}

#ambil data nomor surat
if($crud == 23){
	$id = htmlspecialchars($_POST['id']);
	$sql = "SELECT * FROM surtu_kegiatan WHERE id = $id";
	$pdo->query($sql);
	$result = $pdo->resultset();
	#echo json_encode($result);
	#echo $result;
	foreach($result as $row){
		$no_surat = $row['no_surat2'];
	}
	$array = array('no_surat' => $no_surat);
	echo json_encode($array);
	
}

#simpan nomor surat
if($crud == 24){
	$id = htmlspecialchars($_POST['id']);
	$no_surat = htmlspecialchars($_POST['no_surat']);
	$sql = "UPDATE surtu_kegiatan SET no_surat2 = '$no_surat' WHERE id = $id";
	$pdo->query($sql);
	$pdo->execute();	
}


# simpan data pemohon
if($crud == 25){
	# algoritma :
	# cek dulu dalam database, datanya ada atau tidak
	# jika datanya tidak ada maka jalankan fungsi insert
	# jika ada maka jalankan fungsi update
	
	# ambil data post sambil menambahkan username
	unset($_POST['crud']);
	$username = $_SESSION['username'];
	$_POST['username'] = $username;
	
	# cek ada data atau tidak dalam database
	echo $sql = "SELECT id FROM surtu_user WHERE username = '$username'";
	$pdo->query($sql);
	$result = $pdo->resultset();
	print_r(count($result));
	
	# jika data di dalam hasil array
	if(count($result)==0){
		# jika datanya tidak ada jalankan fungsi insert
	        
        # set nama field
        foreach($_POST as $k => $v){
        	# sesuaikan nama field nip dan nama
        	if($k=='nip_pemohon'){
        		$field[] = 'nip';
        	} else if($k=='nama_pemohon'){
        		$field[] = 'nama';
	        } else {
				$field[] = $k;
			}
		}
		
		# set nilai
		foreach($_POST as $k => $v){
			$value[] = $v;
		}
		
		# rekatkan nama field dan nilai
		$fields = implode(", ",$field);
		$values = "'".implode("', '",$value)."'";
		
		# jalankan query
		$sql = " INSERT INTO surtu_user ($fields) VALUES ($values) ";
		$pdo->query($sql);
		$pdo->execute();	
	} else {
		# jika datanya ada jalankan fungsi update
		foreach($_POST as $k => $v){
			/*if($k!='crud'){
				$var[] = $k ."='". htmlspecialchars($v)."'" ;
			}	*/
			if($k=='nip_pemohon'){
				$var[] = "nip='". htmlspecialchars($v)."'" ;
			} else  if($k=='nama_pemohon'){
				$var[] = "nama='". htmlspecialchars($v)."'" ;
			} else {
				$var[] = $k ."='". htmlspecialchars($v)."'" ;
			}
		}
		
		
		# set nilai
		$values = implode(", ", $var) ;
	
		# jalankan query
		$sql = "UPDATE surtu_user SET $values WHERE username = '$username'";
		$pdo->query($sql);
		$pdo->execute();
	}
}

# Menunggu Diajukan Kepala Unit
if($crud == 26){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$sql = "UPDATE surtu_kegiatan SET status = 9 WHERE kd_surtu = '$kd_surtu' ";
	$pdo->query($sql);
	$pdo->execute();
	
}

# update data pemohon
# script ini menggantikan crud nomor 25 krn update langsung dilakukan pada tabel master_employee
# dilakukan perubahan script krn dalam tabel master_employee sudah meliputi informasi kodebidang dan user
# sehingga user tidak perlu lagi merubah field unit kerja kecuali jika terjadi mutasi
# update field user
if($crud == 27){
	$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
	$key = htmlspecialchars($_POST['key']);
	$field = htmlspecialchars($_POST['field']);
	$value = htmlspecialchars($_POST['value']);

	# update master employee
	$sql = "UPDATE master_employee SET $field = '$value' WHERE id = $key";
	$pdo->query($sql);
	$pdo->execute();

	# update surtu kegiatan
	if(strlen($kd_surtu)>5){
		echo $sql = "UPDATE surtu_kegiatan SET KodeBidang = '$value' WHERE kd_surtu = '$kd_surtu'";
		$pdo->query($sql);
		$pdo->execute();
	}
}

#ambil data telepon dan email
if($crud == 28){
	$key = htmlspecialchars($_POST['key']);
	$sql = "SELECT * FROM master_employee WHERE id = $key";
	$pdo->query($sql);
	$result = $pdo->resultset();
	#echo json_encode($result);
	#echo $result;
	foreach($result as $row){
		$telp = $row['telp'];
		$email = $row['email'];
		$kodebidang = $row['kodebidang'];
	}
	$array = array('telp' => $telp, 'email' => $email, 'kodebidang' => $kodebidang);
	echo json_encode($array);
	
}

function tanggal($tanggal){
		$array_bulan = array(
			'Januari'=>'01','Februari'=>'02','Maret'=>'03','April'=>'04','Mei'=>'05', 'Juni'=>'06','Juli'=>'07','Agustus'=>'08','September'=>'09','Oktober'=>'10','November'=>'11','Desember'=>'12'
		);
		$array = explode(' ', $tanggal);
		$d = $array[0];
		$m = $array_bulan[$array[1]];
		$y = $array[2];
		$tgl = $y.'-'.$m.'-'.$d;
		return $tgl;
	}
?>