
<div id="data-kegiatan"></div>

<div>
	<br>
	<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
		<li>Silahkan tekan tombol <font class="label label-primary">approval</font> untuk menyetujui permohonan surat tugas yang sudah diajukan</li>
		<li>Permohonan yang sudah disetujui oleh Manajer SDM akan merubah status menjadi "Menunggu Persetujuan Wakil Dekan Bidang SUMDAVUM"</i>
		<li>Silahkan tekan tombol <font class="label label-warning">view</font> untuk melihat detail data permohonan</li>
		<li>Manajer SDM dapat memantau aktifitas pergerakan penerbitan surat tugas melalui status persetujuan yang meliputi:
			<ul>
				<li>Menunggu persetujuan Manajer SDM</li>
				<li>Menunggu persetujuan Wakil Dekan Bidang Sumber Daya, Ventura dan Umum</li>
				<li>Disetujui</li>
				<li>Perlu Perbaikan</li>
				<li>Ditolak</li>
			</ul>
		</li>
		<li>Untuk melihat, mengunggah dan mengunduh draft surat tugas gunakan icon <font class="fa fa-file-word-o" style="color:blue; font-size:18px;"></font>, <font class="fa fa-arrow-circle-o-up" style="color:#00a8a8; font-size:20px;"></font> dan icon <font class="fa fa-arrow-circle-o-down" style="color:#5dade2; font-size:20px;"></font> pada kolom File Draft</li>
		<li>Untuk melihat dan mengunggah surat tugas yang sudah ditandatangani Dekan, gunakan icon <font class="fa fa-file-text-o" style="color:#aa72b8; font-size:18px;"></font> dan <font class="fa fa-arrow-circle-o-up" style="color:#00a8a8; font-size:20px;"></font> pada kolom File Final</li>
		<!--<li>Proses penerbitan surat tugas dinyatakan selesai apabila file surat tugas sudah terupload </li>-->
		<li>Proses akhir dari pembuatan surat tugas dapat dilihat melalui file final yang sudah diunggah</li>
	</ul>
</div>

<!-- modal approval -->
<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="approvalModalLabel">Pengajuan Surat Tugas</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="data-approval"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="setujui" >setujui</button>
				<button type="button" class="btn btn-success" id="perbaikan" >perlu perbaikan</button>
				<button type="button" class="btn btn-danger" id="tolak" >tolak</button>
				<button type="button" class="btn btn-warning" data-dismiss="modal">tutup</button>
			</div>
		</div>
	</div>
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

<!-- modal perbaikan -->
<div class="modal fade" id="perbaikanModal" tabindex="-1" role="dialog" aria-labelledby="perbaikanModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="perbaikanModalLabel">Pengajuan Surat Tugas</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="view-data-perbaikan">
					<textarea id="catatan_perbaikan_sdm" name="catatan_perbaikan_sdm" rows="5" cols="80"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="simpan-perbaikan" >simpan</button>
				<button type="button" class="btn btn-warning" id="close-perbaikan" >tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- modal tolak -->
<div class="modal fade" id="tolakModal" tabindex="-1" role="dialog" aria-labelledby="tolakModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="tolakModalLabel">Pengajuan Surat Tugas</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="view-data-perbaikan">
					<textarea id="catatan_tolak_sdm" name="catatan_tolak_sdm" rows="5" cols="80"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="simpan-tolak" >simpan</button>
				<button type="button" class="btn btn-warning" id="close-tolak" >tutup</button>
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

