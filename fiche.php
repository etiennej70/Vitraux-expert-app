<?php
//id du vitrail dans l'URL
$id_vitrail = htmlspecialchars($_GET["vitrail"]);

//On récupère les infos de la base concernant le vitrail
$donnees = array();
$data = json_decode(file_get_contents("http://argos2.hypertopic.org/corpus/Vitraux%20-%20B%C3%A9nel"), true);
foreach ($data["rows"] as $cle => $valeur) {
	if($valeur["id"] == $id_vitrail) {
		$donnees[key($valeur["value"])] = $valeur["value"][key($valeur["value"])];
	}
}

//API facebook
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

//Facebok object of the app vitraux experts utt
$fb = new Facebook\Facebook([
  'app_id' => $config['facebook']['app_id'],
  'app_secret' => $config['facebook']['app_secret'],
  'default_graph_version' => $config['facebook']['default_graph_version'],
]);
?>
<!DOCTYPE html>
<html>
<head>
  <title>POC vitraux experts</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.6";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

  <div class="row">
    <div class="col-md-4">
    	<!--On affiche l'image du vitrail-->
      <img src="<?php echo 'http://steatite.hypertopic.org/picture/'.$id_vitrail; ?>" class="img-responsive" />    
    </div>
    <div class="col-md-8">
    	<h3>Données :</h3>
    	<?php 
    	//On affiche les données de la base
    		if(empty($donnees)) {
    			echo "<p>Aucune donnée en base</p>";
    		}
    		else {
    			foreach ($donnees as $key => $value) {
    				if($key == "topic") {
    			     $donnesProfondes = json_decode(file_get_contents("http://argos2.hypertopic.org/topic/".$value ["viewpoint"]."/".$value['id']."/"), true);
               $nuageDeTags = array();
               foreach($donnesProfondes["rows"] as $cle => $valeur) {
                  $tag = $valeur["value"]["item"]["name"];
                  if($tag != "" && $tag != "Sans nom" && $tag != " ") {
                    $nuageDeTags[] = $tag;
                  }
               }
               echo "<p>";
               echo "Tags :";
               echo "<ul>";
               foreach ($nuageDeTags as $tag) {
                  echo "<li>".$tag."</li>";
               }
               echo "</ul>";
               echo "</p>";
    				}
    				else {
    					echo "<p>$key : $value</p>";
    				}    				
    			}
    		}  		
    	?>
    	<hr>
      <div class="fb-comments" data-href="http://vitraux-experts.dev.etiennejacquot.com/fiche.php?vitrail=<?php echo $id_vitrail ?>" data-width="100%" data-numposts="5"></div>
    </div>
  </div>

</body>
</html>