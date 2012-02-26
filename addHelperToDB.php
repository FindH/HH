<?php

$con = mysql_connect("mysql34.kontrollpanelen.se","web36942_stoffe","HKjH23nixEfter17");
if (!$con)
  {
  //die('Lyckas inte koppla upp mig mot databasen: ' . mysql_error());
  die('Något stämde inte, hör gärna av dig till victoriawagman@gmail.com så löser vi det så snabbt vi kan!');
  }

mysql_select_db("web36942_hittahjalpen", $con);


  //die(var_dump($_POST));
  //["tagPicker"]=> string(0) "" ["as_values_067"]=> string(22) "barnvakt,barnpassning," ["tag"]=> string(22) "barnvakt,barnpassning,"
  
  $tag = $_POST["tag"];
  $tag = preg_replace('/\x2c$/','',$tag);
  $tags = preg_split('/\x2c/',$tag);
  //Jag måste komma ihåg att lägga in kommentar om hur ovanstående regexp fungerar! 
  
  $helperdesc = mysql_real_escape_string(utf8_decode( $_POST['myHelperDescription'] ));
  $mailen = mysql_real_escape_string($_POST['mail']);
  $plats = mysql_real_escape_string($_POST['location']);
  $namnet = mysql_real_escape_string(utf8_decode( $_POST['name'] ));
  $bildensNamn = $_FILES["file"]["name"];
  //echo $bildensNamn;



