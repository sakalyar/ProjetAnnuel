<?php
session_start();
//connexion à la base de données:
$BDD = array();
$BDD['host'] = "localhost";
$BDD['user'] = "user";
$BDD['pass'] = "User123456789.";
$BDD['db'] = "bddoiseaux";
$mysqli = mysqli_connect($BDD['host'], $BDD['user'], $BDD['pass'], $BDD['db']);
if(!$mysqli) {
    echo "Connexion non établie.";
    exit;
}

    
//par défaut, on affiche le formulaire (quand il validera le formulaire sans erreur avec l'inscription validée, on l'affichera plus)
$AfficherFormulaire=1;
//traitement du formulaire:
if(isset($_POST['password'], $_POST['email'])) {
 
    $email = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['email'])); 
    $password = mysqli_real_escape_string($mysqli, htmlspecialchars($_POST['password']));


    $requete = "SELECT password FROM user WHERE email = '$email'";    
    $resultat = mysqli_query($mysqli, $requete);
    $row = mysqli_fetch_assoc($resultat);   
    $hashed_password = $row['password'];
     
    if ( password_verify($password,$hashed_password )) {
        $requete = "SELECT count(*) FROM user WHERE email = '".$email."' AND password = '".$hashed_password."'";
        $exec_requete = mysqli_query($mysqli,$requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];
        if ($count != 0) {
            $_SESSION['email'] = $email;
			if ($_SESSION['email'] == 'admin@gmail.com') {
				header('Location: admin.php');
			} else {
				echo '<script>location = "insertion.php"</script>';	
			}
             
        } else {
            echo '<script language="Javascript">
                alert ("email ou mot de passe incorrect !" );
            </script>';
            echo '<script>location = "login.html"</script>';
        }
    } else {
         echo '<script language="Javascript">
                  alert ("email ou mot de passe incorrect !");
            </script>';
        echo '<script>location = "login.html"</script>';
    }
    // Fermeture de la connexion à la base de données
    mysqli_close($mysqli);
} else {
    header('Location: login.html');
}


    

if($AfficherFormulaire==1){
   
}

?>




