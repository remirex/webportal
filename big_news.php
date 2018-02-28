<?php
require_once('function.php');
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>
	<?php
	$db = connect();
	$sql="SELECT id FROM news";
	$res=mysqli_query($db,$sql);
	if(isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] <= mysqli_num_rows($res)) {
		$id = mysqli_real_escape_string($db, $_GET['id']);
		$id = strip_tags($_GET['id']);
		$sql = "SELECT * FROM news WHERE id=$id LIMIT 1";
		$res = mysqli_query($db, $sql);
		$row=mysqli_fetch_object($res);
		echo "News Portal | ".$row->naslov;
	}
	else echo "Greška";
	?>
</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="js/main.js" type="text/javascript"></script>
	<style>
		.info a:link,
		.info a:visited{
			text-decoration: none;
			color: orange;
		}
		#show_all_news{
			display: inline-block;
			float: right;
			padding: 10px;
			background-color: #094186;
			color: #fff;
			border: none;
			margin-right: 10px;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<header id="header">
		<?php
		include('temp_header.php');
		?>
	</header><!-- end header -->
	<div class="wrapper" id="showBigNews">
		<section id="container_news">
			<section class="news">
				<section id="big_news">
				<?php
				if(!$db) echo "Greška";
				//else echo "Uspešno";
				$sql="SELECT id FROM news";
				$res=mysqli_query($db, $sql);
				//echo mysqli_num_rows($res);
				if(isset($_GET['id']) and is_numeric($_GET['id']) and $_GET['id'] <= mysqli_num_rows($res)){
					$id = mysqli_real_escape_string($db, $_GET['id']);
					$id = strip_tags($_GET['id']);
					$sql = "SELECT * FROM news WHERE id=$id LIMIT 1";
					$res = mysqli_query($db,$sql);
					while($row = mysqli_fetch_object($res)){
						?>
						<h2><b><?=$row->naslov?></b></h2>
						<p><b>Autor: <?=$row->autor?></b></p>
						<p><?=$row->opis?></p><hr>
						<img src="images/<?=$row->slika?>" alt="sport" width="710px" height="300px">
						<p><?=$row->sadrzaj?></p><hr>
					<?php
					}
				}
				else{
					echo 'Greška';
				}
				?>
					<a href="show_all_news.php" id="show_all_news">Sve vesti</a>
				</section>
			</section>
			<section class="side_news">
				<h2>Najnovije vesti</h2>
				<?php
				$sql = "SELECT id,opis,datum,autor FROM news WHERE obrisan=0 ORDER BY id DESC LIMIT 10";
				$res = mysqli_query($db,$sql);
				while($row = mysqli_fetch_object($res))
				{
					?>
					<article class="block">
					<p><b><a href="big_news.php?id=<?=$row->id?>"><?=$row->opis?></a></b></p>
					<p><?=$row->datum?> | <?=$row->autor?></p>
				</article>
				<?php	
				}
				?>
				<h2 style="margin-top: 20px">Najnovije galerije</h2>
				<?php
				$sql = "SELECT * FROM gallery ORDER  BY id DESC LIMIT 1";
				$res = mysqli_query($db,$sql);
				while($row = mysqli_fetch_object($res))
				{
					?>
					<div class="newest_gallery">
						<a href="gallery_name.php?idGallery=<?=$row->id?>"><img src="images/<?=$row->baner?>" alt="nema slike" width="240px" height="240px"></a>
						<div id="title_gallery"><?=$row->gallery_name?></div>
					</div>
					<?php
				}
				?>
			</section>
		</section>
	</div>
	<div class="wrapper">
		<section id="comment">
			<?php
			$idVesti=$id;
			$sql = "SELECT * FROM komentari WHERE idVesti=$idVesti";
			$res = mysqli_query($db,$sql);
			?>
			<button id="all_comment">Svi komentari&nbsp;&nbsp;&nbsp;(<?php echo mysqli_num_rows($res);?>)</button>
			<button id="add_comment">Dodaj komentar&nbsp;&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>
			<!-- forma za popunu komentara !!! -->
			<div class="komentari">
				<p id="info_msg"></p>
					<div class="form-group">
						<label class="control-label" for="autor">Autor:</label>
						<input type="text" name="autor" id="autor" placeholder="Autor" class="form-control">
						<span id="autorSpan"></span>
					</div>
					<div class="form-group">
						<textarea name="tekst" id="tekst" class="form-control" placeholder="Unesite vaš komentar" rows="7"></textarea>
						<span id="komSpan"></span>
					</div>
					<div class="form-group">
						<input type="button" id="add_comm" value="Snimi komentar" idVesti="<?=$id?>">
					</div>
			</div>
			<?php
			$idVesti=$id;//komentar za tačno određenu vest !!!
			$sql = "SELECT * FROM komentari WHERE idVesti=$idVesti ORDER BY id DESC ";
			$res = mysqli_query($db,$sql);
			if(mysqli_num_rows($res)==0)
				echo "Nema komentara za ovu vest,budite prvi !!";
			else
			{
				while($row = mysqli_fetch_object($res))
				{
					?>
					<div class="user_comment">
						<p><i class="fa fa-user" aria-hidden="true" style="font-size: 24px;color:#094186"></i>&nbsp;&nbsp;<i><b>Autor: <?=$row->autor?></b></i></p>
						<p><?=$row->tekst?></p>
						<span style="color: lightgray"> | rejting:</span>
						<span style="position: absolute;right: 10px;color: lightgray">
							Ocena:&nbsp;&nbsp;
							<spam onclick="doRating('<?=$row->id?>','likes')"><i class="fa fa-thumbs-up" aria-hidden="true" style="color: green;cursor: pointer"></i>&nbsp;&nbsp;<span id="<?=$row->id?>_likes" style="color: green"><?=$row->likes?></span></spam> |
							<span onclick="doRating('<?=$row->id?>','unlikes')"><i class="fa fa-thumbs-down" aria-hidden="true" style="color: red;cursor: pointer"></i>&nbsp;&nbsp;<span id="<?=$row->id?>_unlikes" style="color: red"><?=$row->unlikes?></span></span>
						</span>
					</div>
				<?php
				}
			}
			?>
		</section>
	</div><!-- end section comment-->
	<div class="wrapper"><!-- slider -->
		<?php
		include'temp_slider.php';
		?>
	</div><!-- end slider -->
	<footer id="footer">
		<?php
		include('temp_footer.php');
		?>
	</footer><!-- end footer -->
</body>
</html>


