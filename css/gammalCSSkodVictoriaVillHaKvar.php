
/* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
u, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}

/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}

/* -- End of CSS-reset -- */


/* LINKS */

a{
color: #667AA4;
}

/* End of LINKS */



body{
	background: #D2EDFF;
	background: #ffffff;
}





/* Main divar */

#container{
    width: 900px;
    border: 0px solid black;
    min-height: 400px;
    margin: 0 auto;
    background: #ffffff;
}



#content{ /* Huvudinnehållet  */
    width: 680px;
    margin: 0 auto;
    border: 0px solid red;
}

#content:after{
	/* clear: both;
	content: ".";
	visibility: hidden; */
	
}



#footer{
    margin-top: 50px;
    padding: 30px 10px 10px 10px;
    border-top: 1px solid #cccccc;
}


/* End of main divar  */







/* index.php */

#index h1{
    margin: 0 auto;
    margin-top: 70px;
    margin-bottom: 10px;
    font-size: 2.7em;
    text-align: center;
    border: 0px solid red;
    font-weight: bold;
}


#index h2{
	font-size: 1.4em;
	font-weight: bold;
	font-family: sans-serif;
	margin-bottom: 6px;
}


#searchArea{
	width: 420px;
	margin: 0 auto;
	border: 0px solid red;
	text-align: right;
}

#searchArea form{
	margin: 13px 0px 50px 0;
	border: 0px solid #FFAD9B;
}

#searchArea input[type=text]{
	width: 410px;
	font-size: 1.2em;
	margin-bottom: 10px;
	display: block;
	float: right;
}

#searchArea select{
	font-size: 1.04em;
	border: 1px solid #cccccc;
	margin: 0px;
	
}


/* Sökresultaten */
#results{
	border: 0px solid #837562;
	
}

.helperContainer{ /* Varje enskilt sökresultat kallar jag för "helper" :)  */
	height: 74px;
	position: relative;
	border: 1px solid #bbbbbb;
	margin-bottom: 4px;
	padding: 13px;
}

#results h3{
	font-size: 1.5em;
}

#results ul li{
	float: left;
	list-style-type: none;
	margin-right: 5px;
	padding: 3px;
	border: 1px solid #cccccc;
}

.commentsAndLikes{
	position: absolute;
	right: 0px;
	top: 0px;
	width: 200px;
	border: 0px solid green;
}

.commentsAndLikes img{
	margin-right: 5px;
	position: relative;
	top: 10px;
}


/* Inforutorna under resultaten, efter sökrutan på första sidan! */

#leadUserForward{
	margin-top: 50px;
}

.firstPageInfoBox{
	height: 284px;
	border: 2px solid #dddddd;
	float: left;
	border-radius: 5px;
	-moz-border-radius: 5px;
	padding: 13px;
}

.infoFirst{
	width: 374px;
	padding-right: 6px;
}

.infoFirst p{
	margin: 6px 0;
	color: #666666;
	font-size: 0.84em;
}

.infoFirst textarea{
	width: 300px;
	border: 1px dotted #cccccc;
}

.infoSecond{
	width: 200px;
}

.right{
	float: right;
}

.left{
	float: left;
}

.firstPageInfoBox select{
	margin: 7px 0;
}

/* - -- - - -- -  -- End of first page (index) css ------------- */
	
	
	
	/* Each Helper single page */
#eachHelper h1{
	margin-bottom: 5px;
	font-size: 1.84em;
}	


#helper{
	overflow: hidden;
	border: 1px dotted #bbbbbb;
	padding: 13px;
	margin-bottom: 20px;
	position: relative;
}


#helper h3{
	border: 0px solid red;
	margin-top: 10px;
	margin-bottom: 2px;
	font-weight: bold;
	font-size: 1.3em;
}

#imageAndContactLinkContainer{
	border: 0px solid red;
	max-width: 120px;
	float: left;
	display: inline;
	margin-right: 10px;
	text-align: center;
	margin-top: 2px;
}

#imageAndContactLinkContainer a img{
	border: 0px;
	text-decoration: none;
	outline: none;
}

#imageAndContactLinkContainer img.helperImage{
	max-width: 120px;
	max-height: 150px;
	padding: 6px;
	border: 1px dotted #cccccc;
	margin-bottom:8px;
	min-width: 93px;
	min-height: 118px;
}




.contactHelper{
	
}

#helper ul{
	display: block;
	overflow: hidden;
	margin-top: 4px;
	margin-bottom: 3px;
	position: relative;
	left: -2px;
	float: left;
	width: 340px;
}

