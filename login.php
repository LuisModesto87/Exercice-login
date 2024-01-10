<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP intermediaire login</title>
    <link type="text/css" rel="stylesheet" href="Css/style.css">
</head>

<body>
    <h1>FAIRE LOGIN</h1>
    <section class="form">

        <form action="" method="post">
            <ul>
                <li><label>Nom : </label><br>
                        <input type="text" name="nom"></li>
                <li><label>Password : </label><br>
                        <input type="password" name="pass">
                <li><button type="submit" name="valider">Login</button>
            </ul>

        </form>

    </section>

    <div class="info">
        <p>Vous n'avez pas encore un login? Cliquez <a href="index.php">ici</a>
    </div>

</body>

</html>


<?php
session_start ();



$host = 'localhost'; 
$username = 'root'; 
$password = '';
$dbname = 'users'; 

$conn = mysqli_connect("localhost", "root", "", "users"); 

if(!$conn) {
    die("Problem de conection: " . mysqli_connect_error());
}

$identifiant = '';
$mot_de_passe = '';
$message = '';

if (isset($_POST['valider'])) {
    


    $identifiant = $_POST['nom'];
    $mot_de_passe = $_POST['pass'];
   



  
    $stmt = $conn->prepare("SELECT user_mdp FROM users WHERE user_login = ?");
    $stmt->bind_param("s", $identifiant);
    $stmt->execute();
    $result = $stmt->get_result();
   

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
      
        if ($mot_de_passe === $row['user_mdp']) {
            $_SESSION['user_login'] = $identifiant;
            header('Location: session.php');
            exit;
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "L'identifiant n'existe pas.";
    }
}


mysqli_close($conn);

?>