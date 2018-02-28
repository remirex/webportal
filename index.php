<?php
session_start();
require_once('function.php');
if(isset($_GET['logout'])){
	unset($_SESSION['first_name']);
	unset($_SESSION['status']);
	session_destroy();
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>
		<?php
		if(isset($_GET['naziv']))
		{
			$db=connect();
			$naziv = mysqli_real_escape_string($db, $_GET['naziv']);
			$naziv = strip_tags($_GET['naziv']);
			$sql = "SELECT kategorije.naziv FROM kategorije WHERE naziv='$naziv' LIMIT 1";
			$res = mysqli_query($db,$sql);
			$row=mysqli_fetch_object($res);
			echo "News Portal | ".$row->naziv;
		}
		else{
			echo "News Portal";
		}
		?>
	</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<script src="jquery-3.1.1.min.js" type="text/javascript"></script>
	<script src="js/main.js" type="text/javascript"></script>
	<style>
		.info a:link,
		.info a:visited{
			text-decoration: none;
			color: orange;
		}
	</style>
</head>
<body>
<header id="header">
	<?php
	include('temp_header.php');
	?>
</header><!-- end header -->
<!-- sekcija vesti-->
<div class="wrapper" id="showNews">
	<section id="container_news">
		<section class="news">
			<div class="big">
				 <?php
				 // naslovnu stranu ćemo ispisati php metodom !!!

				 $sql = "SELECT news.*,kategorije.naziv as kategorija FROM news
						 INNER JOIN kategorije ON news.idkategorije=kategorije.id WHERE obrisan=0
						 ORDER BY news.id DESC LIMIT 2";
				 if(isset($_GET['naziv']))
					   $sql = "SELECT news.*,kategorije.naziv as kategorija FROM news
                               INNER JOIN kategorije ON news.idkategorije=kategorije.id
                               WHERE naziv='".$_GET['naziv']."' ORDER BY news.id DESC LIMIT 2";
					   $res = mysqli_query($db,$sql);
					   while($row = mysqli_fetch_object($res))
					   {
						   ?>
						   <article class="b_news">
							   <a href="big_news.php?id=<?=$row->id?>">
								   <img src="images/<?=$row->slika?>" alt="nema slike">
								   <span><?=$row->naslov?></span>
								   <div class="kategorija">
									   <?=$row->kategorija?>
								   </div>
							   </a>
							   <!-- ograničavanje sadržaja vesti na 100 karaktera !!! -->
							   <p style="margin-top: 5px"><?php echo substr($row->sadrzaj,0,97)."..."; ?></p>
							   <p><b><?=$row->datum?></b></p>
						   </article>
						   <?php
					   }
				 ?>
			</div><!-- end 2 limit news !!! -->
				<?php
				 $sql = "SELECT news.*,kategorije.naziv as kategorija FROM news INNER JOIN kategorije ON news.idkategorije=kategorije.id WHERE obrisan=0 ORDER BY news.id DESC LIMIT 2,6";
				if(isset($_GET['naziv']))
					$sql = "SELECT news.*,kategorije.naziv as kategorija FROM news INNER JOIN kategorije ON news.idkategorije=kategorije.id WHERE naziv='".$_GET['naziv']."' ORDER BY news.id DESC LIMIT 2,6";
				 $res = mysqli_query($db,$sql);
				while($row = mysqli_fetch_object($res))
				{
					?>
					<article class="s_news">
					<a href="big_news.php?id=<?=$row->id?>">
						<img src="images/<?=$row->slika?>" alt="nema slike" width="230px" height="150px">
						<span><?=$row->opis?></span>
					</a>
					</article>
					<?php
				}
				?>
			</section><!-- end of news-->		
			<section class="side_news">
				<h2>Najnovije vesti</h2>
				<?php
				$sql = "SELECT * FROM news WHERE obrisan=0 ORDER BY id DESC LIMIT 10";
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
			</section><!-- end of side news -->
	</section> <!-- kraj sekcije vesti -->
</div> <!-- kraj wrapper-a shownews -->
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
