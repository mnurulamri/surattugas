<script>
$(document).ready(function(){
	
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
	
	$(document).on("click", ".edit", function(){
		$("#editModal").modal("show")
		var kd_surtu = $(this).parent().attr("id")
		$("#kd_surtu").val(kd_surtu)

		//fetch data kegiatan
		var nama_kegiatan = $(this).parent().find("td").eq(1).text()
		//var tgl_kegiatan=  $(this).parent().find("td").eq(2).data("tgl_kegiatan")
		var tgl_kegiatan=  $(this).parent().find("td").eq(6).text()
		//var tgl1 =  $(this).parent().find("td").eq(3).data("tgl1")
		//var tgl2 =  $(this).parent().find("td").eq(4).data("tgl2")
		//$("#tgl1").val(tgl1)
		//$("#tgl2").val(tgl2)

		var skala = $(this).parent().find("td").eq(3).text()
		var tempat = $(this).parent().find("td").eq(4).text()
		var penyelenggara = $(this).parent().find("td").eq(5).text()

		$("#nama_kegiatan").val(nama_kegiatan)
		$("#tgl_kegiatan").val(tgl_kegiatan)
		$("#skala").val(skala)
		$("#tempat").val(tempat)
		$("#penyelenggara").val(penyelenggara)

		// set checked skala
		var sk = $(this).parent().find("td").eq(3).text()
		if(sk == 'Lokal'){
			$("#frm-kegiatan input:radio[name='skala'][value='lokal']").prop( 'checked', true )
		} else if (sk == 'nasional'){
			$("#frm-kegiatan input:radio[name='skala'][value='nasional']").prop( 'checked', true )
		} else if (sk == 'internasional'){
			$("#frm-kegiatan input:radio[name='skala'][value='internasional']").prop( 'checked', true )
		}
		
		//set checked sumber dana
		var sd = $(this).parent().find("td").eq(7).text()
		if(sd == 'PAU'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='1']").prop( 'checked', true )
		} else if (sd == 'PAF'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='2']").prop( 'checked', true )
		} else if (sd == 'Departemen/Prodi'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='3']").prop( 'checked', true )
		} else if (sd == 'Lain-lain'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='4']").prop( 'checked', true )
		}
		
		//fetch data penunjang
		$.ajax({
			url: "views/surtu_penunjang_data.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penunjang").html(data)
			}         
		});

		//fetch data penugasan
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
	
	$(document).on("click", ".delete", function(){
		var kd_surtu = $(this).parent().attr("id")
		var nama_kegiatan = $(this).parent().find("td").eq(1).text()
		
		//surat tugas baru bisa dihapus jika status masih menunggu persetujuan belum diajukan
		var r = confirm("Anda yakin akan menghapus data surat tugas " + nama_kegiatan + "?");
		if (r == true) {
			$.ajax({
				url: "views/surtu_crud.php",
				type: "POST",
				data: {kd_surtu:kd_surtu, crud:4},
				success: function(res)  // A function to be called if request succeeds
				{
					//alert(res)
				},
				complete: function()  // A function to be called if request complete
				{
					//alert("data surat tugas " + nama_kegiatan + " sudah hapus!")
					$.post("views/surtu_list_user_ajax.php", function(data) {
						$("#data-kegiatan").html(data)
					});
				}
			   
			});
		}
	})
	
	//menampilkan view data pengajuan
	$(document).on("click", ".ajukan", function(){
		var kd_surtu = $(this).parent().attr("id")
		$("#ajukanModal").modal("show")
		
		//view data pengajuan
		$.ajax({
			url: "views/surtu_pengajuan_user_view.php",
			type: "POST",
			data: {kd_surtu:kd_surtu, flag:1},
			success: function(data)
			{
				$("#data-pengajuan").html(data)
			}
		})
	})
	
	//menampilkan view data pengajuan
	$(document).on("click", ".view", function(){
		var kd_surtu = $(this).parent().attr("id")
		$("#ajukanModal").modal("show")
		
		//view data pengajuan
		$.ajax({
			url: "views/surtu_pengajuan_user_view.php",
			type: "POST",
			data: {kd_surtu:kd_surtu, flag:0},
			success: function(data)
			{
				$("#data-pengajuan").html(data)
			}
		})
	})
	
})
</script>

