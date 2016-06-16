<?php
//id du vitrail dans l'URL
$id_vitrail = htmlspecialchars($_GET["vitrail"]);

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
    <div class="col-md-4 vitrail_img">
    	<!--On affiche l'image du vitrail-->
      <img src="<?php echo 'http://steatite.hypertopic.org/picture/'.$id_vitrail; ?>" class="img-responsive" />    
    </div>
    <div class="col-md-8 vitrail_data">
    	<h3>Données :</h3>
    	<?php
      $donnees = array();
      $tags_array = array();
      //On récupère les infos de la base concernant le vitrail
      $data = json_decode(file_get_contents("http://argos2.hypertopic.org/item/Vitraux%20-%20B%C3%A9nel/".$id_vitrail), true);
      foreach ($data['rows'] as $key => $value) {
        if(count($value['value']) == 1) {
          echo '<p><b>'.ucfirst(key($value['value'])).'</b> : '.$value['value'][key($value['value'])].'</p>';
        }
        else {
          //Sinon, il s'agit de mots clés, tags, etc. Il faut alors aller chercher le nom correspondant à l'ID du tag récupéré
          if(isset($value['value']['topic'])) {
            //On appel le webservice contenant cette information
            $curl = curl_init('http://argos2.hypertopic.org/viewpoint/'.$value['value']['topic']['viewpoint']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8","Accept:application/json, text/javascript, */*; q=0.01"));
            $result = curl_exec($curl);
            //On décode le JSON retourné par le webservice
            $array_results = json_decode($result, true)['rows'];
            //Pour chaque ligne, on compare par rapport à l'ID du point de vue et de l'id du tga que l'on a, pour voir si cela correspond
            foreach ($array_results as $id_viewpoint => $item) {
              if(isset($item['key'][1]) && $item['key'][0] == $value['value']['topic']['viewpoint'] && $item['key'][1] == $value['value']['topic']['id']) {
                //Si on a la bonne info, on enregistre le tag dans un array pour pouvoir les afficher tous d'un coup par la suite
                if(isset($item['value']['name'])) {
                  $tags_array[] = $item['value']['name'];
                }
              }   
            }
          }     
        }
      }
      //On affiche enfin les tags
      echo '<h3>Tags :</h3>';
      echo '<ul>';
      foreach ($tags_array as $tag) {
        echo "<li>".$tag."</li>";
      }
      echo '</ul>';
    	?>
    	<hr>
      <div class="fb-comments" data-href="http://vitraux-experts.dev.etiennejacquot.com/fiche.php?vitrail=<?php echo $id_vitrail ?>" data-width="100%" data-numposts="5"></div>
    </div>
  </div>

</body>
</html>