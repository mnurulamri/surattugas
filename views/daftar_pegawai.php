<?
include('../models/Model.php');
$model = new Model();

$periode = $_POST['periode'];
$data = $model->getPegawaiPerPeriode($periode);
		/*$sql = "SELECT nip, nama, status_peg, unit_kerja
				FROM ijk
				WHERE periode = '$periode'
				ORDER BY nama";				
		$result = mysql_query($sql) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$data[] = $row;
		}*/

//print_r($data);

?>

<script>
$(document).ready(function(){
 //add index column with all content.
	 $(".filterable tr:has(td)").each(function(){
	   var t = $(this).text().toLowerCase(); //all row text
	   $("<td class='indexColumn'></td>")
		.hide().text(t).appendTo(this);
	 });//each tr
 
	 $("#FilterTextBox").keyup(function(){
	   var s = $(this).val().toLowerCase().split(" ");
	   //show all rows.
	   $(".filterable tr:hidden").show();
	   $.each(s, function(){
		   $(".filterable tr:visible .indexColumn:not(:contains('"
			  + this + "'))").parent().hide();
	   });//each
	 });//key up.
	 
	//------------------------- filter cloumn -------------------------
    //<![CDATA[
      $(document).ready(function() {
        $('.filter').multifilter()
      })
    //]]>
});//document.ready
</script>

					<table id="tblToGrid1"  class="filterable" name="grid2" cellpadding="0" cellspacing="0" gridWidth="100%" gridHeight="75%" lightnavigation="false" border="0">
					<!--<table border="1">-->
						<thead>
							<tr class="header" style="height:auto">
								<td class="nip">NIP</td>
								<td class="nama">NAMA</td>
								<td class="status">STATUS PEGAWAI</td>
								<td class="unit_kerja">UNIT KERJA</td>
								<td class="icon"><div class="fa fa-cloud-download fa-color-facebook fa-lg"></div></td>
								<td class="left-header"></td>
							</tr>
						</thead>
					</table>
				<div id="loading" style="display:none">Loading...</div>
				<div id="gridbox" style="overflow:scroll; height:95%">
					<table id="tblToGrid2"  class="filterable" name="grid2" cellpadding="0" cellspacing="0" gridWidth="100%" gridHeight="75%" lightnavigation="false" border="0">
						<thead>
							<tr style="height:auto">
								<th class="nip">&nbsp;</th>
								<th class="nama">&nbsp;</th>
								<th class="status">&nbsp;</th>
								<th class="unit_kerja">&nbsp;</th>
								<th class="icon"></th>
							</tr>
						</thead>
						<tbody>
							<?
							$html='';
							foreach($data as $k => $v){
								$html.= '
								<tr>
									<td class="nip">'.$v['nip'].'</td>
									<td class="nama">'.$v['nama'].'</td>
									<td class="status">'.$v['status_peg'].'</td>
									<td class="unit_kerja">'.$v['unit_kerja'].'</td>
									<td class="icon">
									<div>
										<button id="'.$v['nip'].'" class="item_pegawai btn btn-default btn-xs" data-toggle="modal" data-target="#gajiModal" data-tt="tooltip" title="tampilkan ke layar" style="color:#428bca"><i class="fa fa-television fa-align-center fa-lg faa-vertical"></i></button>
										&nbsp;
										<span class="btn-group">
											<button type="button" class="btn btn-danger btn-xs" style="cursor:auto;"><i class="fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style=" color:#fff"></i></button>
											<button type="button" id="pdf:'.$v['nip'].'" class="1 cetak btn btn-default btn-xs" data-tt="tooltip" title="format kertas kop" style="background:#fff; color:#666">
													<span style="padding-left:2px; font-family:tahoma; font-size:11px; color:#3EA055">Kop</span>
											</button>
											<button type="button" id="pdf:'.$v['nip'].'" class="0 cetak btn btn-default btn-xs" data-tt="tooltip" title="format kertas biasa" style="background:#fff; color:#666>
												<span type="button" class="fa fa-file-pdf-o fa-align-center fa-lg faa-vertical" style="color:red">
													<span style="padding-left:2px; font-family:tahoma; font-size:11px; color:#3EA055; margin-top:-5px""><s>Kop</s></span>
												</span>
											</button>
										</span>										
									</div>
									</td>
								</tr>';
							}
							$html.='';
							echo $html;
							?>
						</tbody>
					</table>		
				</div>
