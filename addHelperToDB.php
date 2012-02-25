
<?php


  $bildensNamn = $_FILES["file"]["name"];
  //echo $bildensNamn;

$con = mysql_connect("mysql34.kontrollpanelen.se","web36942_stoffe","HKjH23nixEfter17");
if (!$con)
  {
  die('Lyckas inte koppla upp mig mot databasen: ' . mysql_error());
  }

mysql_select_db("web36942_hittahjalpen", $con);

if(mysql_num_rows(mysql_query("SELECT user_email FROM users WHERE user_email = '$_POST[mail]'"))){
     $result = "Du finns redan med i databasen! :) ";
     
     
} else{
    $sql="INSERT INTO users (user_name, user_email, user_img_url, user_description, location_id)
    VALUES
    ('$_POST[name]','$_POST[mail]','$bildensNamn','$_POST[myHelperDescription]','$_POST[location]')";
    
    
    /*
     H‰r ‰r f‰ltet som tar emot alla taggar som en lÂng string med , mellan varje tagg!
      echo $_POST["tagValue"]; 
      
    */
    
    
    //och efter att vi har lagt till profilen ‰r det nu l‰ge att ladda upp bilden!
    
        //Ladda upp bilden
    if ($_FILES['file']['error'] > 0)
      {
      //echo "Error: " . $_FILES["file"]["error"] . "<br />";
      //Den h‰r ‰r bra att ha med vid testing, men hide:a in public annars visar den error 4 om man inte laddat upp ngn bild! :)
      }
    else
      {
      //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
      //echo "Type: " . $_FILES["file"]["type"] . "<br />";
      //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
      //echo "Stored in: " . $_FILES["file"]["tmp_name"];
      }


    if (file_exists("images/helpersUploadedImages/" . $_FILES["file"]["name"]))
      {
      //echo "Det finns redan en bild med det filnamnet. " . $_FILES["file"]["name"];
      //Sj‰lvklart ska vi ‰ndra det sÂ att om ngn laddar upp en bild sÂ byter vi namn pÂ bilden till deras anv‰ndarnamn+datum eller
      //anv‰ndarnamn + deras fixare(user)id o.s.v. man ska inte sj‰lv behˆva byta namn pÂ filen of.c.! :)
      }
    else
	{
		move_uploaded_file($_FILES["file"]["tmp_name"],
			"images/helpersUploadedImages/" . $_FILES["file"]["name"]);
		//echo "<br />Stored in: " . "images/helpersUploadedImages/" . $_FILES["file"]["name"];
	}

	//om ngt strular med att koppla upp sig mot databasen... visa isf felmeddelande!
	if (!mysql_query($sql,$con))
	{
		//die('Error: ' . mysql_error());
		//Utvecklar - om vi h√•ller p√• att utveckla s√• kan det vara bra att uncommenta den h√§r f√∂r att se ev. Felmeddelanden!
	}
}

mysql_close($con)


?>


<!DOCTYPE html>
<html lang="sv">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>L√§gg till dig som fixare!</title>
    <link rel="stylesheet" href="css/hittaHjalpen.css" type="text/css" />
    <link rel="Stylesheet" href="css/autoSuggest.css" type="text/css" />
  </head>
  
  <body id="addHelperToDB">

    <div id="container">
        <div id="content">

         <!-- Headern!  -->
        <?php include("header.php"); ?>


    <p>Hej <?php echo $_POST["name"]; ?>!</p>
    <p><?php echo $result; ?>
    </p>
    
    
    <?php
    if(!$result){
    	echo "<p>Nu finns du med hos hittahj√§lpen.se!</p>";
    }
    ?>
    
    <p>H√§rligt att du √§r en handlingskraftig person!<br />
    Vi jobbar f√∂r fullt med att f√• klart s√∂kningen!</p>
    <p>Vi skickar ett mail till <b>
    <?php echo $_POST["mail"]; ?></b>
    s√• fort hemsidan √§r ig√•ng!</p>

    <p>H√∂r g√§rna av dig direkt till mig p√• victoriawagman@gmail.com om du har n√•gra fr√•gor!</p>

    <p>Ha det gott!</p>
    
    <p>H√§lsningar,<br />
    Victoria</p>
      
        
      </div><!-- End of #content -->
    </div><!-- End of #container -->

  </body>
  
</html>