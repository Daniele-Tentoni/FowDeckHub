<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/functions.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
sec_session_start();
// Controllo di essere collegato, se sono in test eseguo automaticamente un login.
$log_result = login_check($mysqli);
if($log_result) {
	$login_checked = true;
	$active_page = 11;
    $title = "Cards - Administrator - Fow Deck Hub";
	require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/cards_partial.php';
	require_once $_SERVER['DOCUMENT_ROOT'] . '/layout/footer.php';
} else {
    var_dump($log_result);
    header("Refresh: 5;URL=login.php");
}
?>