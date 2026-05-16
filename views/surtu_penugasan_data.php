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

<div class="modal fade" id="editPenugasanModal" tabindex="-1" role="dialog" aria-labelledby="editPenugasanModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="editPenugasanLabel">New message</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<form id="frm-edit-penugasan">
					<div class="form-group row">
						<div class="col-xs-8">
							<label for="nama">Nama yang Ditugaskan</label>
							<input name="edit_nama" id="edit_nama" type="text"  class="form-control col-xs-4" value="" placeholder="type keywords to search" autocomplete="off"/>
							
						</div>
						<div class="col-xs-3">
							<label for="ex2">&nbsp;</label>
							<input class="form-control btn btn-info btn-sm" value="clear to search" id="clear-to-search-edit" >
						</div>						
					</div>
					<div id="edit_kotaksugest" ></div>
					<div class="clearfix"></div>
					<div class="form-group">
						<label for="nip">NPM/NIP/NUP</label>
						<input name="edit_nip" id="edit_nip" type="text"  class="form-control" value="" placeholder="NIP/NUP/NPM"/>
					</div>
					<div class="form-group">
						<label for="sebagai">Jabatan</label>
						<input name="edit_sebagai" id="edit_sebagai" type="text"  class="form-control" value="" placeholder="Jabatan/Sebagai"/>
					</div>
					<div class="form-group">
						<label for="bantuan">Keterangan</label>
						<input name="edit_bantuan" id="edit_bantuan" type="text"  class="form-control" value="" placeholder="Bantuan"/>
					</div>
					<input name="edit_id" id="edit_id" type="hidden"  class="form-control" value=""/>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-warning close-modal-edit-penugasan" data-dismiss="modalx">Batal</button>
				<button type="button" class="btn btn-primary" id="simpan-edit-penugasan" >Simpan</button>
			</div>
		</div>
	</div>
</div>

<script>
var id = 0
$(".edit_penugasan").click(function(){
	$("#editPenugasanModal").modal("show")
	var id = $(this).data("id")
	 var nama = $(this).data("id")
	$("#edit_id").val(id)
	 $("#edit_nama").val( $(this).data("nama") )
	 $("#edit_nip").val( $(this).data("nip") )
		$("#edit_sebagai").val( $(this).data("sebagai") )
		$("#edit_bantuan").val( $(this).data("bantuan") )
})

$(".close-modal-edit-penugasan").click(function(){
	$("#editPenugasanModal").modal("hide")
})

$("#simpan-edit-penugasan").click(function(){
	var fields = $("#frm-edit-penugasan input").serializeArray();
	var kd_surtu = $("#kd_surtu").val()
	fields.push({ name: "crud", value: 6 });
	fields.push({ name: "kd_surtu", value: kd_surtu });
	console.log(fields)
	
	$.ajax({
		url: "views/surtu_crud.php",
		type: "POST",
		data: fields,
		success: function(data)   // A function to be called if request succeeds
		{
			//$("#results").html('<pre>'+data+'</pre>');
			console.log(data)
			setTimeout(function() { $('#editPenugasanModal').modal('hide'); }, 0);
		}					
	});
	/*
	$.ajax({
		url: "views/surtu_penugasan_data.php",
		type: "POST",
		data: {kd_surtu:kd_surtu},
		success: function(data)   // A function to be called if request succeeds
		{
			$("#data-penugasan").html(data)
		},
		complete: function(data) {
            setTimeout(function() { $('#editPenugasanModal').modal('hide'); }, 2300);
        }           
	});
	*/
})

$("#edit_nama").keyup(function(){
	var kata = $("#edit_nama").val()
	
	$.ajax({
		url: "views/surtu_cari_nama.php", // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: {q:kata}, 	//  -> Data sent to server, a set of key/value pairs (i.e. form fields and values)
		success: function(data)   // A function to be called if request succeeds
		{
			$("#edit_kotaksugest").html(data);
		}					
	});
})

$(document).on("click", ".isi", function(){
	var nip = $(this).children().eq(0).text()
	var nama = $(this).children().eq(1).text()
	$("#edit_kotaksugest").text("")
	$("#edit_nip").val(nip)
	$("#edit_nama").val(nama)
})

$(document).on("click", "#clear-to-search-edit", function(){
	$("#edit_nip").val("")
	$("#edit_nama").val("")
	$("#edit_sebagai").val("")
	$("#edit_bantuan").val("")
	$("#edit_kotaksugest").val("")
	$("#edit_nama").focus()
})

$("#editPenugasanModal").on("shown.bs.modal", function () {
	$("#edit_nip").text("")
	$("#edit_nama").text("")
	$("#edit_sebagai").text("")
	$("#edit_bantuan").text("")
	$("#edit_kotaksugest").text("")
	$("#edit_nama").focus()
})


	$('#editPenugasanModal').on('hidden.bs.modal', function () {
    	var kd_surtu = $("#kd_surtu").val()
		
		$.ajax({
			url: "views/surtu_penugasan_data.php",
			type: "POST",
			data: {kd_surtu:kd_surtu},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penugasan").html(data)
			}
		});
	});

</script>