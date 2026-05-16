  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background: #293949;">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">
          	<img src="../assets/images/logo-fisip-tes-putih.png" alt="logo" height="50" width="102" style="margin-left:30px; margin-top:-15px">
          </a>
          <a href="#menu-toggle" class="btn btn-default btn-sm" id="menu-toggle" style="margin-left:0px; margin-top:10px; background:#293949; color:#fff;">&nbsp;&nbsp;Menu&nbsp;&nbsp;</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?php
						#$photo = 'data:image/png;base64,'.$foto;
						#echo '<img src = '.$photo.' class="" alt="User Image" style="position:relative; border-radius:10%; margin-top:-10px; height:30px; background:#fff; padding:0 !important"/>';
						?>&nbsp; 
						<?=$_SESSION['name']?> 
					</a>
					<ul class="dropdown-menu" role="menu">
						<li>
							<a href="#" id="logout" ><span class="glyphicon glyphicon-off" style="font-size:13px; text-align:center"></span>&nbsp;sign out</a>
						</li>
					</ul>
				</li>

				<li>
					<div id="container" style="text-align:center; margin-top:7px" rowspan="2">
						<div id="countdown"></div>						
						<script type="text/javascript" charset="utf-8">
						var clock = $("#countdown").countdown360({
							radius      : 15,
							seconds     : 900,
							fontColor   : '#FFFFFF',
							fillStyle	: '#555',
							strokeStyle	: '#FFDB58',
							fontWeight	: 200,
							autostart   : false,
							onComplete  : function () { 
												console.log('done');
												$.ajax({
													type: "POST",
													url: "views/logout.php",
													data: "action=" + logout,
													success: function(data){
														$(location).attr('href', 'https://sdm.fisip.ui.ac.id/surattugas/');
													}
												});	
											}
						});
						clock.start();
						</script>				
					</div>
				</li>
          </ul>
          <!--<form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>-->
        </div>
      </div>
    </div>
	
	<!--
	<div id="logo">
		<h1>
			<a href="http://techlister.com/filetree/" title="Folder Tree with PHP and jQuery"><img src="http://techlister.com/ajaxlogin/css/techlister_logo.png" alt="Folder Tree with PHP and jQuery" title="Folder Tree with PHP and jQuery" border="0" style="border: 0px;" /></a>
		</h1>
		<div id="pgtitle">
			Folder Tree with PHP and jQuery
		</div>
	</div>
	-->
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
        	
            <div class="sidebar">
            	
				<div id="leftside-navigation">
					<ul>
						<li>
							<a style="line-height:15px">&nbsp;</a>
						</li>
					</ul>	
							
					<ul>
						<li>
							<a href="#"><i class="fa fa-user"></i>Role: <span><?=$_SESSION['role']?></span></a>
						</li>
					</ul>
					<!--
					<ul>
						<li>
							<a href="?LHdsPsChCw3JZFsp5BO_dKtV8cQAcZTM6mC117hb5xw" id="" style="" ><span class="glyphicon glyphicon-file" style="font-size:13px; text-align:center"></span>&nbsp;FORM SDM</a>
						</li>
					</ul>
					-->
					<ul>
						<?= $this->get_menu('0');?>
					</ul>
					<ul>
						<li>
							<a href="views/logout.php" id="logout" style="color:#ED4337" ><span class="glyphicon glyphicon-off" style="font-size:13px; text-align:center"></span>&nbsp;sign out</a>
						</li>
					</ul>
					
					<?php 
					/*if($_SESSION['username']=='mnurulamri'){
					echo '
					<ul>
						<li>
							<a href="?aWprPXN1cnR1X2xpc3RfdW5pdA" id="" style="" ></span>&nbsp;List Unit Test</a>
						</li>
					</ul>';
					}*/
					?>
						
				</div>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapperx" style="margin:auto">
        	
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
						<!--<a href="#menu-toggle" class="btn btn-default" id="menu-toggle" style="margin-left:-40px; margin-top:19px; background:#293949; color:#fff; position:fixed">&nbsp;&nbsp;&nbsp;<i class="fa fa-bars"></i>&nbsp;&nbsp;</a>-->
						<div id="datax" style="font-size:16px">
							<!-- end of layout 1 -->
								<br>