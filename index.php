<!DOCTYPE html>
<html>
<head>
  <title>POC vitraux experts</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="row">
    <div class="header">
      <h1>Corpus vitraeum participatif</h1>
      <h2>Enrichissez le corpus des vitraux de l'Aube</h2>
      <p>Le site "Corpus vitraeum participatif" a pour objectif de permettre à tous les connaisseurs de vitraux d'échanger sur la base de données des vitraux de Troyes. La signification de certains vitraux restent pour l'instant inconnue, d'autres vitraux peuvent manquer d'informations ou de références. Vos interventions sont donc les bienvenues.</p>
    </div>
  </div>
  <div class="row cases_list">
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
        echo '<a href="fiche.php?vitrail='.$id.'"><div class="col-md-2 resume_case">';
        echo  '<img src="'.$donnee["thumbnail"].'" class="img-responsive vitrail_thumb"/>';       
        echo '<p class="vitrail_link">'.$donnee["nom"].'</p>';
        echo '</div>';
        echo '</a>';
      }
    ?>
  </div>
</body>
</html>