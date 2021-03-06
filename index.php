<?php
require_once 'definings.php';
require_once ROOT_PATH . '/config/functions.php';
sec_session_start();
require_once ROOT_PATH . '/controllers/event_controller.php';

// Controllo di essere collegato, se sono in test eseguo automaticamente un login.
$log_result = login_check($mysqli);
// Controllo il livello senza tracciarlo, altrimenti qui sarebbe un morire.
$check_level = check_level($mysqli, 2, false);

if($log_result && $check_level == 0) {
	$login_checked = true;
    $title = "Dashboard - Administrator - Fow Deck Hub";
    $active_page = 0;
    $events = get_event_widget_details($mysqli, 2018);
    require_once ROOT_PATH . '/layout/header.php';
    require_once ROOT_PATH . '/pages/index_partial.php';
} else {
    $login_checked = false;
    $title = "Decklists from the world - Fow Deck Hub";
    $events = get_n_latest_events($mysqli, 3);
    $show_visibility = false;
    $show_actions = false;
    $active_page = 0;
    require_once ROOT_PATH . '/layout/user_header.php';
    require_once ROOT_PATH . '/pages/user_index_partial.php';
}

// Il footer è uguale per entrambi. A dir la verità anche un pezzo di header.
require_once ROOT_PATH . '/layout/footer.php';
?>
