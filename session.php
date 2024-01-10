<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
    <link type="text/css" rel="stylesheet" href="Css/sessionstyle.css">
</head>
<body>
    <section class="top">
        <form action="" method="post">
            <label>Introduire le nom de la ville : </label><input type="text" name="recherche">
            <button type="submit" name="rch">Recherche</button>
        </form>
    </section>
</body>
</html>

<?php
session_start();

if (isset($_SESSION['user_login'])) {
    echo "Salut, " . $_SESSION['user_login'] . "<br>";
    if (!isset($_SESSION['user_login'])) {
        echo "ID d'utilisateur non défini dans la session.";
    }
} else {
    echo "Utilisateur non connecté.";
}

$conection = mysqli_connect("localhost", "root", "", "users"); 
if (!$conection) {
    die("Problème de connexion: " . mysqli_connect_error());
}

if (isset($_POST['rch'])) {
    $ville = mysqli_real_escape_string($conection, $_POST['recherche']);
    $userId = $_SESSION['user_login'];

    
    $villeQuery = "SELECT id, nome, description, canton FROM villes WHERE nome = ?";
    $villeStmt = mysqli_prepare($conection, $villeQuery);
    mysqli_stmt_bind_param($villeStmt, "s", $ville);
    mysqli_stmt_execute($villeStmt);
    $resultVille = mysqli_stmt_get_result($villeStmt);
    
    if ($rowVille = mysqli_fetch_assoc($resultVille)) {
        $villeId = $rowVille['id'];

      
        echo "<strong>Ville: </strong>" . $rowVille["nome"] . "<br>";
        echo "<strong>Description: </strong>" . $rowVille['description'] . "<br>";
        echo "<strong>Canton: </strong>" . $rowVille['canton'] . "<br>";

       
        $insertQuery = "INSERT INTO search (user_id, ville_id) VALUES (?, ?)";
        $insertStmt = mysqli_prepare($conection, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "ii", $userId, $villeId);
        mysqli_stmt_execute($insertStmt);

       
        $countQuery = "SELECT COUNT(*) FROM search WHERE user_id = ? AND ville_id = ?";
        $countStmt = mysqli_prepare($conection, $countQuery);
        mysqli_stmt_bind_param($countStmt, "ii", $userId, $villeId);
        mysqli_stmt_execute($countStmt);
        $result = mysqli_stmt_get_result($countStmt);
        $row = mysqli_fetch_array($result);
        $count = $row[0];

        echo "Vous avez recherché cette ville " . $count . " fois.";
    } else {
        echo "Ville non trouvée dans la base de données.";
    }
}
?>

