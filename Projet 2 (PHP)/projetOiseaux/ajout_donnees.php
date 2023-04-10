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

$requete="SELECT * FROM type_oiseaux";    
        $list=mysqli_query($mysqli,$requete);	
$mysqli->close();		
		?> 



<!DOCTYPE html>
<html>
 <head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="style.css">
 </head>
 <body>
 <nav>
  <ul>
    <li><a href="insertion.php">Accueil</a></li>
	<li><a href="ajout_donnees.php">Ajouter</a></li>
    <li><a href="list.php">List</a></li>
	 <li><button onclick="deconnexion()">Déconnexion</button></li>
	 <script type="text/javascript">
	 
		function deconnexion() {
			localStorage.removeItem("user"); //supprime la clé "user" du local storage
			alert("Vous avez été déconnecté."); //affiche une alerte pour informer l'utilisateur
			location = "index.php"
		}
	</script>
  </ul>
</nav>
  <br />
  <div class="container">
   <h2 align="center"></h2>
   <br />
   <div class="col-md-6" style="margin:0 auto; float:none;">
    <form method="post" action="insertwithconnexion.php">
     <h3 align="center">Formulaire</h3>
     <br />
     
  <!--   <div class="form-group">
      <label>Enter Email</label>
      <input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" required="required"/>
     </div>
	 -->
	<div class="form-group">
	 <label>nombre d'individues</label>
                      <div>
                      <input id="nb_individue" type="text" class="form-control" placeholder="saisir le nombre d'individues" name="nb_individue"  required="required" pattern="[0-9]{1,100}" title=" Veuillez saisir des chiffres entre 0 et 9" >
     </div>
	 </div>
	<div class="form-group">
	 <label for="text">nombre de couple</label>
                      <div>
                      <input id="nb_couple" type="text" class="form-control" placeholder="saisir le nombre de couples" name="nb_couple"  required="required" pattern="[0-9]{1,100}" title="Veuillez saisir des chiffres entre 0 et 9 " >
                      
     </div>
	 </div>
	 <div class="form-group">
	<div class="d-flex">
                      <label for="rd" style="margin-right: 22px;">indice de nidification</label>
                    <div class="form-check">
                     <label for="radio1 rd">C</label> 
					 <input type="radio" id="radio1" name="indice_nidif" value="C" checked >                    
                    </div>
                    <div class="form-check ">
                      <label for="radio2 rd" >P</label> 
					  <input type="radio" id="radio2" name="indice_nidif" value="P">                   
                    </div>
					<div>
                      <label for="radio2 rd" >E</label> 
					  <input type="radio" id="radio3" name="indice_nidif" value="E">                   
                    </div>
                    <span>*</span>
                  </div>  
     </div>
	<div class="form-group">
	 <label for="text">Remarque </label>
                    <div >
                      <textarea type="text" placeholder="votre remarque" class="form-control" id="remarque" name="remarque" required="required"  ></textarea>
                      
     </div>
	 </div>
	 
	 <input type="checkbox" name="check[]" value="value1"> Option 1<br>
<input type="checkbox" name="check[]" value="value2"> Option 2<br>
<input type="checkbox" name="check[]" value="value3"> Option 3<br>
	 
	 <div class="form-group">
	  <label>oiseaux</label>
                      
					  <select name="id_t" id="type" class="form-control" required="required" >
					  <?php while($row = mysqli_fetch_array($list)):?>
					  <option value="<?php echo $row[0]; ?>"><?php echo $row[1];?> </option>
						<?php endwhile;?>
					
					  </select>
	</div>
	
  <button type="button" onclick="getLocation()">Obtenir ma position actuelle</button>
  
  <label for="latitude">Latitude:</label>
  <input type="text" id="latitude" name="latitude">
  
  <label for="longitude">Longitude:</label>
  <input type="text" id="longitude" name="longitude">
  
  <label for="ville">Ville:</label>
  <input type="text" id="ville" name="ville" readonly>
  
<script>
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else {
      alert("La géolocalisation n'est pas prise en charge par ce navigateur.");
    }
  }
  
  function showPosition(position) {
    document.getElementById("latitude").value = position.coords.latitude;
    document.getElementById("longitude").value = position.coords.longitude;
    
    // Appel à l'API de géocodage de Google Maps pour obtenir le nom de la ville
var url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + position.coords.latitude + "," + position.coords.longitude + "&key=AIzaSyBbVvwMmFbSdMdkx-_rp_4qv7cMDAtFPI0";
    
    fetch(url)
      .then(response => response.json())
      .then(data => {
		  console.log(d);
        // Extraction du nom de la ville à partir de la réponse de l'API
        var ville = "";
		
        data.results[0].address_components.forEach(function(component) {
          if (component.types.includes("locality")) {
            ville = component.long_name;
          }
        });
        
        document.getElementById("ville").value = ville;
      })
      .catch(error => console.error(error));
  }
</script>


     <div class="form-group" align="center">
      <input type="submit" name="submit" class="btn btn-info" value="Submit" />
     </div>
    </form>
   </div>
  </div>
 </body>
</html>