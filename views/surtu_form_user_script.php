<script type="text/javascript">
$(document).ready(function(){

	//nonaktifkan tombol simpan jika tidak ada nama kegiatannya
	$(document).on("keyup", "#nama_kegiatan", function(){
		
		if($("#nama_kegiatan").val()==""){
			$("#simpan-kegiatan").prop("disabled", true)
		} else {
			$("#simpan-kegiatan").prop("disabled", false)
		}
	})
	
	
	//set sumber dana dengan pemicu unit kerja
	$("#unit_kerja").on("change", function () {
		var kode_bidang = $("#unit_kerja").val()
		//tentukan checked sumber dana dari kode bidang
		const array_kode_fak = ["001", "002", "004", "006", "008", "009", "010", "011", "022"];
		const array_kode_dept = ["014", "015", "016","017", "018", "019", "020"];
		
		//cari kode bidang dalam array
		if(array_kode_fak.includes(kode_bidang)==true){
			$("#sd2").prop("checked", true)
		} else if(array_kode_dept.includes(kode_bidang)==true){
			$("#sd3").prop("checked", true)
		} else {
			alert("x")
		}
		
	})

	//menyimpan data pemohon
	$("#simpan-pemohon").on("click", function () {
		//set variabel
		var field_pemohon = $("#frm-pemohon input").serializeArray();
		var kode_bidang = $("#unit_kerja").val()
		field_pemohon.push({ name: "kodebidang", value: kode_bidang });
		field_pemohon.push({ name: "crud", value: 25 });

		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: field_pemohon,
			success: function(data)   // A function to be called if request succeeds
			{
				clock.start()
				$('#pesan-pemohon').text('data sudah disimpan');
				setTimeout(function() { $('#pesan-pemohon').text(''); }, 300);
				$("#results").html(data);
			}					
		});
	})

	$("#simpan-kegiatan").on("click", function () {
		//alert("u n d e r m a i n t e n a n c e")
		
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
				clock.start()
				$('#pesan-kegiatan').text('data sudah disimpan');
				setTimeout(function() { $('#pesan-kegiatan').text(''); }, 300);
				$("#results").html('<pre>'+JSON.stringify(data)+'</pre>');
				$("#kd_surtu").val(data.kd_surtu)
				kd_surtu = data.kd_surtu
				$("#tambah-data-penugasan").prop("disabled", false)
				$("#tambah-data-penunjang").prop("disabled", false)
				console.log(data)
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
	
	$(document).on("keyup", "#nama", function(){
		var kata = $("#nama").val()
		
		$.ajax({
			url: "views/surtu_cari_nama.php", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: {q:kata}, 	//  -> Data sent to server, a set of key/value pairs (i.e. form fields and values)
			success: function(data)   // A function to be called if request succeeds
			{
				clock.start()
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
				clock.start()
				$("#results").html('<pre>'+data+'</pre>');

				$.ajax({
					url: "views/surtu_penugasan_data.php",
					type: "POST",
					data: {kd_surtu:kd_surtu},
					success: function(data)   // A function to be called if request succeeds
					{
						clock.start()
						$("#data-penugasan").html(data)
					},
					complete: function(data) {
		                setTimeout(function() { $('#inputModal').modal('hide'); }, 300);
		            }           
				});				
			}					
		});
		

		
	})
	
	$(document).on("click", ".delete_penugasan", function(){
		
		var id = $(this).data("id")
		var kd_surtu = $(this).data("surtu")
		//alert( id+' '+kd_surtu )
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: {id:id, crud:13},
			success: function(data)   // A function to be called if request succeeds
			{
				//$("#results").html('<pre>'+data+'</pre>');
				console.log(data)
				//alert(data)
			}					
		});
		
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
	
	
	//turn off disabled inputan telepon
	$("#edit-telp").click(function(){
		clock.start()
		$("#telp").prop("disabled", false)
		$("#telp").focus()
		$(".btn-simpan-telp").show()
		$(".btn-edit-telp").hide()
	})

	//tombol batal untuk menyembunyikan view tombol simpan telepon
	$("#batal-simpan-telp").click(function(){
		clock.start()
		$("#telp").prop("disabled", true)
		$(".btn-simpan-telp").hide()
		$(".btn-edit-telp").show()
		
		//mengembalikan nilai no telp yg lama
		var id = $("#id").val()
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			dataType: "json",
			data: {key:id, crud:28},
			success: function(data)   // A function to be called if request succeeds
			{
				clock.start()
				$("#telp").val(data.telp) 
			}

		})
		
	})
	
	//menyimpan data telepon
	$("#simpan-telp").click(function(){
		clock.start()
		var id = $("#id").val()
		var telp = $("#telp").val()
		var pesan = confirm("nomor telepon akan disimpan?");
		if (pesan == true) {
			$.ajax({
				url: "views/surtu_crud.php",
				type: "POST",
				data: {key:id, field:"telp", value:telp, crud:27},
				success: function(data) {
					//sembunyikan tombol simpan dan batal
					$(".btn-simpan-telp").hide()
					
					//tampilkan pesan sesaat
					$('.pesan-telp').html('<b>data sudah disimpan</b>');
	                setTimeout(function() {
						$('.pesan-telp').html('');
						$(".btn-edit-telp").show()
						$("#telp").prop("disabled", true)
					}, 500);
	            }           
			});
		} 
	})

	//turn off disabled inputan email
	$("#edit-email").click(function(){
		$("#email").prop("disabled", false)
		$("#email").focus()
		$(".btn-simpan-email").show()
		$(".btn-edit-email").hide()
	})

	//tombol batal untuk menyembunyikan view tombol simpan email
	$("#batal-simpan-email").click(function(){
		$("#email").prop("disabled", true)
		$(".btn-simpan-email").hide()
		$(".btn-edit-email").show()

		//mengembalikan nilai email yg lama (diambil dari database)
		var id = $("#id").val()
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			dataType: "json",
			data: {key:id, crud:28},
			success: function(data)   // A function to be called if request succeeds
			{
				clock.start()
				$("#email").val(data.email) 
			}

		})
	})

	//menyimpan data email
	$("#simpan-email").click(function(){
		clock.start()
		var id = $("#id").val()
		var email = $("#email").val()

		if( !validateEmail(email)) { 
			alert("mohon email diisi dengan benar")
			$("#email").focus()
		} else {

			var pesan = confirm("alamat email akan disimpan?");
			if (pesan == true) {
				$.ajax({
					url: "views/surtu_crud.php",
					type: "POST",
					data: {key:id, field:"email", value:email, crud:27},
					success: function(data) {
						//sembunyikan tombol simpan dan batal
						$(".btn-simpan-email").hide()
						
						//tampilkan pesan sesaat
						$('.pesan-email').html('<b>data sudah disimpan</b>');
		                setTimeout(function() {
							$('.pesan-email').html('');
							$(".btn-edit-email").show()
							$("#email").prop("disabled", true)
						}, 500);
		            }           
				});
			} 
		}
	})

	//turn off disabled inputan unit kerja
	$("#edit-unit_kerja").click(function(){
		$("#unit_kerja").prop("disabled", false)
		$("#unit_kerja").focus()
		$(".btn-simpan-unit_kerja").show()
		$(".btn-edit-unit_kerja").hide()
	})

	//tombol batal untuk menyembunyikan view tombol simpan unit kerja
	$("#batal-simpan-unit_kerja").click(function(){
		$("#unit_kerja").prop("disabled", true)
		$(".btn-simpan-unit_kerja").hide()
		$(".btn-edit-unit_kerja").show()

		//mengembalikan nilai unit kerja yg lama (diambil dari database)
		var id = $("#id").val()
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			dataType: "json",
			data: {key:id, crud:28},
			success: function(data)   // A function to be called if request succeeds
			{
				clock.start()
				$("#unit_kerja").val(data.kodebidang) 
			}

		})
	})

	//menyimpan data unit kerja
	$("#simpan-unit_kerja").click(function(){
		clock.start()
		var id = $("#id").val()
		var kodebidang = $("#unit_kerja").val()

		var pesan = confirm("data unit kerja akan disimpan?");
		if (pesan == true) {
			$.ajax({
				url: "views/surtu_crud.php",
				type: "POST",
				data: {key:id, field:"kodebidang", value:kodebidang, crud:27},
				success: function(data) {
					//sembunyikan tombol simpan dan batal
					$(".btn-simpan-unit_kerja").hide()
					
					//tampilkan pesan sesaat
					$('.pesan-unit_kerja').html('<b>data sudah disimpan</b>');
	                setTimeout(function() {
						$('.pesan-unit_kerja').html('');
						$(".btn-edit-unit_kerja").show()
						$("#unit_kerja").prop("disabled", true)
					}, 500);
	            }           
			});
		} 
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
				clock.start()
				$('#data').html(data)
			}
		});	
	}
	
	/*munculkan tombol tambah ketika kd_surtunya sdh keluar
	$("#kd_surtu").change(function(){
		var kd_surtu = $("#kd_surtu").val()
		if(kd_surtu != '0'){
			alert(kd_surtu)
			$("#tambah-data-penugasan").prop("disabled", false)
		}
	})*/
	
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

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,6})?$/;
  return ($email.length > 0 && emailReg.test($email));
}
</script>