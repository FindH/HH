<?php ?>

 <html> 
   <head> 
     <title>Client Flow Example</title> 
         <script type="text/javascript" src="jquery-1.6.4.js"></script>
             <script type="text/javascript" src="/js/jquery.cookie.js"></script>
   </head> 
   <body> 
	<?php
	if (isset($_POST['textComment'])) {
		echo($_POST['textComment']);
	}
	?>
   <script type="text/javascript">
       function displayUser(user) {

           var cookie = $.cookie('facebook_comment'); // => 'the_value'
           $.cookie('facebook_comment', null);

       var userName = document.getElementById('userName');
       var greetingText = document.createTextNode(cookie + '<br /><br />Skrivet av '
         + user.first_name + ' från ' + user.location.name);
         userName.appendChild(greetingText);
     }

<?php
if (isset($_POST["textComment"])) {
	echo('hej');
	echo('$.cookie(\'facebook_comment\', \'' + $_POST['textComment'] + '\');');
		}
?>

     // c3549aebb8c8a0baabcf3be26498f4dd
     var appID = "141719059263042";
     if (window.location.hash.length == 0) {
       var path = 'https://www.facebook.com/dialog/oauth?';
   var queryParams = ['client_id=' + appID,
     'redirect_uri=http://www.xn--hittahjlpen-r8a.se/facebook.php',
     'response_type=token'];
   var query = queryParams.join('&');
   var url = path + query;
   window.open(url);
     } else {
       var accessToken = window.location.hash.substring(1);
       var path = "https://graph.facebook.com/me?";
   var queryParams = [accessToken, 'callback=displayUser'];
   var query = queryParams.join('&');
   var url = path + query;

   // use jsonp to call the graph
       var script = document.createElement('script');
       script.src = url;
       document.body.appendChild(script);
   }
   </script> 
   <p id="userName"></p> 
   </body> 
  </html>