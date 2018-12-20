<?php
/*
 * Legge una singola decklist.
 */ 
function get_decklist_by_id($mysqli, $id) {
	$res = array();
	$res["result"] = false;

	// Controllo che la connessione sia impostata.
	if(!isset($mysqli)) {
		$res["error"] = SERVER_ERR;
		return $res;
	}

	if(isset($mysqli) && $mysqli->connect_error) {
		$res["error"] = SERVER_CONN_ERR;
		return $res;
	}

	// Effettuo finalmente il caricamento della decklist in base all'id.
	$query = "select d.Id, 
					 d.Name, 
					 d.Player, 
					 d.GachaCode, 
					 dt.Name as Type, 
					 p.Name as Style, 
					 e.Id as EventId, 
					 e.Name as Event, 
					 d.Position, 
					 c.Name as Ruler,
					 d.Visibility
			  from decklists d
			  left join decktypes dt on d.Type = dt.Id
			  left join playstyles p on dt.Style = p.Id
			  left join `events` e on d.Event = e.Id
			  left join cards c on d.Ruler = c.Id
			  where d.Id = ?";

	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i", $id_param);
	$stmt->execute();
	$id_param = $mysqli->real_escape_string($id);
	$stmt->execute();
	$result = $stmt->get_result();
	if($result->num_rows > 0) {
		$res["content"] = array();
		$res["msg"] = "There's some data to view";
		$row = $result->fetch_assoc();
		$stringa = array();
		$stringa["Id"] = $row["Id"];
		$stringa["Name"] = $row["Name"];
		$stringa["Player"] = $row["Player"];
		$stringa["GachaCode"] = $row["GachaCode"];
		$stringa["Type"] = $row["Type"];
		$stringa["Style"] = $row["Style"];
		$stringa["EventId"] = $row["EventId"];
		$stringa["Event"] = $row["Event"];
		$stringa["Position"] = $row["Position"];
		$stringa["Ruler"] = $row["Ruler"];
		$stringa["Visibility"] = $row["Visibility"];
		$res["content"] = $stringa;
	} else {
		$res["msg"] = "No data to view with id $id.";
		return $res;
	}

	$res["result"] = true;
	return $res;
}

/*
 * Creazione di una nuova decklist.
 */
function create_new_decklist($mysqli){
	$res = array();
	$res["result"] = false;
	$res["error"] = "nothing";
	$content = "";

	// Controllo che la connessione sia impostata e che vi sia il login.
	if(!isset($mysqli)) {
		$res["error"] = SERVER_ERR;
		return $res;
	}

	if(isset($mysqli) && $mysqli->connect_error) {
		$res["error"] = SERVER_CONN_ERR;
		return $res;
	}

	if(!login_check($mysqli)) {
		$res["error"] = "You don't have login permissions.";
		return $res;
	}

	$content = "Operazioni effettuate: ";
	try {
		// Inserisco la nuova decklist.
		$stmt = $mysqli->prepare("INSERT INTO `decklists`(`Name`) VALUES (?)");
		if(!$stmt) {
			$res["data"] = $mysqli->error_list;
			$res["error"] = "Boolean value in \$stmt";
			return $res;
		} else {
			$stmt->bind_param("s", $deckname);
			$deckname = "Not set";
			if($stmt->execute()) {
				return get_decklist_by_id($mysqli, $mysqli->insert_id);
			} else {
				$res["result"] = false;
				$res["data"] = $mysqli->error_list;
				$content .= "There's an error. Riscontrato problema nell'inserimento della carta $deckname, contattare il supporto.";
			}
		}
	} catch (Exception $e) {
		// Posso effettuare un rollback di tutte le query fatte finora sul db.
		$res["result"] = false;
		$res["error"] = "Eccezione";
		$res["msg"] = $e;
	}
	$res["content"] = $content;
	return $res;
}

/*
 * Mi salvo i dati base dell'evento.
 */
function save_base_decklist_data($mysqli, $id, $name, $player, $event, $type, $position, $gacha_code, $visibility) {
    $res = array();
	$res["result"] = false;

	// Controllo che la connessione sia impostata.
	if(!isset($mysqli)) {
		$res["message"] = SERVER_ERR;
		return $res;
	}

	if(isset($mysqli) && $mysqli->connect_error) {
		$res["message"] = SERVER_CONN_ERR;
		return $res;
	}

	// Effettuo update della sezione dei dati base e converto la data in timestamp se necessario.
	$query = "UPDATE `decklists` SET `Name`=?,`Player`=?,`Event`=?,`Type`=?,`Visibility`=?,`GachaCode`=?,`Position`=? WHERE `Id`=?";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("ssiiisii", $name_param, $player_param, $event_param, $type_param, $visibility_param, $gacha_code_param, $position_param, $id_param);
	$id_param = $mysqli->real_escape_string($id);
	$name_param = $mysqli->real_escape_string($name);
	$player_param = $mysqli->real_escape_string($player);
	$event_param = $mysqli->real_escape_string($event);
	$type_param = $mysqli->real_escape_string($type);
	$position_param = $mysqli->real_escape_string($position);
	$gacha_code_param = $mysqli->real_escape_string($gacha_code);
	$visibility_param = $mysqli->real_escape_string($visibility);
	if($stmt->execute()){
        $res["result"] = true;
        $res["message"] = "Update correctly completed.";
        $res["data"] = $data_param;
    } else {
        $res["error"] = "query";
        $res["number"] = $mysqli->errno;
        $res["message"] = $mysqli->error;
    }
    
	return $res;
}

