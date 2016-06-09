
<!DOCTYPE html>
<html>
<head>
  <title>POC vitraux experts</title>
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
  <div class="row">
    <div class="col-md-12">
      <h2>Bienvenue, expert !</h2>
    </div>
    <?php
      $listeVitraux = json_decode(file_get_contents("http://steatite.hypertopic.org/corpus/Vitraux%20-%20B%C3%A9nel"), true);
      $listePropre = array();
      foreach ($listeVitraux["rows"] as $cle => $valeur) {
        if(count($valeur["key"]) == 2) {
          if(isset($valeur["value"]["name"])) {
            $listePropre[$valeur["key"][1]]["nom"] = $valeur["value"]["name"];
          }
          if(isset($valeur["value"]["thumbnail"])) {
            $listePropre[$valeur["key"][1]]["thumbnail"] = $valeur["value"]["thumbnail"];
          }
        }       
      }
      foreach ($listePropre as $id => $donnee) {
        echo '<div class="col-md-2">';
        echo '<p><a href="fiche.php?vitrail='.$id.'">'.$donnee["nom"].'</a></p>';
        echo  '<img src="'.$donnee["thumbnail"].'" class="img-responsive"/>';
        echo '</div>';
      }
    ?>
  </div>
</body>
</html>