<script type="text/javascript">
$(document).ready(function(){
	fetchList()
	fetchDataPenunjang()

	$("#data-penunjang").html('')
	var kd_surtu = '0';

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
		//alert("u n d e r c o n s t r u c t i o n")
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
				//$("#results").html('<pre>'+data.sql+'</pre>');
				$("#kd_surtu").val(data.kd_surtu)
				kd_surtu = data.kd_surtu;
			}			
		});
	})

	$("#editModal").on("shown.bs.modal", function () {
		
		$("#nip").text("")
		$("#nama").text("")
		$("#sebagai").text("")
		$("#bantuan").text("")
		$("#kotaksugest").text("")
		$("#nama").focus()
	})
	
	$("#editModal").on("hidden.bs.modal", function () {
		fetchListOnPage();
		console.log("modal edit ditutup")
	})
	
	$("#ajukanModal").on("hidden.bs.modal", function () {
		fetchListOnPage()
	})
	
	$(document).on("keyup", "#nama", function(){
		var kata = $("#nama").val()
		
		$.ajax({
			url: "views/surtu_cari_nama.php", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: {q:kata}, 	//  -> Data sent to server, a set of key/value pairs (i.e. form fields and values)
			success: function(data)   // A function to be called if request succeeds
			{
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


	 //Data Penunjang
	 $(document).on("click", ".delete_file", function(){
		var id = $(this).data("id")
		var kd_surtu = $(this).data("surtu")
		//alert(id)
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: {id:id, crud:14},
			success: function(data)   // A function to be called if request succeeds
			{
				//$("#results").html('<pre>'+data+'</pre>');
				console.log(data)
				//alert(data)
			}					
		});
		
		//fetch data penunjang
		$.ajax({
			url: "views/surtu_penunjang_data.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penunjang").html(data)
			}         
		});
	 })

	//Data Penugasan
	$("#simpan-penugasan").click(function(){	
		var fields = $("#frm-penugasan input").serializeArray();
		var kd_surtu = $("#kd_surtu").val()
		fields.push({ name: "crud", value: 3 });
		fields.push({ name: "kd_surtu", value: kd_surtu });
		
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: fields,
			success: function(data)   // A function to be called if request succeeds
			{
				//$("#results").html('<pre>'+data+'</pre>');
			}					
		});
		
		$.ajax({
			url: "views/surtu_penugasan_ajax.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penugasan").html(data)
			},
			complete: function(data) {
                setTimeout(function() { $('#inputModal').modal('hide'); }, 2300);
            }           
		});
		
	})
	
	$(".close-modal-penugasan").click(function(){
		$("#inputModal").modal("hide")
	})
	
	$(document).on("click", ".delete_penugasan", function(){
	//$(".delete_penugasan").click(function(){
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

	/*function fetchList(){
		$.post("views/surtu_list_user_ajax.php", function(data) {
			$("#data-kegiatan").html(data)
		});
	}*/

	function fetchList(){
        page_num = 0;
    	var nama_kegiatan = "";
    	var tgl_permohonan = "";
		var status = $('#status').val();
    	$.ajax({
        	type: 'POST',
        	url: 'views/surtu_list_user_pagination_ajax.php',
        	data:'page='+page_num+'&nama_kegiatan='+nama_kegiatan+'&tgl_permohonan='+tgl_permohonan+'&status='+status,
        	beforeSend: function () {
            	$('.loading-overlay').show();
        	},
        	success: function (html) {
            	$('#data-kegiatan').html(html);
            	$('.loading-overlay').fadeOut("slow");
        	}
    	});
	}
	//view file arsip
	$(document).on("click", ".view_file_arsip", function(){
		$("#viewDokumenModal").modal("show")
		$(".modal-body #dokumen-view").html('')
		var id = $(this).data("id")

		$.ajax({
			url: "views/surtu_view_file.php",
			type: "POST",
			data: {id:id, ket:"file_arsip"},
			success: function(data)   // A function to be called if request succeeds
			{
				$(".modal-body #dokumen-view").html(data)
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
		var kd_surtu = $("#kd_surtu").val()

		var pesan = confirm("data unit kerja akan disimpan?");
		if (pesan == true) {
			$.ajax({
				url: "views/surtu_crud.php",
				type: "POST",
				data: {kd_surtu:kd_surtu, key:id, field:"kodebidang", value:kodebidang, crud:27},
				//data: {key:id, field:"kodebidang", value:kodebidang, crud:27},
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
	});

	$('#data-kegiatan').on('click', '.page', function(){
		var page_num = $(this).data('count');
		$("#page-num").val(page_num);
		//fetchListOnPage();
		//searchFilter(page_num);
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
				$('#data').html(data);
				clock.start();
			}
		});	
	}
});

function fetchListOnPage()
{
	var page_num = $("#page-num").val();
	var nama_kegiatan = $("#nama_kegiatan_filter").val();
	var tgl_permohonan = $("#tgl_permohonan").val();
	var status = $("#status").val();		
	console.log('page='+page_num+'&nama_kegiatan='+nama_kegiatan+'&tgl_permohonan='+tgl_permohonan+'&status='+status);
	$.ajax({
		type: 'POST',
		url: 'views/surtu_list_user_pagination_ajax.php',
		data:'page='+page_num+'&nama_kegiatan='+nama_kegiatan+'&tgl_permohonan='+tgl_permohonan+'&status='+status,
		beforeSend: function () {
			$('.loading-overlay').show();
		},
		success: function (html) {
			$('#data-kegiatan').html(html);
			$('.loading-overlay').fadeOut("slow");
		}
	});
}

$("#nama_kegiatan_filter").keyup(function(){
	fetchListOnPage();
});

$("#tgl_permohonan").keyup(function(){
	fetchListOnPage();
});

$("#status").change(function(){
	fetchListOnPage();
});

function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var nama_kegiatan = $('#nama_kegiatan_filter').val();    
    var tgl_permohonan = $('#tgl_permohonan').val();
  	var status = $('#status').val();
    $.ajax({
        type: 'POST',
        url: 'views/surtu_list_user_pagination_ajax.php',
        data:'page='+page_num+'&nama_kegiatan='+nama_kegiatan+'&tgl_permohonan='+tgl_permohonan+'&status='+status,
        beforeSend: function () {
            $('.loading-overlay').show();
        },
        success: function (html) {
            $('#data-kegiatan').html(html);
            $('.loading-overlay').fadeOut("slow");
        }
    });

}

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