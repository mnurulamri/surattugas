
<div id="data-kegiatan"></div>

<div>
	<br>
	<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
		<li>Lakukan pengisian nomor surat dengan menekan tombol <font class="label label-success">edit</font></li>
		<li>Data permohonan yang muncul adalah data yang sudah disetujui oleh Wakil Dekan Bidang SUMDAVUM</i>
		<li>Silahkan tekan tombol <font class="label label-warning">view</font> untuk melihat detail data permohonan</li>
		<li>Untuk melihat dan mengunggah surat tugas yang sudah ditandatangani Dekan, gunakan icon <font class="fa fa-file-text-o" style="color:#aa72b8; font-size:18px;"></font> dan <font class="fa fa-arrow-circle-o-up" style="color:#00a8a8; font-size:20px;"></font> pada kolom File Final</li>
		<li>Proses akhir dari pembuatan surat tugas dapat dilihat melalui file final yang sudah diunggah</li>
	</ul>
</div>

<!-- modal view -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="viewModalLabel">Pengajuan Surat Tugas</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="view-data"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" id="view" >tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal View Dokumen -->
<div class="modal fade" id="viewDokumenModal" tabindex="-1" role="dialog" aria-labelledby="viewDokumenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title"style="text-align:center">Dokumen</h4>
        </div>
	      <div class="modal-body">
	        <!--<img src="dokumen/surtu/clipart-6-11-8-29-28.png">-->
	
	        <div id="dokumen-view"></div>
	        <!-- 
	        <div class="embed-responsive embed-responsive-10by1">
	          <iframe src="https://docs.google.com/gview?url=https://remun.ppaa.fisip.ui.ac.id/ijk/dokumen/C-01.doc &embedded=true" frameborder="0"></iframe>
	        </div>
	        -->
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
	      </div>
    	</div>
    </div>
</div>

