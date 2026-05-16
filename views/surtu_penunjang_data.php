<?php
ini_set('display_errors', 1);
include "pdo.class.php";
$pdo = new Database();
$kd_surtu = htmlspecialchars($_POST['kd_surtu']);
//$kd_surtu = 'bc320e2a2a23746f95d6';
$sql = " SELECT * FROM surtu_penunjang WHERE kd_surtu = '$kd_surtu' "; 

$pdo->query($sql);
$result = $pdo->resultset();

//print_r($result);
	$html = '
	<table class="table table-bordered">
		<thead>
			<tr>
		 		<th>No</th>
		 		<th>Nama File</th>
		 		<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>';
	$no=1;
	if(count($result)>0){
		foreach ($result as $row){
			$html.= '
				<tr>
					<td>'.$no.'</td>
					<td>'.$row['file_name'].'</td>
					<td class="view_file" data-id="'.$row['id'].'"><div class="btn btn-info btn-xs">view</div></td>
					<td class="delete_file" data-id="'.$row['id'].'" data-surtu="'.$row['kd_surtu'].'"><div class="btn btn-danger btn-xs">delete</div></td>
				</tr>';
				$no++;
		}
		$html.='</tbody></table>';
		echo $html;
	} else {
		$html.=  '
				<tr>
				 	<td>&nbsp;</td>
				 	<td>&nbsp;</td>
				 	<td>&nbsp;</td>
				 	<td>&nbsp;</td>		 		
			 	</tr>
			</tbody>
		</table>';
		echo $html;
	}
?>

<script type="text/javascript">
$(".view_file").click(function(){
	$("#viewDokumenModal").modal("show")
	var id = $(this).data("id")
	$.ajax({
		url: "views/surtu_view_file.php",
		type: "POST",
		data: {id:id},
		success: function(data)   // A function to be called if request succeeds
		{
			$(".modal-body #dokumen-view").html(data)
		}         
	});
})
</script>

<style>
/* form view */
.embed-responsive-10by1 {
   padding-top: 100%;
}
</style>