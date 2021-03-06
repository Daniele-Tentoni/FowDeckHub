<?php
	// Variabili globali, funzioni di db/login e controllers.
	require_once '../definings.php';
	require_once ROOT_PATH . '/config/functions.php';
	sec_session_start();
	require_once ROOT_PATH . '/controllers/bug_report.php';
	$result = array();
	$result["result"] = false;
	$result["error"] = "nothing";
	$content = "";
	
	/* 
	 * Come anche in altri destinatari di chiamate ajax, questo file dovrà sempre mandare in echo dei file json.
	 * In questo modo cerco di dare un certo ordine al mio codice per fare meglio manutenzione.
	 * L'obiettivo sarà poi quello di sfruttare appieno la potenzialità del linguaggio ad oggetti del php e non
	 * solamente il lato funzionale molto piatto. Model-View-Controller.
	 
	 * Controllo se l'utente è loggato solamente per le funzioni necessarie.
	 */
	
	// Qui controllo quale operazione devo eseguire arrivato dalla chiamata ajax.
	if(isset($_GET["new_bug"])) {
		// Creo il nuovo bug.
		$name = $mysqli->real_escape_string($_POST["name"]);
		$email = $mysqli->real_escape_string($_POST["email"]);
		$bug = $mysqli->real_escape_string($_POST["bug"]);
		$result = new_bug($mysqli, $name, $email, $bug);
		echo json_encode($result);
	} else if(isset($_GET["change_state"]) && 
			  isset($_POST["id"]) && 
			  $_POST["id"] > 0 && 
			  isset($_POST["state"]) && 
			  $_POST["state"] > 0 && 
			  $_POST["state"] < 5) {
		// Questa è una funzione che richiede il login.
		if(!login_check($mysqli)) {
			$result["error"] = "Niente login";
			echo json_encode($result);
			return;
		}
		
		// Non deve essere possibile cambiare lo status di un bug_report  in new, quindi maggiore di 1 deve essere.
		$id = $mysqli->real_escape_string($_POST["id"]);
		$state = $mysqli->real_escape_string($_POST["state"]);
		$result = change_state_bug($mysqli, $id, $state);
		echo json_encode($result);
	} else if(isset($_GET["numbers"])) {
		// Questa è una funzione che richiede il login.
		if(!login_check($mysqli)) {
			$result["error"] = "Niente login";
			echo json_encode($result);
			return;
		}
		
		// Chiamata che arriva dal widget che vuole sapere il numero dei vari bug.
		$result = get_bug_numbers();
		echo json_encode($result);
	} else {
		// Comunico che non ho capito quale operazione mi è richiesta.
		$result["error"] = "Operazione non riconosciuta.";
		echo json_encode($result);
	}
	
?>