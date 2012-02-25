<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8" />
    <title>HittaHjälpen</title>
	
    <?php include("head_js.php"); ?>
  
</head>
  
  <body id="index">
    <div id="shareUsContainer">
    <div id="container">
	  
        <div id="content">
            
            <!-- Sökningen -->
            <h1>Hittahjälpen.se</h1>
            <div id="searchArea">
                <form action="search">
                    <input type="text" id="searchBox" name="searchBox" placeholder="Hjälp mig med.." style="width:100%" />
                      <p>i
				<select id="selectLocation" name="selectLocation"></select>
				<input type="submit" id="findHelpers" value="Hitta hjälpare" />
		      </p>

                </form>
            </div><!-- End of #searchArea --><!--   //Slut på sökningen -->
            
            
            
            
            <div id="results">
	      
	      <!--

	    <div class="my-new-list">
		  <div class="helperContainer">
		    <a href="/eachHelper.php?id=1"><h3>Trädgårdsskötsel</h3></a>
		    <p>Stockholm av <a href="#">Stoffe</a></p>
		    <ul>
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      läxhjälp
		      </li></a>
		      
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      privatundervisning
		      </li></a>
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      sytjänster
		      </li></a>
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      lagar cyklar
		      </li></a>
		      
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      hanterar hemsidor
		      </li></a>


		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      vakta husdjur
		      </li></a>
		      
		       <a href="/?search=vakta husdjur&id=13">
			<li>
		      sytjänster
		      </li></a>
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      lagar cyklar
		      </li></a>
		      
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      hanterar hemsidor
		      </li></a>


		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      vakta husdjur
		      </li></a>
		    </ul>
		    
			  <div class="commentsAndLikes">
			  <img alt="smiley" src="/images/happy.png"><img alt="smiley" src="/images/happy.png"><br />
			  <a href="/eachHelper.php/1">2 kommentarer</a>
			  </div>
		  </div>
	      
		  <div class="helperContainer">
		    <a href="/eachHelper.php?id=1"><h3>Trädgårdsskötsel</h3></a>
		    <p>Stockholm av Stoffe</p>
		    <ul>
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      läxhjälp
		      </li></a>
		      
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      privatundervisning
		      </li></a>
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      sytjänster
		      </li></a>
		      <a href="/?search=vakta husdjur&id=13">
			<li>
		      vakta husdjur
		      </li></a>
		    </ul>
		    
			  <div class="commentsAndLikes">
			  </div>
		  </div>
	      
	    </div>

-->



            </div><!-- End of results -->

            <!-- Starting page - Show lead userForward --> <!-- inforutor finns här -->
           <div id="leadUserForward">



   <h2>Vad är du bra på?</h2>

	      <a href="addHelper.php" class="button blue buttonIndex">Lägg till mig!</a>
		      <p>Du kanske älskar djur och kan vara <a href="#">husdjursvakt?</a> 
		      Är du en fena på att <a href="#">klippa gräsmattor?</a> Älskar du höstens färger och att <a href="#">kratta löv?</a>
		      Spritter det i armarna av att <a href="#">klyva ved?</a><br />		    
		    </p>
	
	
		    
		    
            </div><!-- End of #leadUserForward -->
        </div><!-- End of #content -->

       <!-- Here is our #footer :)  -->
       <?php include("footer.php"); ?>
       
    </div><!-- End of #container -->


       <!-- Here is our #shareUs   -->
       <?php include("shareUs.php"); ?>
    </div> <!-- End of shareUsContainer -->


<div id="creepers">
	<a href="http://mediacreeper.com/latest" title="MediaCreeper">
                <img src="http://mediacreeper.com/image" alt="MediaCreeper" style="width: 80px; height: 15px; border:0px;" />
                </a>
                <!-- End MediaCreeper tracker code -->
                
                <!-- Begin Creeper tracker code -->
                <a href="http://gnuheter.com/creeper/senaste" title="Creeper">
                    <img src="http://gnuheter.com/creeper/image" alt="Creeper" style="width: 80px; height: 15px; border: 0px;" />
                </a>
                <!-- End Creeper tracker code -->
	</div>

  </body>
  
</html>