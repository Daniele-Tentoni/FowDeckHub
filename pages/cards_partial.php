<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="index.php">Home</a></li>
	<li><a href="#">Cards</a></li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE TITLE -->
<div class="page-title">                    
	<h2><a onclick="history.back()" class="link"><span class="fa fa-arrow-circle-o-left"></span></a> Card List</h2>
</div>
<!-- END PAGE TITLE -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		<div class="col-md-12">
			<!-- START RESPONSIVE TABLES -->
			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Cards</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<?php require_once ROOT_PATH . '/components/tables/cards_table.php'; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Cards</h3>
							<button class="btn btn-primary btn-rounded pull-right" onclick="new_row('true')"><i class="fa fa-plus" aria-hidden="true"></i> New</button>
						</div>
						<div class="panel-body">
							<!-- START ADD CARD MODAL -->
							<?php require_once ROOT_PATH . '/components/modals/add_card_modal.php'; ?>
							<!-- END ADD CARD MODAL -->
						</div>
						<div class="panel-footer">
							<!-- Pannello degli errori non visibile -->
							<div class="e-panel panel" style="display:none">
								<div class="e-body panel-body">
								</div>
							</div>
					
							<button class="btn btn-primary btn-rounded pull-right" onclick="new_row('true')"><i class="fa fa-floppy-o" aria-hidden="true"></i> Modify</button>
						</div>
					</div>
				</div>
			</div>
			<!-- END RESPONSIVE TABLES -->
			
		<!-- END PAGE CONTENT WRAPPER -->                                    
		</div>         
	</div>            
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->    

<!-- REMOVE MESSAGE BOX-->
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

<!-- START SINGLE CARD MODAL -->
<?php require_once ROOT_PATH . '/components/modals/single_card_modal.php'; ?>
<!-- END SINGLE CARD MODAL -->

<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
<script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>

<script type="text/javascript" src="js/demo_tables.js"></script>
<!-- END THIS PAGE PLUGINS-->  