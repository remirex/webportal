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
	$db=connect();
	$sql="SELECT id FROM gallery";
	$res=mysqli_query($db, $sql);
	if(isset($_GET['idGallery']) and is_numeric($_GET['idGallery']) and $_GET['idGallery']<=mysqli_num_rows($res))
	{
		$idGallery=mysqli_real_escape_string($db, $_GET['idGallery']);
		$idGallery=strip_tags($_GET['idGallery']);
		$sql = "SELECT gallery_name FROM gallery INNER JOIN gallery_images ON gallery.id=gallery_images.idGallery WHERE gallery.id=$idGallery";
		$res=mysqli_query($db,$sql);
		$row=mysqli_fetch_object($res);
		echo "Gallery | ".$row->gallery_name;
	}
	else echo 'Greška';
	?>
</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
<link href="lightbox/css/lightbox.min.css" rel="stylesheet" type="text/css">    
<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<script src="jquery-3.1.1.min.js"></script>
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
	<div class="wrapper">
		<section id="container_gallery">
			<section class="gallery_img">
			<?php
			$db = connect();
			if(!$db) echo "Greška";
            //else echo "Uspešno";
			$sql="SELECT id FROM gallery";
			$res=mysqli_query($db, $sql);
            if(isset($_GET['idGallery']) and is_numeric($_GET['idGallery']) and $_GET['idGallery']<=mysqli_num_rows($res))
            {
				$idGallery=mysqli_real_escape_string($db, $_GET['idGallery']);
				$idGallery=strip_tags($_GET['idGallery']);
                $sql = "SELECT * FROM gallery_images WHERE idGallery=$idGallery";
                $res = mysqli_query($db,$sql);
                if(mysqli_num_rows($res) > 0)
                {
                    while($row = mysqli_fetch_object($res))
                    {
                    ?>
                    <div class="image">
                        <a href="gallery/<?=$row->slika?>" data-lightbox="gallery">
                            <img src="gallery/<?=$row->slika?>" width="141" height="141">
                        </a>
			         </div>
                    <?php
                    }
                }
                else echo "Nema slika za izabranu galeriju !!!";
            }
			?>
			</section>
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
			</section>
		</section>
	</div>
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
    
    <script src="lightbox/js/lightbox.min.js"></script>
    
</body>
</html>
