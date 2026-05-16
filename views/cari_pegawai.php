<?
include('session_end.php');
include('../assets/css/daftar_pegawai_css.php');
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

<div class="row">

	<div class="col-md-12">
		<br><br><br>
<div class="container-daftar">		
		<div style="padding:5 10 5 10">
			<div class="box1">
				
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-2" style="text-align:right">
						<span class="label" style="font-size:26px; text-align:right; color:#428bca; text-shadow: 0px 1px 1px #fff">Periode</span>
					</div>
					<div class="col-md-3" style="text-align:left">
						<select name="periode" id="periode" class="form-control">
							<?=$dataOption?>
						</select>						
					</div>
					<div class="col-md-2"></div>
				</div>
				
				<div style="text-align:right; padding-right:15px">
					search: <input type="text" id="FilterTextBox" name="FilterTextBox" />
				</div>	
			</div>		
			<div class="box">
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
										<button id="'.$v['nip'].'" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal" data-tt="tooltip" title="tampilkan ke layar" style="color:#428bca"><i class="fa fa-television fa-align-center fa-lg faa-vertical"></i></button>
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
			</div>	
		</div>	
</div>	
	</div>
</div>

<!-- tempat menampilkan slip gaji -->
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header" style="background:#f6dB00; color:#000; text-shadow: 0px 1px 1px #fff">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel" style="text-align:center">Imbal Jasa Karyawan</h4>
			  </div>
			  <div class="modal-body">
				<?=$html?>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!--<button type="button" class="btn btn-primary">Save changes</button>-->
			  </div>
			</div>
		  </div>
		</div>	
