<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <title>Lägg till dig som fixare!</title>
    <link rel="stylesheet" href="hittaHjalpen.css" type="text/css" />
    <link rel="Stylesheet" href="css/autoSuggest.css" type="text/css" />
    <script type="text/javascript" src="jquery-1.6.4.js"></script>
    <script type="text/javascript" src="js/jquery.autoSuggest.js"></script>
    <script type="text/javascript" src="hittaHjalpen.js"></script>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAACy1tWwyJn-OtNiBMlEqE7BTlI0W9cpp_vdzWl-z9zQaOkgglvRSWCQyHpP0g7htuMy2D8Q5yvNENrQ" type="text/javascript"></script>
  </head>
  
  <body id="addHelperToDB">

    <p>Namnet: (name)</p>
    <?php echo $_POST["name"]; ?><br />
    
    <p>Plats: (location)</p>
    <?php echo $_POST["location"]; ?><br />

    <p>Taggar: (tag)</p>
    <?php echo $_POST["tag"]; ?><br />

    <p>Egen beskrivning: (myHelperDescription)</p>
    <?php echo $_POST["myHelperDescription"]; ?><br />

    <?php
    //Ladda upp bilden
    if ($_FILES['file']['error'] > 0)
      {
      echo "Error: " . $_FILES["file"]["error"] . "<br />";
      }
    else
      {
      echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      echo "Type: " . $_FILES["file"]["type"] . "<br />";
      echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      echo "Stored in: " . $_FILES["file"]["tmp_name"];
      }



    if (file_exists("images/helpersUploadedImages/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "images/helpersUploadedImages/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "images/helpersUploadedImages/" . $_FILES["file"]["name"];
      }


      ?>


    <p>Egen beskrivning: (myHelperDescription)</p>
    <?php echo $_POST["mail"]; ?>

  </body>
  
</html>