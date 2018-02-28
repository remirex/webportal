<?php
require_once('../function.php');
session_start();
if($_SESSION['status'] != "admin" and $_SESSION['status'] != "editor")
{
	header('location:../index.php');
	exit();
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update</title>

<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
<link href="../css/main.css" rel="stylesheet" type="text/css">
<link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
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
		include('temp_admin_header.php');
		?>
		<div id="bottomHeader">
			<div class="wrapper">
				<nav class="nav">
					<?php
					include('temp_admin_meni.php');
					?>
				</nav>
			</div>
		</div><!-- end bottomHeader -->
	</header><!-- end header -->
	<div class="wrapper">
		<div class="admin_form">
		<h2>Update već postojeće vesti</h2>
			<?php
			$db = connect();
			if(isset($_POST['update_btn']))
			{
				$id = mysqli_real_escape_string($db, $_POST['idVest']);
				$id = strip_tags($_POST['idVest']);
				$naslov = mysqli_real_escape_string($db, $_POST['naslov']);
				$naslov = strip_tags($_POST['naslov']);
				$opis = mysqli_real_escape_string($db, $_POST['opis']);
				$opis = strip_tags($_POST['opis']);
				$sadrzaj = mysqli_real_escape_string($db, $_POST['sadrzaj']);
				$sadrzaj = strip_tags($_POST['sadrzaj']);
				$idkategorije = mysqli_real_escape_string($db, $_POST['idkategorije']);
				$idkategorije = strip_tags($_POST['idkategorije']);
				//deo vezan za sliku !!!
				$slika = $_FILES['slika']['name'];
				$slika_tmp = $_FILES['slika']['tmp_name'];
				$slika_size = $_FILES['slika']['size'];
				$slika_error = $_FILES['slika']['error'];
				if(isset($slika) and !empty($slika))//da je slika setovana i da nije null !!!
				{
					$ext = pathinfo($slika,PATHINFO_EXTENSION);//definišemo koje je ekstenzije slika !!!
					$allowed_ext = array('jpg','jpeg','png');//dozvoljene ekstenzije
					//provera slike !!!
					if(in_array($ext,$allowed_ext))
					{
						if($slika_error === 0)
						{
							if($slika_size < 100000) {
								$slika = time() . "." . pathinfo($slika, PATHINFO_EXTENSION);
								$sql = "UPDATE news SET slika='$slika' WHERE id=$id";
								mysqli_query($db, $sql);
								move_uploaded_file($slika_tmp, "../images/".$slika);
							}
							else{
								?>
								<div class="alert alert-danger">
									<span class=" glyphicon glyphicon-info-sign">
										<?php echo "Your file is to big!!!"; ?>
									</span>
								</div>
								<?php
							}
						}
						else
						{
							?>
							<div class="alert alert-danger">
								<span class=" glyphicon glyphicon-info-sign">
									<?php echo "Error with uploading file!!!"; ?>
								</span>
							</div>
							<?php
						}
					}
					else{
						?>
						<div class="alert alert-danger">
							<span class=" glyphicon glyphicon-info-sign">
								<?php echo "You cannot upload files of this type!!!"; ?>
							</span>
						</div>
						<?php
					}
				}
				$sql = "UPDATE news SET naslov='$naslov',opis='$opis',sadrzaj='$sadrzaj',idkategorije='$idkategorije'
 						WHERE id=$id";//promena idkategorije !!!
				if(mysqli_query($db,$sql)){
					?>
					<div class="alert alert-success">
						<span class="glyphicon glyphicon-info-sign">
							<?php echo "Uspešan update vesti !!!"; ?>
						</span>
					</div>
					<?php
				}else{
					?>
					<div class="alert alert-danger">
						<span class=" glyphicon glyphicon-info-sign">
							<?php echo "Greška prilikom update-a vesti !!!"; ?>
						</span>
					</div>
					<?php
				}

			}
			?>
			<form action="#" method="post" enctype="multipart/form-data">
					<div class="form-group">
					<label class="control-label">Izaberite vest za update:</label>
						<select name="idVesti" class="form-control">
							<?php
							$sql = "SELECT id,naslov FROM news WHERE obrisan=0 ORDER BY id DESC";
							$res = mysqli_query($db,$sql);
							while($row = mysqli_fetch_object($res))
							{
								echo "<option value='$row->id'>$row->naslov</option>";
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" value="Izaberi vest" class="btn btn-primary">
					</div><hr>
			</form>
			<?php
			$id="";
			$naslov="";
			$opis="";
			$sadrzaj="";
			$idkategorije="";//promena u idkategorije pošto smo kategorije odvojili u drugu tabelu !!!
			$slika="";
			if(isset($_POST['idVesti']))
			{
				$id=$_POST['idVesti'];
				$sql = "SELECT * FROM news WHERE id=$id";
				$res = mysqli_query($db,$sql);
				$row = mysqli_fetch_object($res);
				$id=$row->id;
				$naslov=$row->naslov;
				$opis=$row->opis;
				$sadrzaj=$row->sadrzaj;
				$idkategorije=$row->idkategorije;
				$slika=$row->slika;
			}
			?>
			<form action="#" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="id_vesti" class="control-label">id vesti:</label>
						<input type="text" name="idVest" id="id_vesti" class="form-control" value="<?=$id?>">
					</div>
					<div class="form-group">
						<label for="naslov" class="control-label">Naslov:</label>
						<input type="text" name="naslov" id="naslov" class="form-control" value="<?=$naslov?>">
					</div>
					<div class="form-group">
						<label for="opis" class="control-label">Opis:</label>
						<input type="text" name="opis" id="opis" class="form-control" value="<?=$opis?>">
					</div>
					<div class="form-group">
						<label for="sadrzaj" class="control-label">Sadržaj:</label>
						<textarea name="sadrzaj" class="form-control" rows="5" id="sadrzaj"><?=$sadrzaj?></textarea>
					</div>
					<div class="form-group">
						<label class="control-label">Kategorija:</label>
						<select class="form-control" name="idkategorije">
							<option value="<?=$idkategorije?>">--izabrana--</option>
							<option value="1">info</option>
							<option value="2">hronika</option>
							<option value="3">zabava</option>
							<option value="4">sport</option>
							<option value="5">mob&amp;it</option>
						</select>
					</div>
					<div class="form-group">
						<input type="file" name="slika" class="form-control"><br>

						<img src="../images/<?=$slika?>" alt="Nema slike" height="100px">
					</div>
					<div class="form-group">
						<input type="submit" value="Update vest" class="btn btn-primary" name="update_btn">
					</div>
			</form>
		</div>
	</div>
	<footer id="footer">
		<?php
		include'../temp_footer.php';
		?>
	</footer>
</body>
</html>
