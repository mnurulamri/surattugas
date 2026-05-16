<script>
$(document).ready(function(){
	/*
	$(document).on("click", ".edit", function(){
		$("#editModal").modal("show")
		var kd_surtu = $(this).parent().attr("id")
		$("#kd_surtu").val(kd_surtu)

		//fetch data kegiatan
		var nama_kegiatan = $(this).parent().find("td").eq(1).text()
		var tgl1 =  $(this).parent().find("td").eq(2).data("tgl1")
		var tgl2 =  $(this).parent().find("td").eq(2).data("tgl2")
		$("#nama_kegiatan").val(nama_kegiatan)
		$("#tgl1").val(tgl1)
		$("#tgl2").val(tgl2)
		
		//set checked sumber dana
		var sd = $(this).parent().find("td").eq(3).text()
		if(sd == 'PAU'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='1']").prop( 'checked', true )
		} else if (sd == 'PAF'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='2']").prop( 'checked', true )
		} else if (sd == 'Departemen/Prodi'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='3']").prop( 'checked', true )
		} else if (sd == 'Lain-lain'){
			$("#frm-kegiatan input:radio[name='sumber_dana'][value='4']").prop( 'checked', true )
		}

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
					alert(res)
				},
				complete: function()  // A function to be called if request complete
				{
					//alert("data surat tugas " + nama_kegiatan + " sudah hapus!")
					$.post("views/surtu_list_ajax.php", function(data) {
						$("#data-kegiatan").html(data)
					});
				}
			   
			});
		}
	})
	*/
	//menampilkan view data pengajuan
	$(document).on("click", ".ajukan", function(){
		var kd_surtu = $(this).parent().attr("id")
		console.log(kd_surtu)
		$("#ajukanModal").modal("show")
		
		//view data pengajuan
		$.ajax({
			url: "views/surtu_pengajuan_view.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
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
	
	var kd_surtu = '0';
	/*
	$("#simpan-pejabat").on("click", function () {
		var field_pejabat = $("#frm-pejabat input").serializeArray();
		field_pejabat.push({ name: "crud", value: 1 });

		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: field_pejabat,
			success: function(data)   // A function to be called if request succeeds
			{
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
				$("#results").html('<pre>'+data.sql+'</pre>');
				$("#kd_surtu").val(data.kd_surtu)
				kd_surtu = data.kd_surtu
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
		fetchList()
	})
	*/
	$("#ajukanModal").on("hidden.bs.modal", function () {
		fetchList()
	})
	/*
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
			url: "views/surtu_penugasan_data.php",
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
	*/
	function fetchList(){
		$.post("views/surtu_list_sdm_ajax.php", function(data) {
			$("#data-kegiatan").html(data)
		});
	}
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
</script>