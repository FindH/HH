<?php
//Vilken helper jobbar vi med här?
/* Jag har valt ut:
  
  -------> Advert nr 7
  Helper: Sara Ahlberg (User id: 50)
  Tagg: Barnpassning (id: 17)
  location id: 1139
  
  
*/

  $advert_id = 7;
  $advert_id = $_REQUEST['advertid'];
  echo $advert_id;
  
  //Hitta tag id  där advert id = 7
  include("connectDB.php");
        

        $advert = "SELECT * FROM adverts WHERE advert_id = $advert_id LIMIT 1";
        $advert = mysql_fetch_array(mysql_query($advert));
        $advertTaggen_id = $advert['tag_id']; //Tagg id
        $user_id = $advert['user_id']; //Användar id

        $Tagg = "SELECT tag_value FROM tags WHERE tag_id = $advertTaggen_id LIMIT 1";        
        $Taggen = mysql_fetch_array(mysql_query($Tagg));
        $Taggen = $Taggen['tag_value'];

        $sql_about_user = "SELECT * FROM users WHERE user_id = $user_id LIMIT 1";        
        $dennaHelper = mysql_fetch_array(mysql_query($sql_about_user));
        $namn = $dennaHelper['user_name'];
        $bild = $dennaHelper['user_img_url'];
          if ($bild !=""){
              $bild = "helpersUploadedImages/".$bild;
          } else {
               $bild = "hittaHjalpenWallpaper.png";
          }
        $egen_beskrivning = $dennaHelper['user_description'];

//Hitta alla taggar som hör ihop med denna användare:
      
      $allaTaggar = "SELECT * FROM adverts WHERE user_id = $user_id";
      $allaTaggar = mysql_query($allaTaggar);







/* hittaHjalpenWallpaper.png */



/* värden för denna eachHelper:
  $Taggen : det är den tagg som är kopplad till denna advert
  $namn : Namnet på denna Helper
  $bild : filnamnet på bilden. om saknas: hittaHjalpenWallpaper.png
  $egen_beskrivning : Hjälparens egna beskrivning.
*/

?>
  




<!DOCTYPE html>
<html lang="sv" id="eachHelperHtml">
  <head>
    <meta charset="utf-8">
    <title><?php echo $namn; ?>, kan hjälpa dig med [tagg], [tagg], [tagg], [tagg] via Hittahjälpen.se</title>
    
    <?php //include("head_js.php"); ?>
    <link rel="stylesheet" href="/css/hittaHjalpen.css">
    <script src="/jquery-1.6.4.js"></script>
    <script src="/hittaHjalpen.js"></script>
    <script src="/js/eachHelper.js"></script>
  </head>


  <body id="eachHelper">
    <div id="container">
        <!-- <div id="header">Logga in</div>-->
                    
                    <!-- Headern!  --> <!--  <?php //include("header.php"); ?> -->
                  <ul class="tillbaka">
                    <a href="http://hittahjälpen.se" style="text-decoration: none;">
                     <li><img src="/images/tillbaka.png" alt="pil tillbaka till hittahjälpen" style="position: relative; top: 9px;" />Tillbaka<li>
                    </a>
                  </ul>
        
        <div id="content">

            <div id="helper">
            <h1><?php echo $Taggen; ?></h1>
              <div id="imageAndContactLinkContainer">
                <img src="/images/<?php echo $bild; ?>" class="helperImage" alt="personen som kan hjälpa till" />
               <ul>
               <?php while ($row = mysql_fetch_array($allaTaggar)){
                  $taggensID = $row['tag_id'];
                  $hamtaTaggarna = "SELECT tag_value FROM tags WHERE tag_id = $taggensID";
                  $hamtaTaggarna = mysql_query($hamtaTaggarna);
                   while ($varjeTagg = mysql_fetch_array($hamtaTaggarna)){
                     echo "<li>".$varjeTagg['tag_value']."</li>";
                  }
               } ?>
               </ul>
              </div> <!-- End of imageAndContactLinkContainer -->
            
            <div id="helperDetails">
               <h3><?php echo $namn; ?></h3>
               <p class="helperSelfDescription">
                  <?php echo $egen_beskrivning; ?>
               </p>

                  <p id="kontaktaHelper">
                     <img src="/images/brev.png" alt="brev" class="noBorder">
                     Kontakta <?php echo $namn; ?>
                  </p>
               
               <div id="contactForm">
                   <form action="sendingRequestFromEmployer.php" method="post">
                     <textarea name="contentRequest">Hej, jag vill ha hjälp med...</textarea>
                     <label for="nameEmployer">Jag heter: </label><input type="text" class="textInput" name="nameEmployer" /><br />
                     <label for="contactInfoEmployer">Hör av dig till: </label><input type="text" class="textInput" name="contactInfoEmployer" /><br />
                     <input type="hidden" name="hiddenAction" value="leaveMessageToHelperFromEmployer" />
                     <input type="submit" value="Skicka" id="sendMail" />
                  </form>
               </div> <!-- End of contactForm -->

               
            </div><!-- end of helperDetails -->

            
            </div><!-- End of helper -->

            
            
        </div><!-- End of #content -->
        <div id="footer">
            (c) Team HittaHjälpen (Christopher Isene, Johan Pettersson, Victoria Wagman)
            <br />
            Kontakt: info@hittahjälpen.se
        </div><!-- End of #footer -->
    
    </div><!-- End of #container -->
  </body>
  
</html>