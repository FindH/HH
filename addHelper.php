<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8" />
    <title>Lägg till dig som fixare!</title>
	
    <?php include("head_js.php"); ?>

</head>
  
  <body id="addHelper">
    <div id="container">
        
        <!-- Headern!  -->
        <?php include("header.php"); ?>
        
        <div id="content">
	  
                <div class="addHelperBox left">
                    <form action="addHelperToDB.php" method="POST" enctype="multipart/form-data" id="formSendHelperToDB">
			<p class="liteStorre">
			Mitt namn är <input type="text" name="name" placeholder="Förnamn Efternamn" />
			och jag bor i <select id="selectLocation" name="location"></select> 
			</p>
			
		      <!-- Här kommer två stycken floatade rutor som innehåller
		      "Jag kan hjälpa till med + dessutom vill jag nämna och under den andra även bild-upload -->
		      
		      <div id="tagsAndDescription"> <!-- container för de två floatade divarna -->


			<div id="tagsContainer"><!-- Taggarna -->
			    <p class="tagsAndDescriptionHeadline">Jag kan hjälpa till med</p>
			    <p id="tagPickerWrapper">
				  <input type="text" name="tagPicker" id="tagPicker" />
			      <input type="hidden" name="tag" id="tagValue" />
			    </p>
			    <!--<div id="what">Visa exempel</div>-->
			</div> <!-- End of #tagsContainer -->

			  <!-- Skicka med taggar i formuläret som en serie -->
			  <!-- <p><b>Results:</b> <span id="results"></span></p>-->

			<div id="descriptionContainer"><!-- Egen fritext + bild upload -->
			    <!-- Jag är också bra på <input type="text" name="tag" id="tagPicker" />  <span style="font-size: 0.8em;">(+)</span>-->
			    
			    <p class="tagsAndDescriptionHeadline"><!-- gammalt: Dessutom vill jag tillägga att-->
			    Bra att veta om mig</p>
			    <textarea id="myHelperDescription" name="myHelperDescription" cols="100" rows="4"></textarea>
			    <!-- Obs! Fixa så att om mig rutan blir längre om man skriver mer än 4 rader text, istället för att scrollrutan kommer upp!!! -->
			    
			    <p id="imageArea">
			    Jag har kanske en bild på mig själv
			    <input type="file" name="file" id="file" />
			    </p>
			    
			</div> <!-- End of #descriptionContainer-->


		      </div><!-- End of #tagsAndDescription -->

		<div id="mailSpace">
		    Min epostadress är:
		    <div id="giveEmailBorderBottom">
		      <input type="text" name="mail" class="mail" placeholder="min@epost.se" />
		    </div> <!-- End of giveEmailBorderBottom -->
		</div><!-- end of mailSpace-->

                        <p><span style="text-decoration: line-through; color: #aaaaaa;">Att lägga till sig på hittahjälpen.se kostar 20:-. Din profil ligger uppe i två månader. Du betalar genom att skicka ett sms.
			Instruktionerna kommer till din mail!</span>
                        Testa att lägga in dig på hittahjälpen.se alldeles gratis under hela November 2011! Din profil ligger uppe året ut!</p>
			<input type="submit" value="Lägg till mig!" id="addMe" />
			<!-- Lägg till mig och skicka betalningsinstruktionerna! ALLT DET HÄR SKA VARA MED PÅ KNAPPEN NÄR VI TAR BETALT! -->

                    </form>
	      </div><!-- End of .addHelperBox -->
	      <div class="clear"></div>
        </div> <!-- End of #content -->

      <!-- Here is our #footer :)  -->
       <?php //include("footer.php"); ?>
       <!-- Johan, du tycker inte footern ska vara med på den här sidan eller bara commentat ut för att kunna ladda snabbare när du kollar? -->
       

    
    </div><!-- End of #container -->
	
        
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
        
  </body>
 
</html>