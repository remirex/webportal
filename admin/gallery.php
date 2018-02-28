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
<title>Gallery</title>
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
		<h2>Galerija slika</h2><p><b>- snimanje novih galerija i dodavanje slika u iste</b></p>
		<div class="insert_gallery">
            <?php
            $db = connect();
            if(!$db) echo "Greška!!!";
            //else echo "Uspešno";
            if(isset($_POST['btn_insert_gallery']))
            {
                $gallery_name = mysqli_real_escape_string($db, $_POST['gallery_name']);
                $gallery_name = strip_tags($_POST['gallery_name']);
				$baner = $_FILES['baner']['name'];
				$baner_tmp = $_FILES['baner']['tmp_name'];
				$baner_size = $_FILES['baner']['size'];
				$baner_error = $_FILES['baner']['error'];
                if(empty($gallery_name)){
                    $errNazivGalerije = 'Unesite naziv galerije';
                }
                if(!empty($baner))
				{
					$ext = pathinfo($baner,PATHINFO_EXTENSION);
					$allowed_ext = array('jpg','jpeg','png');
					if(in_array($ext,$allowed_ext))
					{
						if($baner_error === 0)
						{
							if($baner_size < 100000)
							{
								$baner = time().".".$ext;
								move_uploaded_file($baner_tmp,'../images/'.$baner);
                                $sql = "INSERT INTO gallery(gallery_name,baner,autor)
                                        VALUES('$gallery_name','$baner','".$_SESSION['first_name']."')";
                                if(mysqli_query($db,$sql)){
                                    ?>
                                    <div class="alert alert-success">
                                    <span class="glyphicon glyphicon-info-sign">
                                    <?php echo "Uspešno dodata galerija u bazu"; ?>
                                     </span>
                                    </div>
                                    <?php
                                }else{
                                    ?>
                                    <div class="alert alert-danger">
                                    <span class="glyphicon glyphicon-info-sign">
                                        <?php echo "Neuspešno dodavanje galerije u bazu"; ?>
                                    </span>
                                    </div>
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
                    $errBaner = 'Unesite baner sliku !!!';
                }
            }
            ?>
			<form action="#" method="post" enctype="multipart/form-data" id="insertGallery" name="insertGallery">
				<input type="text" name="gallery_name" placeholder="Unesite naziv galerije"><br>
                <span style="color: red"><?php if(isset($errNazivGalerije)) echo $errNazivGalerije; ?></span>
                <br>
                <input type="file" name="baner"><br>
                <span style="color: red;"><?php if(isset($errBaner)) echo $errBaner; ?></span>
                <br>
				<input type="submit" name="btn_insert_gallery" value="Snimi galeriju" class="btn btn-primary">
			</form>
		</div><hr>
		<div id="insert_images_form" class="clearfix" style="margin-bottom: 30px;">
		<h2>Izaberi galeriju za unos fotografija</h2>
			<form action="#" method="post" enctype="multipart/form-data" id="insertPicture" name="insertPicture">
				<div class="izbor_gallery">
                    <select name="idGallery">
                    <?php
                    $sql = "SELECT id,gallery_name FROM gallery  ORDER BY id DESC";
                    $res = mysqli_query($db,$sql);
                    while($row = mysqli_fetch_object($res))
                    {
                        echo "<option value=$row->id>$row->gallery_name</option>";
                    }
                    ?>
					</select>
				</div><hr>
				<div class="insert_images">
                    <?php
                    if(isset($_POST['btn_insert_image'])){
                        $idGallery = $_POST['idGallery'];
                        //čitanje komentara !!!!
                        $komentar1 = mysqli_real_escape_string($db, $_POST['komentar1']);
                        $komentar1 = strip_tags($_POST['komentar1']);
                         //slika1
                        $slika1 = $_FILES['slika1']['name'];
                        $slika1_tmp = $_FILES['slika1']['tmp_name'];
                        $slika1_size = $_FILES['slika1']['size'];
                        $slika1_error = $_FILES['slika1']['error'];
                        $komentar1 = test_input($komentar1);
                        if($slika1 !="")
                        {

                        $ext = pathinfo($slika1,PATHINFO_EXTENSION);
                        $allowed_ext = array('jpeg','jpg','png');
                        if(in_array($ext,$allowed_ext))
                        {
                            if($slika1_error === 0)
                            {
                                if($slika1_size < 1000000)
                                {
                                    $slika1 = time()."_1.".pathinfo($slika1,PATHINFO_EXTENSION);
                                    if(move_uploaded_file($slika1_tmp,"../gallery/".$slika1))
                                    {
                                        $sql = "INSERT INTO gallery_images(idGallery,slika,komentar) VALUES($idGallery,'$slika1','$komentar1')";
                                        if(mysqli_query($db,$sql)){
                                            ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign">
                                                <?php echo "Uspešno dodata slika u galeriju !!!"; ?>
                                            </span>
                                            </div>
										  <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger">
                                            <span class=" glyphicon glyphicon-info-sign">
                                                <?php echo "Greška prilikom unosa slike u galeriju !!!"; ?>
                                            </span>
                                            </div>
										<?php
                                        }

                                    }
                                    else echo "Neuspešno prebacivanje!!!";
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
                            else{
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
                        else{
                            $errSlika1 = '* Obavezna slika';
                        }
                    }
                    ?>
					<label for="image1">Slika1:</label>
					<input type="file" name="slika1" id="image1"><br>
                    <span style="color: red;"><?php if(isset($errSlika1)) echo $errSlika1; ?></span>
					<textarea name="komentar1" placeholder="Unesite komentar slike" rows="3"></textarea>
				</div>
				<div class="insert_images">
                     <?php
                    if(isset($_POST['btn_insert_image'])){
                        $idGallery = $_POST['idGallery'];
                        //čitanje komentara !!!!
                        $komentar2 = mysqli_real_escape_string($db, $_POST['komentar2']);
                        $komentar2 = strip_tags($_POST['komentar2']);
                         //slika2
                        $slika2 = $_FILES['slika2']['name'];
                        $slika2_tmp = $_FILES['slika2']['tmp_name'];
                        $slika2_size = $_FILES['slika2']['size'];
                        $slika2_error = $_FILES['slika2']['error'];
                        $komentar2 = test_input($komentar2);
                        if($slika2 !="")
                        {

                        $ext = pathinfo($slika2,PATHINFO_EXTENSION);
                        $allowed_ext = array('jpeg','jpg','png');
                        if(in_array($ext,$allowed_ext))
                        {
                            if($slika2_error === 0)
                            {
                                if($slika2_size < 1000000)
                                {
                                    $slika2 = time()."_2.".pathinfo($slika2,PATHINFO_EXTENSION);
                                    if(move_uploaded_file($slika2_tmp,"../gallery/".$slika2))
                                    {
                                        $sql = "INSERT INTO gallery_images(idGallery,slika,komentar) VALUES($idGallery,'$slika2','$komentar2')";
                                        if(mysqli_query($db,$sql)){
                                            ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign">
                                                <?php echo "Uspešno dodata slika u galeriju !!!"; ?>
                                            </span>
                                            </div>
										  <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger">
                                            <span class=" glyphicon glyphicon-info-sign">
                                                <?php echo "Greška prilikom unosa slike u galeriju !!!"; ?>
                                            </span>
                                            </div>
										<?php
                                        }

                                    }
                                    else echo "Neuspešno prebacivanje!!!";
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
                            else{
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
                        else{
                            $errSlika2 = '* Obavezna slika';
                        }
                    }
                    ?>
					<label for="image2">Slika2:</label>
					<input type="file" name="slika2" id="image2"><br>
                    <span style="color: red;"><?php if(isset($errSlika2)) echo $errSlika2; ?></span>
					<textarea name="komentar2" placeholder="Unesite komentar slike" rows="3"></textarea>
				</div>
				<div class="insert_images">
                     <?php
                    if(isset($_POST['btn_insert_image'])){
                        $idGallery = $_POST['idGallery'];
                        //čitanje komentara !!!!
                        $komentar3 = mysqli_real_escape_string($db, $_POST['komentar3']);
                        $komentar3 = strip_tags($_POST['komentar3']);
                         //slika3
                       $slika3 = $_FILES['slika3']['name'];
                        $slika3_tmp = $_FILES['slika3']['tmp_name'];
                        $slika3_size = $_FILES['slika3']['size'];
                        $slika3_error = $_FILES['slika3']['error'];
                        $komentar3 = test_input($komentar3);
                        if($slika3 !="")
                        {

                        $ext = pathinfo($slika3,PATHINFO_EXTENSION);
                        $allowed_ext = array('jpeg','jpg','png');
                        if(in_array($ext,$allowed_ext))
                        {
                            if($slika3_error === 0)
                            {
                                if($slika3_size < 1000000)
                                {
                                    $slika3 = time()."_3.".pathinfo($slika3,PATHINFO_EXTENSION);
                                    if(move_uploaded_file($slika3_tmp,"../gallery/".$slika3))
                                    {
                                        $sql = "INSERT INTO gallery_images(idGallery,slika,komentar) VALUES($idGallery,'$slika3','$komentar3')";
                                        if(mysqli_query($db,$sql)){
                                            ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign">
                                                <?php echo "Uspešno dodata slika u galeriju !!!"; ?>
                                            </span>
                                            </div>
										  <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger">
                                            <span class=" glyphicon glyphicon-info-sign">
                                                <?php echo "Greška prilikom unosa slike u galeriju !!!"; ?>
                                            </span>
                                            </div>
										<?php
                                        }

                                    }
                                    else echo "Neuspešno prebacivanje!!!";
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
                            else{
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
                        else{
                            $errSlika3 = '* Obavezna slika';
                        }
                    }
                    ?>
					<label for="image3">Slika3:</label>
					<input type="file" name="slika3" id="image3"><br>
                    <span style="color: red"><?php if(isset($errSlika3)) echo $errSlika3; ?></span>
					<textarea name="komentar3" placeholder="Unesite komentar slike" rows="3"></textarea>
				</div>
				<div class="insert_images">
                    <?php
                    if(isset($_POST['btn_insert_image'])){
                        $idGallery = $_POST['idGallery'];
                        //čitanje komentara !!!!
                        $komentar4 = mysqli_real_escape_string($db, $_POST['komentar4']);
                        $komentar4 = strip_tags($_POST['komentar4']);
                         //slika3
                       $slika4 = $_FILES['slika4']['name'];
                        $slika4_tmp = $_FILES['slika4']['tmp_name'];
                        $slika4_size = $_FILES['slika4']['size'];
                        $slika4_error = $_FILES['slika4']['error'];
                        $komentar4 = test_input($komentar4);
                        if($slika4 !="")
                        {

                        $ext = pathinfo($slika4,PATHINFO_EXTENSION);
                        $allowed_ext = array('jpeg','jpg','png');
                        if(in_array($ext,$allowed_ext))
                        {
                            if($slika4_error === 0)
                            {
                                if($slika4_size < 1000000)
                                {
                                    $slika4 = time()."_4.".pathinfo($slika4,PATHINFO_EXTENSION);
                                    if(move_uploaded_file($slika4_tmp,"../gallery/".$slika4))
                                    {
                                        $sql = "INSERT INTO gallery_images(idGallery,slika,komentar) VALUES($idGallery,'$slika4','$komentar4')";
                                        if(mysqli_query($db,$sql)){
                                            ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign">
                                                <?php echo "Uspešno dodata slika u galeriju !!!"; ?>
                                            </span>
                                            </div>
										  <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger">
                                            <span class=" glyphicon glyphicon-info-sign">
                                                <?php echo "Greška prilikom unosa slike u galeriju !!!"; ?>
                                            </span>
                                            </div>
										<?php
                                        }

                                    }
                                    else echo "Neuspešno prebacivanje!!!";
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
                            else{
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
                        else{
                            $errSlika4 = '* Obavezna slika';
                        }
                    }
                    ?>
					<label for="image4">Slika4:</label>
					<input type="file" name="slika4" id="image4"><br>
                    <span style="color: red"><?php if(isset($errSlika4)) echo $errSlika4; ?></span>
					<textarea name="komentar4" placeholder="Unesite komentar slike" rows="3"></textarea>
				</div>
				<div class="insert_images">
                    <?php
                    if(isset($_POST['btn_insert_image'])){
                        $idGallery = $_POST['idGallery'];
                        //čitanje komentara !!!!
                        $komentar5 = mysqli_real_escape_string($db, $_POST['komentar5']);
                        $komentar5 = strip_tags($_POST['komentar5']);
                         //slika3
                       $slika5 = $_FILES['slika5']['name'];
                        $slika5_tmp = $_FILES['slika5']['tmp_name'];
                        $slika5_size = $_FILES['slika5']['size'];
                        $slika5_error = $_FILES['slika5']['error'];
                        $komentar5 = test_input($komentar5);
                        if($slika5 !="")
                        {

                        $ext = pathinfo($slika5,PATHINFO_EXTENSION);
                        $allowed_ext = array('jpeg','jpg','png');
                        if(in_array($ext,$allowed_ext))
                        {
                            if($slika5_error === 0)
                            {
                                if($slika5_size < 1000000)
                                {
                                    $slika5 = time()."_5.".pathinfo($slika5,PATHINFO_EXTENSION);
                                    if(move_uploaded_file($slika5_tmp,"../gallery/".$slika5))
                                    {
                                        $sql = "INSERT INTO gallery_images(idGallery,slika,komentar) VALUES($idGallery,'$slika5','$komentar5')";
                                        if(mysqli_query($db,$sql)){
                                            ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign">
                                                <?php echo "Uspešno dodata slika u galeriju !!!"; ?>
                                            </span>
                                            </div>
										  <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger">
                                            <span class=" glyphicon glyphicon-info-sign">
                                                <?php echo "Greška prilikom unosa slike u galeriju !!!"; ?>
                                            </span>
                                            </div>
										<?php
                                        }

                                    }
                                    else echo "Neuspešno prebacivanje!!!";
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
                            else{
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
                        else{
                            $errSlika5 = '* Obavezna slika';
                        }
                    }
                    ?>
					<label for="image5">Slika5:</label>
					<input type="file" name="slika5" id="image5"><br>
                    <span style="color: red"><?php if(isset($errSlika5)) echo $errSlika5; ?></span>
					<textarea name="komentar5" placeholder="Unesite komentar slike" rows="3"></textarea>
				</div>
				<div class="insert_images">
                    <?php
                    if(isset($_POST['btn_insert_image'])){
                        $idGallery = $_POST['idGallery'];
                        //čitanje komentara !!!!
                        $komentar6 = mysqli_real_escape_string($db, $_POST['komentar6']);
                        $komentar6 = strip_tags($_POST['komentar6']);
                         //slika3
                       $slika6 = $_FILES['slika6']['name'];
                        $slika6_tmp = $_FILES['slika6']['tmp_name'];
                        $slika6_size = $_FILES['slika6']['size'];
                        $slika6_error = $_FILES['slika6']['error'];
                        $komentar6 = test_input($komentar6);
                        if($slika6 !="")
                        {

                        $ext = pathinfo($slika6,PATHINFO_EXTENSION);
                        $allowed_ext = array('jpeg','jpg','png');
                        if(in_array($ext,$allowed_ext))
                        {
                            if($slika6_error === 0)
                            {
                                if($slika6_size < 1000000)
                                {
                                    $slika6 = time()."_6.".pathinfo($slika6,PATHINFO_EXTENSION);
                                    if(move_uploaded_file($slika6_tmp,"../gallery/".$slika6))
                                    {
                                        $sql = "INSERT INTO gallery_images(idGallery,slika,komentar) VALUES($idGallery,'$slika6','$komentar6')";
                                        if(mysqli_query($db,$sql)){
                                            ?>
                                            <div class="alert alert-success">
                                            <span class="glyphicon glyphicon-info-sign">
                                                <?php echo "Uspešno dodata slika u galeriju !!!"; ?>
                                            </span>
                                            </div>
										  <?php
                                        }else{
                                            ?>
                                            <div class="alert alert-danger">
                                            <span class=" glyphicon glyphicon-info-sign">
                                                <?php echo "Greška prilikom unosa slike u galeriju !!!"; ?>
                                            </span>
                                            </div>
										<?php
                                        }

                                    }
                                    else echo "Neuspešno prebacivanje!!!";
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
                            else{
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
                        else{
                            $errSlika6 = '* Obavezna slika';
                        }
                    }
                    ?>
					<label for="image6">Slika6:</label>
					<input type="file" name="slika6" id="image6"><br>
                    <span style="color: red"><?php if(isset($errSlika6)) echo $errSlika6; ?></span>
					<textarea name="komentar6" placeholder="Unesite komentar slike" rows="3"></textarea>
				</div>
				<input type="submit" name="btn_insert_image" value="Unesi slike" class="btn btn-primary">
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
