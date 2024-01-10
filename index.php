<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP intermediaire</title>
    <link type="text/css" rel="stylesheet" href="Css/style.css">
</head>

<body>
    <h1>CREER LOGIN</h1>
    <section class="form">

        <form action="" method="post">
            <ul>
                <li><label>Nom : </label><br>
                        <input type="text" name="nom"></li>
                <li><label>Password : </label><br>
                        <input type="password" name="pass">
                <li><button type="submit" name="valider">Creer login</button>
            </ul>

        </form>

    </section>

    <div class="info">
        <p>Vous avez dejà un login? Cliquez <a href="login.php">ici</a>
    </div>

</body>

</html>

<?php

$conection = mysqli_connect("localhost", "root", "", "users"); 

    if(!$conection) {
        die("Problem de conection: " . mysqli_connect_error());
    }
    if(isset($_POST['valider'])) {
        $nom = mysqli_real_escape_string($conection, $_POST['nom']);
        $pass = mysqli_real_escape_string($conection, $_POST['pass']);
    
        $sql = "INSERT INTO users (user_login, user_mdp) VALUES (?, ?)";
        $stmt = mysqli_prepare($conection, $sql);
    
        mysqli_stmt_bind_param($stmt, "ss", $nom, $pass);
    
        if(mysqli_stmt_execute($stmt)) {
            echo "Merci " . htmlspecialchars($nom) . " votre login a été créée avec succès!!";
        } else {
            echo "Problem" . mysqli_error($conection);
        }
    }
mysqli_close($conection);

?>