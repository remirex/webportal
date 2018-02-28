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
    <title>Contact</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/main.css" rel="stylesheet" type="text/css">
    <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <style>
        #map{
            width: 100%;
            height: 340px;
        }
        #contact_left{
            float: left;
            width: 460px;
            padding: 10px;
            margin-bottom: 50px;
        }
        #contact_right{
            float: right;
            width: 460px;
            padding: 10px;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>
<header id="header" style="margin-bottom: 0">
    <?php
    include'temp_header.php';
    ?>
</header>
<div id="map"></div>
<script>
    function initMap(){
        var location = {lat:44.790272,lng:20.466340};
        var map = new google.maps.Map(document.getElementById('map'),{
            zoom: 16,
            center: location
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDjzdc01omPICmy1wIV5E0CR38pggQZj5E&callback=initMap"></script>
<div class="wrapper">
    <h1>Adrese i telefoni</h1>
    <div id="contact_left">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur dicta doloremque eos eum, id in ipsa ipsam natus necessitatibus nisi, nobis nulla perspiciatis quam, recusandae soluta vero vitae! Accusantium aliquid aperiam assumenda beatae dolore doloremque est eum, facere, magnam nostrum obcaecati officiis, praesentium provident quaerat quos recusandae rem! Nemo, perspiciatis.</p>
        <table>
            <tr>
                <td><h3><i class="fa fa-phone" aria-hidden="true"></i></h3></td>
                <td><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;+381637479753</h3></td>
            </tr>
            <tr>
                <td><h3><i class="fa fa-envelope" aria-hidden="true"></i></h3></td>
                <td><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mirkojosimovic1987@gmail.com</h3></td>
            </tr>
            <tr>
                <td><h3><i class="fa fa-globe" aria-hidden="true"></i></h3></td>
                <td><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;www.mirkojosimovic.rs</h3></td>
            </tr>
            <tr>
                <td><h3><i class="fa fa-home" aria-hidden="true"></i></h3></td>
                <td><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bulevar Oslobođenja 53, 11080<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vračar, Beograd, Serbia</h3></td>
            </tr>
        </table>
    </div>
    <div id="contact_right">
        <img src="images/contact_img.jpg" alt="nema slike">
    </div>
</div>
<footer id="footer">
    <?php
    include'temp_footer.php';
    ?>
</footer>
</body>
</html>