<!-- Modal Upload Draft Surat Tugas-->
<div class="modal fade" id="uploadDraftModal" tabindex="-1" role="dialog" aria-labelledby="uploadDraftModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="uploadDraftModalLabel" style="text-align:center">Upload Draft Surat Tugas</h4>
			</div>
			<div class="modal-body" style="text-align:center">
				<form id="upload_draft" enctype="multipart/form-data" method="post">
					<input type="hidden" name="action" id="action" value="test action">
					<input type="hidden" name="post_kd_surtu" id="post_kd_surtu" value="kode surtu">
					<input type="file" name="file_draft_upload" id="file_draft_upload" onchange="uploadFileDraftConfirm()" style="margin:auto"><br>
					<progress id="progressBarDraft" value="0" max="100" style="width:300px;"></progress>
					<h3 id="statusDraft"></h3>
					<p id="loaded_n_totalDraft"></p>
					<p id="resultDraft"></p>
				</form>

				<!-- script upload -->
				<script>
		        function uploadFileDraftConfirm(){
					var r = confirm("Anda akan mengunggah draft surat tugas?");
					if (r == true) {
						uploadFileDraft()
					}
		        }

				function _(el) {
					return document.getElementById(el);
				}

	        	function uploadFileDraft() {
					var file = _("file_draft_upload").files[0];
					var action = _("action").value;
					var post_kd_surtu = _("post_kd_surtu").value;
					alert(file.name+" | "+file.size+" | "+file.type);
	          
					var formdata = new FormData();
					formdata.append("action", action);
					formdata.append("file_draft_upload", file);
					formdata.append("post_kd_surtu", post_kd_surtu);
					var ajax = new XMLHttpRequest();
					ajax.upload.addEventListener("progress", progressHandlerDraft, false);
					ajax.addEventListener("load", completeHandlerDraft, false);
					ajax.addEventListener("error", errorHandlerDraft, false);
					ajax.addEventListener("abort", abortHandlerDraft, false);
					ajax.open("POST", "views/surtu_upload_draft.php");

					//use file_upload_parser.php from above url
					ajax.send(formdata);
					clock.start()
					_("file_draft_upload").value = "";
	        	}

		        function progressHandlerDraft(event) {
					_("loaded_n_totalDraft").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
					var percent = (event.loaded / event.total) * 100;
					_("progressBarDraft").value = Math.round(percent);
					_("statusDraft").innerHTML = Math.round(percent) + "% uploaded... please wait";
		        }

		        function completeHandlerDraft(event) {
					_("statusDraft").innerHTML = event.target.responseText;
					_("progressBarDraft").value = 0; //wil clear progress bar after successful upload
					//_("test-data").innerHTML = event.target.responseText;
		        }

		        function errorHandlerDraft(event) {
					_("statusDraft").innerHTML = "Upload Failed";
		        }

				function abortHandlerDraft(event) {
					_("statusDraft").innerHTML = "Upload Aborted";
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

<?php //include "surtu_list_sdm_script.php"; ?>
<script src="../ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function(){
	CKEDITOR.replace('catatan_perbaikan_sdm')
	CKEDITOR.replace('catatan_tolak_sdm')
	
	fetchList()
	
	function fetchList(){
		$.post("views/surtu_list_operator_ajax.php", function(data) {
			$("#data-kegiatan").html(data)
		});
	}
	
	//menampilkan view data pengajuan yang akan di approval
	$(document).on("click", ".approval, .review", function(){
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
	
	//memberikan persetujuan 
	$(document).on("click", "#setujui", function(){
		var kd_surtu = $("#kode-surtu").val()
		
		//set approval
		var r = confirm("Anda akan memberikan persetujuan?");
		if (r == true) {
			$.ajax({
				url: "views/surtu_crud.php",
				type: "POST",
				data: {kd_surtu:kd_surtu, crud:7},
				success: function(data)
				{
					$("#approvalModal").modal("hide")
					fetchList()
					alert(data)
				}
			})
		}
	})
	
	//perbaikan
	$(document).on("click", "#perbaikan", function(){
		var kd_surtu = $("#kode-surtu").val()
		$("#perbaikanModal").modal("show")
		
	})
	
	$(document).on("click", "#simpan-perbaikan", function(){
		var kd_surtu = $("#kode-surtu").val()
		var catatan = CKEDITOR.instances.catatan_perbaikan_sdm.getData();
		//alert(kd_surtu+ ' ' +catatan)
		
		//view data pengajuan
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: {kd_surtu:kd_surtu, catatan_perbaikan_sdm:catatan, crud:9},
			success: function(data)
			{
				fetchList()
			},
			complete: function()
			{
				$("#perbaikanModal").modal("hide")
				$("#approvalModal").modal("hide")
			}
		})
	})
	
	//$('#perbaikanModal').on('shown.bs.modal', function() {
	    //CKEDITOR.replace('catatan_perbaikan_sdm')
	//})
	
	//close modal perbaikan
	$(document).on("click", "#close-perbaikan", function(){
		var kd_surtu = $("#kode-surtu").val("")
		$("#perbaikanModal").modal("hide")
	})
	
	//review -> jika Wadek ingin adanya perbaikan maka aktifkan tampilan approval untuk mengakomodir persetujuan ulang bila dimungkinkan adanya perbaikan dari SDM
	
	
	//tolak
	$(document).on("click", "#tolak", function(){
		var kd_surtu = $("#kode-surtu").val()
		$("#tolakModal").modal("show")
	})
	
	//Simpan status penolakan beserta alasannya
	$(document).on("click", "#simpan-tolak", function(){
		var kd_surtu = $("#kode-surtu").val()
		var catatan = CKEDITOR.instances.catatan_tolak_sdm.getData();
		//alert(kd_surtu+ ' ' +catatan)
		
		//view data pengajuan
		$.ajax({
			url: "views/surtu_crud.php",
			type: "POST",
			data: {kd_surtu:kd_surtu, catatan_tolak_sdm:catatan, crud:8},
			success: function(data)
			{
				fetchList()
			},
			complete: function()
			{
				$("#tolakModal").modal("hide")
				$("#approvalModal").modal("hide")
			}
		})
	})
	
	//close modal tolak
	$(document).on("click", "#close-tolak", function(){
		var kd_surtu = $("#kode-surtu").val("")
		$("#tolakModal").modal("hide")
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

	//$(".view_file").click(function(){
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

	//upload arsip surat tugas yang sudah final
	$(document).on("click", ".upload-arsip", function(){
		$("#uploadArsipModal").modal("show")
		var post_file_kode = $(this).data("surtu")
		$("#post_file_kode").val(post_file_kode)
	})
	
	$('#uploadArsipModal').on('hidden.bs.modal', function() {
		//alert("test")
	    //fetchList()
	 $.post("views/surtu_list_operator_ajax.php", function(data) {
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
	
	//upload draft surat tugas
	$(document).on("click", ".upload-draft", function(){
		$("#uploadDraftModal").modal("show")
		var post_kd_surtu = $(this).data("surtu")
		$("#post_kd_surtu").val(post_kd_surtu)
	})

	//refresh daftar surat tugas setelah modal upload tertutup 
	$('#uploadDraftModal').on('hidden.bs.modal', function() {
		$.post("views/surtu_list_operator_ajax.php", function(data) {
			$("#data-kegiatan").html(data)
		});
	})	
	
	//view file draft
	$(document).on("click", ".view_file_draft", function(){
		$("#viewDokumenModal").modal("show")
		//$(".modal-body #dokumen-view").html('<ul class="fa-ul"><li><i class="fa-li fa fa-spinner fa-spin"></i></li></ul>')
		var id = $(this).data("id")

		$.ajax({
			url: "views/surtu_view_draft.php",
			type: "POST",
			data: {id:id, ket:"file_draft"},
			success: function(data)   // A function to be called if request succeeds
			{
				//$(".modal-body #dokumen-view").html('<ul class="fa-ul"><li><i class="fa-li fa fa-spinner fa-spin"></li></ul>')
				$(".modal-body #dokumen-view").html(data)
			}
		});
	})

	$('#viewDokumenModal').on('hidden.bs.modal', function() {
		//$(".modal-body #dokumen-view").html('<div>processing...</div>')
	})

	$(document).on("click", ".download", function(){
		
		var jenis = $(this).data("jenis")
		var nama_file = $(this).data("nama_file")
		var alamat = 'views/download.php?jenis='+jenis+'&nama_file='+nama_file
		window.location = alamat

	})
})
</script>

<style>
table.frm-list thead {
	color: #fff;
  background-image: linear-gradient(to right, #614385 , #516395);
}
.fa-gradient {
	background: -webkit-gradient(linear, left top, left bottom, from(#5f2c82), to(#49a09d));
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
}
.embed-responsive-10by1 {
   padding-top: 100%;
}
</style>