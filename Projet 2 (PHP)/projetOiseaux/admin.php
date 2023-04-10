 <!DOCTYPE html>
<html>
 <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="stylelogin.css">
	<link rel="stylesheet" href="style.css">
 </head>
 <body>
 <nav>
  <ul>
    <li><button ><a href="login.html">Deconnexion</a></button></li>
  </ul>
</nav>
<center>
<h2 style="margin-top:10%">Ajouter un utilisateur</h2>
</center>

<form  action="./add_user.php" method="POST"> 

            <label>Email </label>
            <input type="email" name="email" id="email" required="required"  placeholder="Entez un email">
			<br>
            <label>mot de passe</label>
            <input type="password"  name="password" id="password"  placeholder="Entez un mot de passe" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}" title="mot de passe de 8 a 20 caractéres de chiffres et minuscules et majuscules est requis">
			<br>
			<input type="submit" value="Enregistrer" style="background-color:blue;">
			
			
</form>
   </div>
  </div>
 </body>
</html>