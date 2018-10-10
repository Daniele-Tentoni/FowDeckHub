<?php
function get_total_users_number($msqli) {
    // Recupero il numero totale di tutti i visitatori.
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) as 'Count' FROM users")) { 
        // Eseguo la query creata.
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count;
    } else {
        return "cinque";
    }
}

function get_new_users_number($mysqli) {
    // Recupero il timestamp
    $now = time();
    // Recupero il numero di tutti i login effettuari nell'ultimo giorno.
    $valid_attempts = $now - (24 * 60 * 60); 
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) as 'Count' FROM users WHERE dataaccesso > '$valid_attempts'")) {
        // Eseguo la query creata.
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count;
    } else {
        return "cinque";
    }
}

function get_monthly_registerd_users($mysqli) {
    // Recupero il timestamp
    $now = time();
    // Recupero il numero di tutti i login effettuari nell'ultimo mese.
    $valid_attempts = $now - (30 * 24 * 60 * 60); 
    if ($stmt = $mysqli->prepare("SELECT COUNT(*) as 'Count' FROM users WHERE dataaccesso > '$valid_attempts'")) {
        // Eseguo la query creata.
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count;
    } else {
        return "cinque";
    }
}
?>