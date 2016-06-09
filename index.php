<?php
  $listeVitraux = json_decode(file_get_contents("http://steatite.hypertopic.org/corpus/Vitraux%20-%20B%C3%A9nel"), true);
  foreach ($listeVitraux["rows"] as $cle => $valeur) {
    print_r($valeur["value"]);
  }
?>
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

  </div>
</body>
</html>