#helper ul li, .helperContainer ul li{
	float: left;
	list-style-type: none;
	margin-right: 5px;
	padding: 3px 5px;
	border: 1px solid #cccccc;
	border-radius: 3px;
	-moz-border-radius: 3px;
	font-size: 0.9em;
	margin-bottom: 4px;
}


.helperSelfDescription{
	display: block;
	float: left;
	width: 334px;
	border: 0px solid red;
	margin-top: 3px;
	margin-bottom: 10px;
}


.averageScore{
	position: absolute;
	top: 84px;
	right: 8px;
	width: 120px;
	height: 184px;
	border-left: 0px solid #D2EDFF;
	padding: 10px 0 0 10px;
	
}


#contactForm{
	display: block;
	width: 440px;
	border: 3px solid #7A91C3;
	clear: both;
	margin-left: 13px;
	padding: 18px;
	padding-bottom: 20px;
	text-align: right;
}

#contactForm h3{
	margin: 0px;
	float: left;
	clear: both;
}

#contactForm input.textInput{
	width: 300px;
	margin-bottom: 2px;
}

#contactForm textarea{
	width: 438px;
	height: 124px;
	display: block;
	float: right;
	clear: both;
	margin-bottom: 2px;
}

#contactForm #sendMail{
	border: 5px solid #667AA4;
	padding: 5px 8px 5px 35px;
	font-size: 1.4em;
	background: url("images/brevLiten.png") #ffffff;
	background-repeat: no-repeat;
	background-position: left center;
	margin-top: 4px;
	border-radius: 5px;
	-moz-border-radius: 5px;
}



#leaveComment{
	border-top: 1px solid #cccccc;
	border-bottom: 1px solid #cccccc;
	height: 180px;
	padding-top: 25px;
	position: relative;
}

#leaveComment .pilar{
	margin-top: 6px;
	position: absolute;
	top: 38px;
	left: 13px;
}

#leaveComment .smilies{
	position: absolute;
	top: 34px;
	left: 149px;
	width: 35px;
	border: 0px solid red;
	margin-right: 10px;
	margin-left: 3px;
}

#leaveComment .angry{
	margin-top: 62px;
	margin-left: -4px;
}


.markedSmiley{
	-moz-box-shadow: 0px 0px 3px #4E84C0;
	-webkit-box-shadow: 0px 0px 3x #4E84C0;
	box-shadow: 0px 0px 3px #4E84C0;

	border-radius: 15px;
	-moz-border-radius: 15px;
}

.sendComments{
	border-left: 1px solid #eeeeee;
	padding-left: 15px;
	position: absolute;
	left: 200px;
	height: 170px;
	width: 460px;
	border: 0px solid red;
}

#leaveComment h3{
	margin-left: 4px;
	margin-bottom: 2px;
}

#leaveComment textarea{
	border: 2px solid #cccccc;
	padding: 10px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	width: 284px;
	height: 120px;
	float: left;
	margin-right: 10px;
	margin-bottom: 10px;
}

.addCommentLastInfo{
	position: absolute;
	top: 13px;
	right: 13px;
	width: 120px;
	border: 0px solid blue;
	margin-top: 18px;
	color: #666666;
	font-size: 0.96em;
}

.addCommentLastInfo p{
	margin-top: 20px;
	float: left;
	width: 130px;
	

	font-family: sans-serif;
	font-weight: 500;
}


#leaveComment #sendComment{
	position: absolute;
	bottom: 4px;
	right: 5px;
	font-size: 0.7em;
}







/* Footer stuff */




/* Fixar så att våra Google-Cards är floatade */


#footer h5{
	margin-top: 20px;
	font-weight: bold;
	font-family: sans-serif;
}

.googleIdentity{
	width: 340px;
	height: 135px;
}



/* Sommarjobb - kampanj!!! */
#sommarjobb #content{
	width: 550px;
	padding-left: 30px;
	padding-right: 138px;
	border-left: 2px solid #EEEEEE;
	position: relative;
}

#sommarjobb h1{
	font-size: 1.7em;
}

#sommarjobb h2{
	font-size: 2em;
	font-family: WorstveldSling;
	color: #888888;
}

#sommarjobb h3{
	font-size: 2.6em;
	font-family: WorstveldSling;
	color: #009900;
}

#sommarjobb a{
	color: #009900;
}

#sommarjobb p{
	font-size: 1.6em;
	font-family: WorstveldSling;
	color: #888888;
	margin-bottom: 10px;
}





