<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 2.6.2017
 * Time: 10:05
 */
require_once'../function.php';
$db=connect();
if(!$db) echo "Greška";
//else echo "Uspešno";
session_start();
?>
<!doctype html>
    <html>
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/main.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        #verify {
            background-color: lightgray;
            margin: auto;
            color: gray;
            width: 450px;
            padding: 25px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div id="verify"  style="margin: 100px auto">
    <h1 style="text-align: center">Verifikacija</h1>
    <p style="text-align: center">
        <?php
        if(isset($_GET['email']) and isset($_GET['potvrda']))
        {
            $email=$_GET['email'];
            $potvrda=$_GET['potvrda'];
            $sql="SELECT * FROM users WHERE email='$email' AND potvrda='$potvrda'";
            $res=mysqli_query($db,$sql);
            if(mysqli_num_rows($res)==1)
            {
                $sql="UPDATE users SET potvrda='1' WHERE email='$email' AND potvrda='$potvrda'";
                mysqli_query($db,$sql);
                echo  "<font color='green'>Uspešno ste verifikovali email adresu</font>";
            }
            else echo  "<font color='red'>Korisnik se nije registrovao ili je već potvrdio email adresu !!!</font>";
        }
        else
            echo "<font color='red'>Niste uneli neophodne podatke</font>";
        ?>
    </p>
    <div class="form-group">
        <a href="users.php"><button class="btn btn-primary" style="width: 100%;text-transform: uppercase;font-weight: 700;letter-spacing: 1px">Back to Login page</button></a>
    </div>
</div>
</body>
</html>