/*
 * Creo o aggiorno i ruler breakdown.
 */
function save_decklist($mysqli, $id, $decks) {
    $res = array();
	$res["result"] = false;
	$res["message"] = "";

	// Controllo che la connessione sia impostata.
	if(!isset($mysqli)) {
		$res["message"] = SERVER_ERR;
		return $res;
	}

	if(isset($mysqli) && $mysqli->connect_error) {
		$res["message"] = SERVER_CONN_ERR;
		return $res;
	}

	// Effettuo finalmente il caricamento della decklist.
	// Carico tutte le decklists.
	$query = "DELETE FROM card_quantities WHERE Decklist = ?";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("i", $deck_param);
	$deck_param = $mysqli->real_escape_string($id);
	//$res["message"] .= var_dump($decks) . " ||| ";
	if($stmt->execute()){
        // Divido i mazzetti da aggiungere.
        foreach ($decks["ruler"]["deck"] as $key => $value) {
			$query = "INSERT INTO `card_quantities`(`Decklist`, `Card`, `Decktype`, `Quantity`) VALUES (?,(SELECT c.Id
					  FROM cards c
					  WHERE c.Name = ?),0,?)";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("isi", $deck_param, $card_param, $quantity_param);
			$card_param = $mysqli->real_escape_string($value["name"]);
			$quantity_param = $mysqli->real_escape_string($id["count"]);
			if(!$stmt->execute()) {
				// Interrompo solamente se c'è un errore.
        		$res["error"] = "query";
				$res["query"] = $query;
        		$res["number"] = $mysqli->errno;
        		$res["message"] .= $mysqli->error . var_dump($value);
				$res["message"] .= " There were problems during the insert of the ruler " . $value["name"] . " di quantita " . $value["count"];
				return $res;
			}
        }
		
        foreach ($decks["rune"]["deck"] as $key => $value) {
			$query = "INSERT INTO `card_quantities`(`Decklist`, `Card`, `Decktype`, `Quantity`) VALUES (?,(SELECT c.Id
					  FROM cards c
					  WHERE c.Name = ?),1,?)";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("isi", $deck_param, $card_param, $quantity_param);
			$card_param = $mysqli->real_escape_string($value["name"]);
			$quantity_param = $mysqli->real_escape_string($id["count"]);
			if(!$stmt->execute()) {
				// Interrompo solamente se c'è un errore.
        		$res["error"] = "query";
				$res["query"] = $query;
        		$res["number"] = $mysqli->errno;
        		$res["message"] .= $mysqli->error . var_dump($value);
				$res["message"] .= " There were problems during the insert of the rune " . $value["name"] . " di quantita " . $value["count"];
				return $res;
			}
        }
		
        foreach ($decks["main"]["deck"] as $key => $value) {
			$query = "INSERT INTO `card_quantities`(`Decklist`, `Card`, `Decktype`, `Quantity`) VALUES (?,(SELECT c.Id
					  FROM cards c
					  WHERE c.Name = ?),2,?)";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("isi", $deck_param, $card_param, $quantity_param);
			$card_param = $mysqli->real_escape_string($value["name"]);
			$quantity_param = $mysqli->real_escape_string($id["count"]);
			if(!$stmt->execute()) {
				// Interrompo solamente se c'è un errore.
        		$res["error"] = "query";
				$res["query"] = $query;
        		$res["number"] = $mysqli->errno;
        		$res["message"] .= $mysqli->error . var_dump($value);
				$res["message"] .= " There were problems during the insert of the main " . $value["name"] . " di quantita " . $value["count"];
				return $res;
			}
        }
		
        foreach ($decks["side"]["deck"] as $key => $value) {
			$query = "INSERT INTO `card_quantities`(`Decklist`, `Card`, `Decktype`, `Quantity`) VALUES (?,(SELECT c.Id
					  FROM cards c
					  WHERE c.Name = ?),3,?)";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("isi", $deck_param, $card_param, $quantity_param);
			$card_param = $mysqli->real_escape_string($value["name"]);
			$quantity_param = $mysqli->real_escape_string($id["count"]);
			if(!$stmt->execute()) {
				// Interrompo solamente se c'è un errore.
        		$res["error"] = "query";
				$res["query"] = $query;
        		$res["number"] = $mysqli->errno;
        		$res["message"] .= $mysqli->error . var_dump($value);
				$res["message"] .= " There were problems during the insert of the side " . $value["name"] . " di quantita " . $value["count"];
				return $res;
			}
        }
		
        foreach ($decks["stone"]["deck"] as $key => $value) {
			$query = "INSERT INTO `card_quantities`(`Decklist`, `Card`, `Decktype`, `Quantity`) VALUES (?,(SELECT c.Id
					  FROM cards c
					  WHERE c.Name = ?),4,?)";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("isi", $deck_param, $card_param, $quantity_param);
			$card_param = $mysqli->real_escape_string($value["name"]);
			$quantity_param = $mysqli->real_escape_string($id["count"]);
			if(!$stmt->execute()) {
				// Interrompo solamente se c'è un errore.
        		$res["error"] = "query";
				$res["query"] = $query;
        		$res["number"] = $mysqli->errno;
        		$res["message"] .= $mysqli->error . var_dump($value);
				$res["message"] .= " There were problems during the insert of the stone " . $value["name"] . " di quantita " . $value["count"];
				return $res;
			}
        }
    } else {
        $res["error"] = "query";
        $res["number"] = $mysqli->errno;
        $res["message"] = $mysqli->error;
    }
    
	return $res;
}
?>