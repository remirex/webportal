<?php
require_once('../function.php');
require_once('class_Log.php');
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
<title>Insert</title>
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
		<h2>Ubacivanje novih vesti</h2>
			<?php
			$db = connect();
			if(!$db) echo "Greška";
			//else echo "Uspešna konekcija";

			if($_SERVER['REQUEST_METHOD'] == "POST")
			{
				$naslov = mysqli_real_escape_string($db, $_POST['naslov']);
				$naslov = strip_tags($_POST['naslov']);
				$opis = mysqli_real_escape_string($db, $_POST['opis']);
				$opis = strip_tags($_POST['opis']);
				$sadrzaj = mysqli_real_escape_string($db, $_POST['sadrzaj']);
				$sadrzaj = strip_tags($_POST['sadrzaj']);
				$idkategorije = mysqli_real_escape_string($db, $_POST['idkategorije']);
				$idkategorije = strip_tags($_POST['idkategorije']);
				$slika = $_FILES['slika'];
				$slika = $_FILES['slika']['name'];
				$slika_tmp = $_FILES['slika']['tmp_name'];
				$slika_size = $_FILES['slika']['size'];
				$slika_error = $_FILES['slika']['error'];
				if(!empty($slika))
				{
					$ext = pathinfo($slika,PATHINFO_EXTENSION);
					$allowed_ext = array('jpg','jpeg','png');
					if(in_array($ext,$allowed_ext))
					{
						if($slika_error === 0)
						{
							if($slika_size < 100000)
							{
								$slika = time().".".pathinfo($slika,PATHINFO_EXTENSION);
								move_uploaded_file($slika_tmp,'../images/'.$slika);
                                //definisanje upita i obrada odgovora !!!
                                $sql = "INSERT INTO news(naslov,opis,sadrzaj,idkategorije,autor,slika)
				                        VALUES('$naslov','$opis','$sadrzaj','$idkategorije','".$_SESSION['first_name']."','$slika')";
                                        if(mysqli_query($db,$sql)or die(mysqli_error($db)))
                                        {

                                            ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign">
                                                <?php echo "Uspešno dodata vest u bazu !!!"; ?>
                                            </span></div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger">
                                            <span class=" glyphicon glyphicon-info-sign">
                                                <?php echo "Greška prilikom unosa vesti u bazu !!!"; ?>
                                            </span></div>
                                            <?php
                                        }
                            }else{
                                ?>
                                <div class="alert alert-danger">
                                    <span class=" glyphicon glyphicon-info-sign">
                                        <?php echo "Your file is to big!!!"; ?>
                                    </span>
                                </div>
                                <?php
                            }
                        }else{
                            ?>
                            <div class="alert alert-danger">
                                <span class=" glyphicon glyphicon-info-sign">
                                    <?php echo "Error with uploading file!!!"; ?>
                                </span>
                            </div>
                            <?php
                        }
                    }else{
                        ?>
                        <div class="alert alert-danger">
                            <span class=" glyphicon glyphicon-info-sign">
                                <?php echo "You cannot upload files of this type!!!"; ?>
                            </span>
                        </div>
                        <?php
                    }
                }
                else{
                    $errSlika = 'Slika obavezna !!!';
                }
                if(empty($naslov)){
                    $errNaslov = 'Molimo unesite naslov vesti';
                }
                else $naslov = test_input($naslov);
                if(empty($opis)){
                    $errOpis = 'Molimo unesite opis vesti';
                }
                else $opis = test_input($opis);
                if(empty($sadrzaj)){
                    $errSadrzaj = 'Molimo unesite sadržaj vesti';
                }
                else $sadrzaj = test_input($sadrzaj);
            }
            ?>
			<form action="#" method="post" enctype="multipart/form-data" id="insert" name="insert">
				<div class="form-group">
					<label class="control-label" for="naslov_vesti">Naslov:</label>
					<input type="text" name="naslov" id="naslov_vesti" class="form-control">
                    <span style="color: red"><?php if(isset($errNaslov)) echo $errNaslov; ?></span>
				</div>
				<div class="form-group">
					<label class="control-label" for="opis_vesti">Opis:</label>
					<input type="text" name="opis" id="opis_vesti" class="form-control">
                    <span style="color: red"><?php if(isset($errOpis)) echo $errOpis; ?></span>
				</div>
				<div class="form-group">
					<label class="control-label" for="sadrzaj_vesti">Sadržaj</label>
					<textarea name="sadrzaj" class="form-control" placeholder="Unesite sadržaj vesti" id="sadrzaj_vesti" rows="5"></textarea>
                    <span style="color: red"><?php if(isset($errSadrzaj)) echo $errSadrzaj; ?></span>
				</div>
				<div class="form-group">
					<label class="control-label">Kategorija:</label>
					<select class="form-control" name="idkategorije">
						<option value="1">info</option>
						<option value="2">hronika</option>
						<option value="3">zabava</option>
						<option value="4">sport</option>
						<option value="5">it</option>
					</select>
				</div>
				<div class="form-group">
					<input type="file" class="form-control" name="slika">
                    <span style="color: red"><?php if(isset($errSlika)) echo $errSlika; ?></span>
				</div>
				<div class="form-group">
					<input type="button" name="btn_submit" class="btn btn-primary" value="Snimi vest" onclick="snimiVest()">
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
<script type="text/javascript">
    function snimiVest()
    {
        confirm('Da li želite da snimite vest ?');
        document.insert.submit();
    }
</script>
