<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 2.6.2017
 * Time: 10:04
 */
session_start();
require_once'../function.php';
$db=connect();
if(isset($_GET['email']) and !empty($_GET['email']) and isset($_GET['token']) and !empty($_GET['token']))
{
    //čitanje get globalnih varijabli !!!
    $email = mysqli_real_escape_string($db, $_GET['email']);
    $email = strip_tags($_GET['email']);
    $token = mysqli_real_escape_string($db, $_GET['token']);
    $token = strip_tags($_GET['token']);
    //definisanje upita !!!bitno je da name je token različit od empty i da je expire veći od trnutnog vremena !!!
    $sql = "SELECT * FROM users WHERE email='$email' and token='$token' and token <> '' and expire > NOW() LIMIT 1";
    $res = mysqli_query($db,$sql);
    if(mysqli_num_rows($res)==0)
    {
        $_SESSION['message'] = "Uneli ste pogrešan URL za resetovanje password-a !!";
        header("location: error.php");
    }
}
else
{
    $_SESSION['message'] = 'Izvinite,validacija je prekinuta,pokušajte ponovo';
    header("location: error.php");
}
?>
<!doctype html>
    <html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=latin-ext" rel="stylesheet">
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/main.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        #reset_password {
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
    <div id="reset_password">
        <?php
        if(isset($_POST['reset'])) {
            // čitenje prom !!!
            $password = mysqli_real_escape_string($db, $_POST['password']);
            $password = strip_tags($_POST['password']);
            $password2 = mysqli_real_escape_string($db, $_POST['password2']);
            $password2 = strip_tags($_POST['password2']);
            if(!empty($password))
            {
                if(strlen($password)<=7)
                    $newpassErr = 'Password mora imati minimum 8 karaktera!!';
            }
            else
                $newpassErr = 'Unesite novi password';
            if (empty($password2)) {
                $confpassErr = 'Potvrdite password';
            }
            elseif($password == $password2)
            {
                // kriptovanje novog passworda !!!
                $password = password_hash($password,PASSWORD_BCRYPT);
                $sql = "UPDATE users SET password='$password',token='' WHERE email='$email'";
                if(mysqli_query($db,$sql) or die(mysqli_error($db)))
                {
                    $message="<font style='color: green'>Uspešno ste resetovali vaš password</font>";
                }
            }else{
                $message = "<font style='color: red'>Password-i se ne poklapaju,pokušajte ponovo !!</font>";
            }
        }
        ?>
        <h1 style="text-align: center">Reset your password</h1>
        <h4 style="text-align: center"><?php if(isset($message)) echo $message; ?></h4>
        <form action="#" method="post">
            <div class="form-group">
                <label class="control-label" for="pass1">New Password:&nbsp;&nbsp;&nbsp;</label>
                <div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-lock"></span>
					</span>
                    <input type="password" name="password" id="pass1" placeholder="Password" class="form-control">
                </div>
                <span style="color: red"><?php if(isset($newpassErr)) echo $newpassErr; ?></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="pass2">New Password-confirm:&nbsp;&nbsp;&nbsp;</label>
                <div class="input-group">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-lock"></span>
					</span>
                    <input type="password" name="password2" id="pass2" placeholder="Password confirm" class="form-control">
                </div>
                <span style="color: red"><?php if(isset($confpassErr)) echo $confpassErr; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" name="reset" value="reset password" class="btn btn-primary" style="width: 100%;text-transform: uppercase;font-weight: 700;letter-spacing: 1px">
            </div>
        </form>
        <h4 style="text-align: center"><a href="users.php">Back to Login page</a></h4
    </div>
</div>
</body>
</html>
