<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="index.php">Home</a></li>
	<li><a class="active" href="#">Events</a></li>
</ul>
<!-- PAGE TITLE -->
<div class="page-title">
	<h2 onclick="history.back()"><span class="fa fa-arrow-circle-o-left"></span> Event List</h2>
</div>
<!-- END PAGE TITLE -->
<!-- PAGE CONTENT WRAPPER --> 
<div class="page-content-wrap">
	<div class="row">
		<div class="col-md-12">
			<!-- START RESPONSIVE TABLES -->
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Events</h3>
							<a href="events.php?new_event" class="btn btn-primary btn-rounded pull-right" ><i class="fa fa-plus"></i>New</a>
						</div>
                        <div class="panel-body"> 
							<div class="table-responsive"> 
								<?php
									require_once ROOT_PATH . '/components/tables/events_table.php';
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END RESPONSIVE TABLES -->
		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

<!-- MESSAGE BOX--> 
<div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
	<div class="mb-container">
		<div class="mb-middle">
			<div class="mb-title"><span class="fa fa-times"></span> Remove <strong>Data</strong> ?</div>
			<div class="mb-content">
				<p>Are you sure you want to remove this row?</p>
				<p>Press Yes if you sure.</p>
			</div>
			<div class="mb-footer">
				<div class="pull-right">
					<button class="btn btn-success btn-lg mb-control-yes">Yes</button>
					<button class="btn btn-default btn-lg mb-control-close">No</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END MESSAGE BOX-->

<!-- START THIS PAGE PLUGINS-->
<script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/demo_tables.js"></script>
<!-- END THIS PAGE PLUGINS-->