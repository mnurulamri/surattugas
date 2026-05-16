<?
include('session_end.php');
include('../assets/css/daftar_pegawai_css.php');
?>

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
					<div class="box" id="daftar_pegawai">
						
					</div>	
				</div>	
		</div>	
	</div>
</div>

<!-- tempat menampilkan slip gaji -->
<!-- Modal -->
<div class="modal fade" id="gajiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header" style="background:#f6dB00; color:#000; text-shadow: 0px 1px 1px #fff">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel" style="text-align:center">Imbal Jasa Karyawan</h4>
			</div>
			<div class="modal-body">
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<!--<button type="button" class="btn btn-primary">Save changes</button>-->
			</div>
		</div>
	</div>
</div>	

<script type="text/javascript">
	$('#loading').show();
	var periode = $("#periode").val();
	$.ajax({
		type: "POST",
		url: "views/daftar_pegawai.php",
		data: {periode:periode},
		success: function(data){
			
			$('#loading').hide();	
			$('#daftar_pegawai').html(data);
			clock.start();
		}
	});	
</script>