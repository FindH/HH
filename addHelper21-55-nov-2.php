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
  
  <body id="addHelper">
    <div id="container">
        
        <!-- Headern!  -->
        <?php include("header.php"); ?>
 
        
        
        <div id="content">
          <!-- Starting page - Show lead userForward --> <!-- inforutor finns här -->
                <div class="addHelperBox left">
                  <h2>Jag är en fixare!<!--fixare?--></h2>
                    <form action="addHelperToDB.php" method="POST">
                        <p>
                        Mitt namn är <input type="text" name="name" /> och jag bor i
                        <select id="selectLocation" name="location">
                        </select> 
                        </p>
                        Jag kan hjälpa till med<p id="tagPickerWrapper"><input type="text" name="tag" id="tagPicker" /></p>
                        <div id="what">(Visa exempel!)</div>
                        <!-- Jag är också bra på <input type="text" name="tag" id="tagPicker" />  <span style="font-size: 0.8em;">(+)</span>-->
                        <p><br />Dessutom vill jag tillägga att<br /></p>
                        <textarea name="myHelperDescription" cols="84" rows="8">
                        </textarea>
                        <br /><br />
                        <p>Bild
                        <input type="file" name="file" id="file" />
                        </p>
                        <br />
                        E-mail: <input type="text" name="mail" class="mail" />
                        <!-- <p>Att lägga till sig på Hittahjälpen.se kostar 20:-.<br />Du betalar genom att skicka ett sms. <br />Instruktionerna kommer till din mail!</p> -->
                        <br /><br />
                        <p style="text-decoration: line-through; color: #aaaaaa;">Det kostar 20:- att lägga till sig på hittahjälpen.se och din profil ligger uppe i två månader.</p>
                        <p>Testa att lägga in dig på hittahjälpen.se alldeles gratis under hela November 2011! Din profil ligger uppe året ut!</p>
                        <input type="submit" value="Lägg till mig och skicka betalningsinstruktionerna!" id="addMe">

                    </form>
                </div>
                <!-- Preview - här kan man sedan se hur annonsen kommer att se ut, typ :) 
                <div class="preview right ">
                    <h2>Om Hittahjälpen.se</h2>
                    <p>Vad är du bra på? Du kanske kan vakta ett husdjur? Eller klippa gräsmattor? På hittahjälpen kan du lägga in dig som fixare/hjälpare så att andra i din stad som behöver hjälp kan höra av sig till dig med småuppdrag! Hittahjälpen vänder sig till privatpersoner!</p>
                </div> End of Preview -->
            
        </div> <!-- End of #content -->

      <!-- Here is our #footer :)  -->
       <?php //include("footer.php"); ?>
       
       

    
    </div><!-- End of #container -->
    <script type="text/javascript">

        var data = [
    {
        "name": "Gräsklippning",
        "value": "20"
    },
    {
        "name": "Gräsutläggning",
        "value": "21"
    },
    {
        "name": "Grässådd",
        "value": "22"
    },
    {
        "name": "Trädklippning",
        "value": "23"
    },
    {
        "name": "Äppelplockning",
        "value": "24"
    }
];

        $.getJSON('tags.json', function (json) {
            $('#tagPicker').autoSuggest(data, { minChars: 1, matchCase: false, selectedItemProp: "name", searchObjProps: "name", startText: "?", emptyText: "Tryck enter för att spara" });
        });


        function SaveTag(query) {
            var something = query;
            return;
        }

        $('#what').click(function () {
            var pick = $('.as-values');
            alert(pick.first().val());
            // Skicka dessa värden till nästa sida eller något
        });

    function SetLocation(lat, long) {
        $.getJSON('locations.json?getcities=' + lat + '/' + long, function (data) {
            // /api.php/getcities/59.3666667/16.5
            var items = []; 

            $.each(data.list, function (key, val) {
                items.push('<option value="' + val.id + '">' + val.name + '</option>');
            });

            $(items.join()).appendTo('#selectLocation');
        });
    }

    function SetDefaultLocation() {
        //alert("Tyvärr kan vi inte hitta din plats automatiskt, vänligen välj en plats i listan för bättre sökresultat.");
        $.getJSON('locations.json', function (data) {
            // /api.php/getcities/59.3666667/16.5
            var items = [];

            $.each(data.list, function (key, val) {
                items.push('<option value="' + val.id + '">' + val.name + '</option>');
            });

            $(items.join()).appendTo('#selectLocation');
        });
    }

    if (navigator.geolocation) {

        SetDefaultLocation();
        navigator.geolocation.getCurrentPosition(function (position) {
            SetLocation(position.coords.latitude, position.coords.longitude);
		}, 
		// next function is the error callback
		function (error)
		{
			switch(error.code) 
			{
				case error.TIMEOUT:
					//alert ('Timeout');
                    SetDefaultLocation();
					break;
				case error.POSITION_UNAVAILABLE:
//					alert ('Position unavailable');
					SetDefaultLocation();
					break;
				case error.PERMISSION_DENIED:
//					alert ('Permission denied');
					SetDefaultLocation();
					break;
				case error.UNKNOWN_ERROR:
//					alert ('Unknown error');
					SetDefaultLocation();
					break;
			}
		});
    } else {
        SetDefaultLocation();
    }  
</script>

  </body>
  
</html>