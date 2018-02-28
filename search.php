<?php
require_once('function.php');
if(isset($_GET['logout'])){
	session_start();
	unset($_SESSION['username']);
	unset($_SESSION['name']);
	unset($_SESSION['email']);
	unset($_SESSION['status']);
	session_destroy();
}
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>CSSAni</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
    <style>
        .search img {
            float: left;
            margin: 5px 10px 5px 0;
        }
        .search a {
            display: block;
            font-size: 20px;
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
            <section id="container_news">
                <section class="news">
             <?php
                 $db = connect();
                 if(isset($_GET['pretraga']))
                 {
                     $pretraga = mysqli_real_escape_string($db, $_POST['pretraga']);
                     $pretraga = strip_tags($_POST['pretraga']);
                     $sql = "SELECT * FROM news WHERE naslov LIKE('%".$_GET['pretraga']."%') or opis LIKE('%".$_GET['pretraga']."%') or sadrzaj LIKE('%".$_GET['pretraga']."%') or autor LIKE('%".$_GET['pretraga']."%')";
                    $res = mysqli_query($db,$sql);
                    while($row = mysqli_fetch_object($res))
                    {
                        ?>
                        <table>
                            <td>
                                <a href="big_news.php?id=<?=$row->id?>"><img src="images/<?=$row->slika?>" alt="Slika" width="100" height="75" style="margin-right: 15px"></a>
                            </td>
                            <td>
                                <a href="big_news.php?id=<?=$row->id?>"><?=$row->naslov?></a>
                                <p><?=$row->opis?></p>
                                <p><i><?=$row->datum?> | <?=$row->autor?></i></p>
                            </td>
                        </table>
                        <hr>
                    <?php
                    }
                 }
                ?>
                </section><!-- end search news -->
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
                </section><!-- end side_news -->
            </section><!-- end container_news -->
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
    </body>
</html>