if(mysql_num_rows(mysql_query("
	  SELECT
	    user_email
	    FROM
	      users
	    WHERE
	      user_email = '$mailen'
	    "))){
     $result = "Du finns redan med i databasen! :) ";
  
    /*
     Här är fältet som tar emot alla taggar som en lång string med , mellan varje tagg!
      echo $_POST["tagValue"]; 
      
    */
    //och efter att vi har lagt till profilen är det nu läge att ladda upp bilden!
} else{
    $sql="INSERT INTO users (user_name, user_email, user_img_url, user_description, hemma_ort)
    VALUES
    ('$namnet','$mailen','$bildensNamn','$helperdesc','$plats')";
    
    if (!mysql_query($sql))
      {
      die('Det inte att lägga till dig just nu. Hör gärna av dig till victoriawagman@gmail.com!' . mysql_error());
      $result = "Gick tyvärr inte att lägga till dig. Hör gärna av dig till kontakt@hittahjalpen.se!";
      }
    
    /*
     Här är fältet som tar emot alla taggar som en lång string med , mellan varje tagg!
      echo $_POST["tagValue"]; 
      
    */
    
    
    //och efter att vi har lagt till profilen är det nu läge att ladda upp bilden!
    
        //Ladda upp bilden
    if ($_FILES['file']['error'] > 0)
      {
      //echo "Error: " . $_FILES["file"]["error"] . "<br />";
      //Den här är bra att ha med vid testing, men hide:a in public annars visar den error 4 om man inte laddat upp ngn bild! :)
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
      //Självklart ska vi ändra det så att om ngn laddar upp en bild så byter vi namn på bilden till deras användarnamn+datum eller
      //användarnamn + deras fixare(user)id o.s.v. man ska inte själv behöva byta namn på filen of.c.! :)
      }
    else
	{
		move_uploaded_file($_FILES["file"]["tmp_name"],
			"images/helpersUploadedImages/" . $_FILES["file"]["name"]);
		//echo "<br />Stored in: " . "images/helpersUploadedImages/" . $_FILES["file"]["name"];
	}


	//om ngt strular med att koppla upp sig mot databasen... visa isf felmeddelande!
	/*if (!mysql_query($sql,$con))
	{
		//die('Error: ' . mysql_error());
		//Utvecklar - om vi hÃ¥ller pÃ¥ att utveckla sÃ¥ kan det vara bra att uncommenta den hÃ¤r fÃ¶r att se ev. Felmeddelanden!
	}*/
}



      if($result != ''){ //Om vi ännu inte har fått något felmeddelande, fortsätt då med att kolla taggarna!
  

          // Kolla vilka taggar som redan finns!
          //För varje tagg som inte redan finns - lägg till tagg och hämta ut vilket id den taggen fick!
          $radaUppTaggarArray = mysql_query("
                    SELECT
                      tag_value
                      FROM
                        tags
                      ");
          
          //Ladda hem en array med alla taggar som finns sen! */
            /*foreach($tags as $t) {
              echo $t;
            }*/
          
            //Om jag får träff på en tagg som inte redan finns så måste jag lägga in den taggen!
            /* och  det kan jag ju faktiskt börja med (här uppe!)
              och hämta ut id!
            */
          
            //vi har en array, och det är $tags! (längre upp i koden)
            //vi stoppar in den i $arr = $tags;
            $arr = $tags;
          
            while ($befTaggar = mysql_fetch_array($radaUppTaggarArray)){ //Kollar upp alla befintliga taggar!
                $existingTag = $befTaggar['tag_value']; //Denna tagg finns redan med i databasen!
          
                  //print_r($arr);  <-- dessa taggar skickas med från föregående sida!
          
            /*      echo "<br /><br />";
                  echo $existingTag."<br /><br />";*/
                  //arrayen med alla taggar ska vara = sig själv fast det som skiljer är att vi plockar bort de värden som redan finns med i databasen!
                  
                  $arr = array_diff($arr, array($existingTag));
                  //Kvar här i $arr finns alltså endast de taggar som användaren har skrivit in som inte redan fanns med i databasen!
                }   
              
              //print_r($arr);         //De värden som nu finns i $arr ska ju alltså läggas till i listan med taggar!
              
              
              
              foreach($arr as $at) { //För varje värde som alltså är kvar i arrayen $arr
                mysql_query("INSERT INTO tags (tag_value)
                  VALUES
                    ('$at')"); //Lägg till den nya taggen!
              }
          
          
          
              //Kolla vad denna nya användare fått för id för att kunna skapa adverts! :)
              $thisnewuserid = mysql_query("SELECT user_id FROM users WHERE user_email = '$mailen' LIMIT 1");
                while ($nyttUserId = mysql_fetch_array($thisnewuserid)){
                        $userId = $nyttUserId['user_id'];
                    }
          
          
              
              foreach($tags as $t) { //För varje tagg som följdemed ska en advert skapas för den här användaren!
                  $sql="INSERT INTO adverts (advert_text, user_id, location_id, tag_id)
                    VALUES
                    ('$t','$userId','$plats','$t')";
                    
                    if (!mysql_query($sql))
                      {
                      die('Hmm, skapa adverts strular. Hör gärna av dig till victoriawagman@gmail.com!' . mysql_error());
                      }
          
                }
              // Skapa adverts för denna user, med alla de taggar som kom med från föregående sida!
              // for each igenom en array med de taggar som skickades med!
              //Skapa advert - välj korrekt user id, och lägg även in korrekt user location på dessa adverts! (finns med  från föregående sida i $_POST )
      } //Slut på om/if vi inte fått något felmeddelande.
            
    mysql_close($con);
    echo "\n\n";
?>


<!DOCTYPE html>
<html lang="sv">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Lägg till dig som fixare!</title>
    <link rel="stylesheet" href="css/hittaHjalpen.css" type="text/css" />
    <link rel="stylesheet" href="css/autoSuggest.css" type="text/css" />
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
    	echo "<p>Nu finns du med hos hittahjälpen.se!</p>";
    }
    ?>
    
    <p>Härligt att du är en handlingskraftig person!<br />
    Vi jobbar för fullt med att få alla taggar på plats!</p>
    
    <p>Vi skickar ett mail till <b>
    <?php echo $_POST["mail"]; ?></b>
    så fort hemsidan är igång!</p>

    <p>Hör gärna av dig direkt till oss via kontakt@hittahjalpen.se om du har några frågor!</p>

    <p>Ha det gott!</p>
    
    <p>Hälsningar,<br />
    Victoria</p>
      
        
      </div><!-- End of #content -->
    </div><!-- End of #container -->


<!-- kundo.se knapp! -->
<script type="text/javascript">
    var _kundo = _kundo || {};
    _kundo["org"] = "hittahjalpense";
    _kundo["lang"] = "sv";
    _kundo["btn-type"] = "1";

    (function() {
        function async_load(){
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = ('https:' == document.location.protocol ? 'https://static-ssl' : 'http://static') +
            '.kundo.se/embed.js';
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        }
        if (window.attachEvent)
            window.attachEvent('onload', async_load);
        else
            window.addEventListener('load', async_load, false);
    })();
</script>
<!-- slut på kundo.se knapp! -->


  </body>
  
</html>