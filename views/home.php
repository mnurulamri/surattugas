<hr style="color:#fa0">
<h4 style="color:#516395; text-align:center">
Selamat Datang! <?=$_SESSION['nama_bergelar']?> anda login sebagai <?=$_SESSION['role']?>
</h4>
<hr style="color:#fa0">
<p>
Layanan Permohonan Penerbitan Surat Tugas berbasis online merupakan upaya untuk mengurangi penggunaan kertas dilingkungan FISIP UI.
</p>
<p>
Layanan ini bertujuan untuk memaksimalkan proses yang ada agar pekerjaan dapat dilakukan secara efektif dan efisien. Melalui layanan ini diharapkan para pengguna sistem dapat memantau aktifitas pergerakan dari proses pengajuan sampai dengan diterbitkannya surat tugas.
</p>
<p>
Untuk surat tugas yang berimplikasi terhadap penggunaan dana, sebelum mengajukan permohonan, pemohon diharapkan dapat berkoordinasi dengan unit terkait.
</p>
<p>
Informasi lebih lanjut mengenai substansi surat tugas dapat menghubungi Unit SDM, sedangkan yang berhubungan dengan teknis pengoperasian dapat menghubungi Unit PPF dengan Sdr M. Nuurul Amri (No. HP: 087775157762)
</p>
<!--
<p>
Berikut adalah workflow permohonan pembuatan surat tugas:
</p>
-->
<p>
<?php
$data = base64_encode(file_get_contents("./dokumen/alur_surat_tugas.svg")) ;
//echo base64_decode($data);
?>
</p>