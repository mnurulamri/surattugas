                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->	
	
	<!--<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar" style="overflow-x: scroll;">
				<div id="container"> </div>
				<div id="selected_file"></div>
			</div>
			
			<div class=" col-md-offset-2 col-md-10 main">		
				<div id="data" style="font-size:16px"></div>
				<div id="test"></div>
			</div>
		</div>
	</div>-->

<!-- Menu Toggle Script -->
<script>
$("#menu-toggle").click(function(e) {
	e.preventDefault();
	$("#wrapper").toggleClass("toggled");
});
$("#leftside-navigation .sub-menu > a").click(function(e) {
  $("#leftside-navigation ul ul").slideUp(), $(this).next().is(":visible") || $(this).next().slideDown(),
  e.stopPropagation()
})
</script>
<link href="assets/css/layout.css" rel="stylesheet">

</body>
<script type="text/javascript">
function myFunction() {
  //alert("Page is loaded");
  $("#wrapper").toggleClass("toggled");
}
</script>
</html>