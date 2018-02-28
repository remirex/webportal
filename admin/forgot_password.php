<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 2.6.2017
 * Time: 10:08
 */
require_once'../function.php';
$db = connect();
if(!$db) echo 'Greška';
//else echo 'Uspešno';
if(isset($_POST['email']))
{
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $email = strip_tags($_POST['email']);
    // provera da li uneta email adresa postoji u bazi !!
    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $res=mysqli_query($db,$sql);
    if(mysqli_num_rows($res)==1)
    {
        //definisanje tokena !!!
        $str="qwertzuioplkjhgfdsayxcvbnm1234567890";
        $str=str_shuffle($str);
        $str=md5(substr($str,0,20));
        //definisanje upita za update tokena !!!
        /*
         * ručno se u url unosi http://localhost/portal/admin/reset_password.php?token=$str&email=$email
         * gde je token = pročitati iz baze vrednost tokena i
         * email = pročitati iz baze
         */
        $url = "http://localhost/portal/admin/reset_password.php?token=$str&email=$email";
        $sql="UPDATE users SET token='$str',expire=DATE_ADD(NOW(),INTERVAL 5 MINUTE ) WHERE email='$email'";
        mysqli_query($db,$sql);
        $message = "<font style='color: green'>Proverite svoj email <b>$email</b>, kako bi mogli da nastavite sa resetovanjem password-a !!</font>";

    }
    else $message = "<font style='color: red'>Email adresa ne postoji u bazi, molimo vas proverite input polje !!</font>";
}
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
        #forgot_password {
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
    <div id="forgot_password">
        <h1 style="text-align: center">Forgot your password?</h1>
        <h4 style="text-align: center"><?php if(isset($message)) echo $message; ?></h4>
       <form action="#" method="post">
           <div class="form-group">
               <label class="control-label" for="mail">Email:&nbsp;&nbsp;&nbsp;</label>
               <div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-envelope"></span>
					</span>
                   <input type="email" name="email" id="mail" placeholder="Email" class="form-control" required><br>
               </div>
               <span></span>
           </div>
           <div class="form-group">
               <input type="submit" value="Apply" class="btn btn-primary" style="width: 100%;text-transform: uppercase;font-weight: 700;letter-spacing: 1px">
           </div>
       </form>
       <h4 style="text-align: center"><a href="users.php">Back to Login page</a></h4>
    </div>
</div>
</body>
</html>
