<?php
session_start();

include "array.php";

if(isset($_GET['logout'])){	
	
	//Simple exit message
	$fp = fopen("log.html", 'a');
	fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>" . PHP_EOL);
	fclose($fp);
	
	session_destroy();
	header("Location: index.php"); //Redirect the user
}


if(isset($_POST['enter'])){
	if($_POST['name'] != ""){
		$_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
	}
	else{
		echo '<span class="error">Please type in a name</span>';
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat - Customer Module</title>
<link type="text/css" rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
	<style>
					body {
				font:12px arial;
				color: #222;
				text-align:center;
				padding:35px; }
			
			form, p, span {
				margin:0;
				padding:0; }
			
			input { font:12px arial; }
			
			a {
				color:#0000FF;
				text-decoration:none; }
			
				a:hover { text-decoration:underline; }
			
			#wrapper, #loginform {
				margin:0 auto;
				padding-bottom:25px;
				background:#EBF4FB;
				width:504px;
				border:1px solid #ACD8F0; }
			
			#loginform { padding-top:18px; }
			
				#loginform p { margin: 5px; }
			
			#chatbox {
				text-align:left;
				margin:0 auto;
				margin-bottom:25px;
				padding:10px;
				background:#fff;
				height:270px;
				width:25%;
				border:1px solid #ACD8F0;
				overflow:auto; }
			
			#usermsg {
				width:395px;
				border:1px solid #ACD8F0; }
			
			#submit { width: 60px; }
			
			.error { color: #ff0000; }
			
			#menu { padding:12.5px 25px 12.5px 25px; }
			
			.welcome { float:left; }
			
			.logout { float:right; }
			
			.msgln { margin:0 0 2px 0; }
			
	</style>
</head>
<body>

<?php



if(isset($_SESSION['name']) && isset($_POST['text'])){
	$text = $_POST['text'];
	
	$fp = fopen("log.html", 'a');
	fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>" . PHP_EOL);
	fclose($fp);

	$fp = fopen("registro.txt", 'a');
		fwrite($fp, "".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>" . PHP_EOL);
		fclose($fp);
}

function loginForm(){
	echo'
	<div id="loginform">
	<form action="index.php" method="post">
		<p>Please enter your name to continue:</p>
		<label for="name">Name:</label>
		<input type="text" name="name" id="name" />
		<input type="submit" name="enter" id="enter" value="Enter" />
	</form>
	</div>
	';
}

if(!isset($_SESSION['name'])){
	loginForm();
} else {
	foreach($baneados as $baneado){
		if ($baneado == $_SESSION['name']) {
			$banned = "si" ;
		} else {
			$bannedd = "no" ;
		}
	}
	if ( isset($banned) == "si"){
		echo "Baneado por bobi";
	} else {
		
?>

<!-- Aquí va el vídeo -->


<div style="display: flex;">		
	<div style="background-color: black; width: 57.5vw; height: 32.5vw; border-radius: 0.7vw;">
		<video id="video" style="height:100%; width: 100%; background-color: blue; border-radius: 0.7vw;" controls muted="muted"></video>
	</div>


	<script>
		if(Hls.isSupported()) {
			var video = document.getElementById('video');
			var hls = new Hls();
			hls.loadSource('/hls/test.m3u8');
			hls.attachMedia(video);
			hls.on(Hls.Events.MANIFEST_PARSED,function() {
				video.play();
			});
		}
	</script>
	<div style="flex-direction: column; width: 30%;">
		
			
		
		<div  id="chatbox" style="width: 25vw; height : 32.5vw ; background-color: grey; border: 1px solid; border-radius: 0.7vw;">
			<?php
				if(file_exists("log.html") && filesize("log.html") > 0){
					$handle = fopen("log.html", "r");
					$contents = fread($handle, filesize("log.html"));
					fclose($handle);
					
					echo $contents;
				}
			?>
		</div>

			

		<div>
			<form name="message" action="index.php" method="post">
				<input name="text" type="text" id="usermsg" style="width: 55%" />
				<input name="submitmsg" type="submit"  id="submitmsg" value="Send" style="allign: right;" />
			</form>
		</div>
	</div>
</div>
	<!--
	<form name="message" action="index.php" method="post">
		<input name="text" type="text" id="usermsg" size="63" />
		<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
	</form>
		-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
$(document).ready(function(){
	
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div				
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
	setInterval (loadLog, 2500);	//Reload file every 2.5 seconds
	
	//If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = 'index.php?logout=true';}		
	});
});
</script>
<?php
}}
?>
</body>
</html>
