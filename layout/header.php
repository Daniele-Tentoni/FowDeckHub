<!DOCTYPE html>
<html lang="it">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $title; ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->       
		
        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->  
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->                             
    </head>
    <body>
		<!-- START PAGE CONTAINER -->
        <div class="page-container">
			<!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <a href="index.php">Fow Deck Hub<?php if(TEST) echo "*"; ?></a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
					<?php
					if(isset($login_checked) && $login_checked) {
						echo "<li class=\"xn-profile\">";
						echo "	<div class=\"profile\">";
						echo "		<div class=\"profile-data\">";
						echo "			<div class=\"profile-data-name\">" . $_SESSION['user_name'] . "</div>";
						echo "			<div class=\"profile-data-title\">" . $_SESSION['user_title'] . "</div>";
						echo "		</div>";
						echo "	</div>";                                                                        
						echo "</li>";
					}
					?>
                    <li class="xn-title">Navigation</li>
                    <li class="<?php if(isset($active_page) && $active_page == 0) { echo "active"; } ?>">
                        <a href="index.php"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>                        
                    </li>                    
                    <li class="xn-openable <?php if(isset($active_page) && $active_page >= 10 && $active_page < 20) { echo "active"; } ?>">
                        <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Administration</span></a>
                        <ul>
                            <li class="<?php if(isset($active_page) && $active_page == 10) { echo "active"; } ?>"><a href="users.php"><span class="fa fa-image"></span> Users</a></li>
                            <li class="<?php if(isset($active_page) && $active_page == 11) { echo "active"; } ?>"><a href="cards.php"><span class="fa fa-user"></span> Cards</a></li>
                            <li class="<?php if(isset($active_page) && $active_page == 12) { echo "active"; } ?>"><a href="events.php"><span class="fa fa-users"></span> Events</a></li>
                            <li class="<?php if(isset($active_page) && $active_page == 13) { echo "active"; } ?>"><a href="decklists.php"><span class="fa fa-comments"></span> Decklists</a></li>
                        </ul>
                    </li>
                    <li class="xn-openable <?php if(isset($active_page) && $active_page >= 20 && $active_page < 30) { echo "active"; } ?>">
                        <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Users</span></a>
                        <ul>
                            <li class="<?php if(isset($active_page) && $active_page == 20) { echo "active"; } ?>"><a href="decklists.php"><span class="fa fa-comments"></span> Decklists</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SIGN IN/OUT -->
                    <?php
					if(isset($login_checked) && $login_checked){
						?>
						<li class="xn-icon-button pull-right">
							<a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
						</li> 
						<?php
					} else {
						?>
						<li class="xn-icon-button pull-right">
							<a href="login.php" class=""><span class="fa fa-sign-in"></span></a>
						</li>
						<li class="xn-icon-button pull-right">
							<a href="register.php" class=""><span class="fa fa-plus"></span></a>
						</li>
						<?php
					}
					?>
                    <!-- END SIGN OUT -->
                    <!-- MESSAGES -->
					<?php
					if(isset($login_checked) && $login_checked) {
						?>
						<li class="xn-icon-button pull-right">
							<a href="#"><span class="fa fa-comments"></span></a>
							<div class="informer informer-danger">1</div>
							<div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
								<div class="panel-heading">
									<h3 class="panel-title"><span class="fa fa-comments"></span> Notifications</h3>
									<div class="pull-right">
										<span class="label label-danger">0 new</span>
									</div>
								</div>
								<div class="panel-body list-group list-group-contacts scroll" style="height: 200px;">
									<a href="#" class="list-group-item">
										<div class="list-group-status status-online"></div>
										<img src="assets/images/users/user2.jpg" class="pull-left" alt="John Doe"/>
										<span class="contacts-title">Admin</span>
										<p>Welcome to Fow Deck Hub!</p>
									</a>
								</div>     
								<div class="panel-footer text-center">
									<a href="pages-messages.html">Show all</a>
								</div>                            
							</div>                        
						</li>
						<?php
					} else {
						?>
						<?php
					}
					?>
                    <!-- END MESSAGES -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->