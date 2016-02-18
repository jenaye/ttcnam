
<div class="footer-container bgvert  mobilehide">


	<div class="footer main txtcenter txtblanc">
		<div class="note left">
			<p><a href="index.php?page=apropos">A propos</a> | <a href="index.php?page=legal">Mentions légales</a> | <a href="index.php?page=cgu">CGU</a><?php if(isset($_SESSION['auth'])){ echo " | <a href='index.php?page=recherche'>Recherchez vos amis</a>";  if($_SESSION['auth']->role_id == 1) {echo " | <a href='index.php?page=admin'>Administration</a>";}} ?> </p>
		</div>

		<div class="note right mobilehide">
			<p><a href="https://twitter.com/intent/tweet?text=Vive%20le%20TTCNAM"   data-size="large"><img id="ZeImage" src="img/twitter.gif" onMouseOver="changeImage(1)" onMouseOut="changeImage(0)"> </a> <a href="http://www.facebook.com/ttcnam"><img id="Image" src="img/facebook.gif" onMouseOver="change(3)" onMouseOut="change(2)"></a>
			</p>

		</div>
	</div>
</div>

<div class="note bandeau bgvert txtcenter txtblanc mobileonly">
	<p><a href="index.php?page=apropos">A propos</a> | <a href="index.php?page=ml">Mentions légales</a> | <a href="index.php?page=cgu">CGU</a> <?php if(isset($_SESSION['auth'])){ echo " | <a href='index.php?page=recherche'>Recherchez vos amis</a>";};?>
	</p>
	<p><a href="https://twitter.com/intent/tweet?text=Vive%20le%20TTCNAM"   data-size="large"><img id="ZeImage" src="img/twitter.gif" onMouseOver="changeImage(1)" onMouseOut="changeImage(0)"> </a> <a class="twitter" href="http://www.facebook.com/ttcnam"><img id="Image" src="img/facebook.gif" onMouseOver="change(3)" onMouseOut="change(2)"></a>
	</p>

</div>
<script language="JavaScript">
	gregImgs = new Array(2) ;
	gregImgs[0] = new Image() ; gregImgs[0].src = "img/twitter.gif" ;
	gregImgs[1] = new Image() ; gregImgs[1].src = "img/twitter_hover.gif" ;

	delImgs = new Array(2) ;
	delImgs[2] = new Image() ; delImgs[2].src = "img/facebook.gif" ;
	delImgs[3] = new Image() ; delImgs[3].src = "img/facebook_hover.gif" ;

	function changeImage(j) {
		var monImage = document.getElementById("ZeImage") ;
		monImage.src = gregImgs[j].src

	}
	function change(k) {
		var mesImage = document.getElementById("Image");
		mesImage.src = delImgs[k].src
	}
</script>
</body>
</html>
