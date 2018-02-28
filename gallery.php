<?php
require_once('function.php');
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Gallery</title>
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
	</style>
</head>
<body>
	<header id="header">
		<?php
		include('temp_header.php');
		?>
	</header><!-- end header -->
	<div id="container_gallery">
		<div class="wrapper">
            <?php
            $db = connect();
            if(!$db) echo "Greška";
            //else echo "Uspešno";
            $sql = "SELECT * FROM gallery ORDER BY id DESC";
            $res = mysqli_query($db,$sql);
            while($row = mysqli_fetch_object($res))
            {
                ?>
                <div class="gallery">
				<a href="gallery_name.php?idGallery=<?=$row->id?>">
					<img src="images/<?=$row->baner?>" alt="slika">
					<div class="gallery_name">
						<p><?=$row->gallery_name?></p>
					</div>
				</a>
			     </div>        
            <?php
            }
            ?>
		</div>
	</div><!--end container-->
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
