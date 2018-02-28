<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 2.6.2017
 * Time: 10:07
 */
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
        #error {
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
<div style="margin: 100px auto">
    <div id="error">
        <h1 style="text-align: center">Error</h1>
        <h4 style="text-align: center;color: red">
            <?php
            if(isset($_SESSION['message']) and !empty($_SESSION['message']))
            {
                echo $_SESSION['message'];
            }
            else{
                header("location: users.php");
            }
            ?>
        </h4>
        <div class="form-group">
           <a href="users.php"><button class="btn btn-primary" style="width: 100%;text-transform: uppercase;font-weight: 700;letter-spacing: 1px">Back to Login page</button></a>
        </div>
    </div>
</div>
</body>
</html>