<!-- Modal Upload Arsip Surat Tugas-->
<div class="modal fade" id="uploadArsipModal" tabindex="-1" role="dialog" aria-labelledby="uploadArsipModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		  	<div class="modal-header" >
  				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  				<h4 class="modal-title" id="uploadArsipModalLabel" style="text-align:center">Upload File Arsip</h4>
		  	</div>
			<div class="modal-body" style="text-align:center">
				
        <form id="upload_form" enctype="multipart/form-data" method="post">
          <input type="hidden" name="action" id="action" value="test action">
          <input type="hidden" name="post_file_kode" id="post_file_kode" value="kode">
          <input type="file" name="file_upload" id="file_upload" onchange="uploadFileConfirm()" style="margin:auto"><br>
          <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
          <h3 id="status"></h3>
          <p id="loaded_n_total"></p>
          <p id="result"></p>
        </form>
          
          <script>
        function uploadFileConfirm(){
        	var r = confirm("Anda akan menambah data penunjang surat tugas?");
          if (r == true) {
            uploadFile()
          }
        }
        function _(el) {
          return document.getElementById(el);
        }

        function uploadFile() {
          var file = _("file_upload").files[0];
          var action = _("action").value;
          var post_file_kode = _("post_file_kode").value;
          alert(file.name+" | "+file.size+" | "+file.type);
          
          var formdata = new FormData();
          formdata.append("action", action);
          formdata.append("file_upload", file);
          formdata.append("post_file_kode", post_file_kode);
          var ajax = new XMLHttpRequest();
          ajax.upload.addEventListener("progress", progressHandler, false);
          ajax.addEventListener("load", completeHandler, false);
          ajax.addEventListener("error", errorHandler, false);
          ajax.addEventListener("abort", abortHandler, false);
          ajax.open("POST", "views/surtu_upload_arsip.php"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
          
          //use file_upload_parser.php from above url
          ajax.send(formdata);
          clock.start()
			_("file_draft_upload").value = "";
        }

        function progressHandler(event) {
          _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
          var percent = (event.loaded / event.total) * 100;
          _("progressBar").value = Math.round(percent);
          _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandler(event) {
          _("status").innerHTML = event.target.responseText;
          _("progressBar").value = 0; //wil clear progress bar after successful upload
          //_("test-data").innerHTML = event.target.responseText;
        }

        function errorHandler(event) {
          _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
          _("status").innerHTML = "Upload Aborted";
        }

        </script>

			</div>
			<div class="modal-footer">
				<button type="button" id="close" class="btn btn-default" data-dismiss="modal">Close</button>
				<!--<button type="button" class="btn btn-primary">Save changes</button>-->
			</div>
		</div>
  	</div>
</div>

<script>
$(document).ready(function(){
	
	//panggil data
	fetchList()
	
	//set data
	function fetchList(){
		$.post("views/surtu_list_sekpim_ajax.php", function(data) {
			$("#data-kegiatan").html(data)
		});
	}
	
	//menampilkan view data pengajuan yang sudah disetujui wadek
	$(document).on("click", ".approval", function(){
		var kd_surtu = $(this).parent().parent().attr("id")
		var nip = $(this).data("nip")
		$("#approvalModal").modal("show")
		
		//view data pengajuan
		$.ajax({
			url: "views/surtu_approval_view.php",
			type: "POST",
			data: {kd_surtu:kd_surtu, nip:nip},
			success: function(data)
			{
				$("#data-approval").html(data)
			}
		})
	})
	
	//menampilkan view data pengajuan yang sudah di approval
	$(document).on("click", ".view", function(){
		var kd_surtu = $(this).parent().parent().attr("id")
		var nip = $(this).data("nip")
		
		$("#viewModal").modal("show")
		
		//view data pengajuan
		$.ajax({
			url: "views/surtu_approval_view.php",
			type: "POST",
			data: {kd_surtu:kd_surtu, nip:nip},
			success: function(data)
			{
				$("#view-data").html(data)
			}
		})
	})
	
	//tutup view surat tugas
	$(document).on("click", "#view", function(){
		$("#viewModal").modal("hide")
	})

	//menampilkan data penunjang
	$(document).on("click", ".view_dok", function(){
		$("#viewDokumenModal").modal("show")
		$(".modal-body #dokumen-view").html('<ul class="fa-ul"><li><i class="fa-li fa fa-spinner fa-spin"></li></ul>')
		var id = $(this).data("id")
		$.ajax({
			url: "views/surtu_view_file.php",
			type: "POST",
			data: {id:id, ket:"from_approval"},
			success: function(data)   // A function to be called if request succeeds
			{
				$(".modal-body #dokumen-view").html(data)
				//$(".modal-body").html(data)
			}         
		});
	})	

	//edit nomor surat
	$(document).on("click", ".edit", function(){
		clock.start()

		//set id
		var id = $(this).parent().parent().parent().attr("id")
		//manipulasi button
		$("#no_surat-"+id).focus()
		$(".btn-simpan-no_surat-"+id).show()
		$(".btn-edit-no_surat-"+id).hide()
		
	})	

	//tombol batal untuk menyembunyikan view tombol simpan nomor surat tugas
	$(document).on("click", ".batal", function(){
		clock.start()
		var id = $(this).parent().parent().parent().attr("id")
		
		$(".btn-simpan-no_surat-"+id).hide()
		$(".btn-edit-no_surat-"+id).show()
		
		//mengembalikan nilai nomor surat yg lama
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			dataType: "json",
			data: {id:id, crud:23},
			success: function(data)   // A function to be called if request succeeds
			{
				clock.start()
				$("#no_surat-"+id).val(data.no_surat) 
			}

		})
		
	})

	//menyimpan data telepon
	$(document).on("click", ".simpan", function(){
		clock.start()
		var id = $(this).parent().parent().parent().attr("id")
		var no_surat = $("#no_surat-"+id).val()
		
		var pesan = confirm("nomor surat akan disimpan?");
		if (pesan == true) {
			$.ajax({
				url: "views/surtu_crud.php",
				type: "POST",
				data: {id:id, no_surat:no_surat, crud:24},
				success: function(data) {
					//sembunyikan tombol simpan dan batal
					$(".btn-simpan-no_surat-"+id).hide()
					$(".btn-edit-no_surat-"+id).show()
	            }           
			});
		} 
	})

	//upload arsip surat tugas yang sudah final
	$(document).on("click", ".upload-arsip", function(){
		$("#uploadArsipModal").modal("show")
		var post_file_kode = $(this).data("surtu")
		$("#post_file_kode").val(post_file_kode)
	})
	
	$('#uploadArsipModal').on('hidden.bs.modal', function() {
		//alert("test")
	    //fetchList()
	 $.post("views/surtu_list_sekpim_ajax.php", function(data) {
			$("#data-kegiatan").html(data)
		});
	})

	//view file arsip
	$(document).on("click", ".view_file_arsip", function(){
		$("#viewDokumenModal").modal("show")
		$(".modal-body #dokumen-view").html('<ul class="fa-ul"><li><i class="fa-li fa fa-spinner fa-spin"></i></li></ul>')
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
})
</script>

<style>
table thead {
	color: #fff;
  background-image: linear-gradient(to right, #614385 , #516395);
}
</style>