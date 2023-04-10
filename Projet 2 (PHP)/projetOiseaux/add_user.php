<?php
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

$AfficherFormulaire=1;
//traitement du formulaire:
if(isset($_POST['email'],$_POST['password']))
{			 
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		   echo '<script language="Javascript">
				alert ("utilisateur enregistrée avec succées !" )
				
					 </script>';
					 echo '<script>location = "admin.php"</script>';
				 if(!mysqli_query($mysqli,"INSERT INTO user SET email='".$_POST['email']."',password='".$hashed_password."'")){
            echo "Une erreur s'est produite: ".mysqli_error($mysqli);// afficher une erreur
	   } 	 
		  
		   
}
else
{
			echo '<script language="Javascript">
				alert ("erreur !" )
				
					 </script>';
					 echo '<script>location = "admin.php"</script>';
           // utilisateur ou mot de passe incorrect
}
    

if($AfficherFormulaire==1){
   
}

?>