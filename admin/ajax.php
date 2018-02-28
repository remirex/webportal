<?php
require'../function.php';
require'class_Log.php';
$db = connect();
if(!$db) echo 'Greška';
//else echo 'Uspešno';
$funkcija = $_GET['funkcija'];
if($funkcija=='register')
{
    // čitanje prom poslatih post metodom !!!
    $first_name= mysqli_real_escape_string($db, $_POST['first_name']);//vraća pročišćen string !!!
    $first_name = strip_tags($_POST['first_name']);
    $last_name = mysqli_real_escape_string($db, $_POST['last_name']);
    $last_name = strip_tags($_POST['last_name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $email = strip_tags($_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $password = strip_tags($_POST['password']);
    // još jedna provera input polja pre snimanja podataka !!!
       /* $first_name = test_input( $first_name);
        $last_name = test_input($last_name);
        $email = test_input($email);
        $password = test_input($password); */
    // definisanje vrednosti za verifikaciju registracije !!!
    $potvrda=md5(time());
    // kriptovanje lozinke !!!
    $hash = password_hash($password,PASSWORD_BCRYPT,array('cost'=>10));
    // definisanje upita !!!
    $sql = "INSERT INTO users (first_name,last_name,email,password,potvrda,token)
            VALUES('$first_name','$last_name','$email','$hash','$potvrda','')";
    if(mysqli_query($db,$sql) or die(mysqli_error($db)))
    {
        /*
         * ukucati ručno u url http://localhost/portal/admin/verify_email.php?potvrda=$potvrda&email=$email za verifikaciju email-a
         * potvrda = vrednost iz baze
         * email = email iz baze
         */
        $url = "http://localhost/portal/admin/verify_email.php?potvrda=$potvrda&email=$email";
        echo "1";
    }
    else{
        echo "0";
    }
}
if($funkcija=='login')
{
    // čitanje prom poslatih post metodom !!!
    $mail = mysqli_real_escape_string($db, $_POST['mail']);
    $mail = strip_tags($_POST['mail']);
    $pass = mysqli_real_escape_string($db, $_POST['pass']);
    $pass = strip_tags($_POST['pass']);
    // još jedna provera input polja pre snimanja podataka !!!
        /*  $mail = test_input($mail);
            $pass = test_input($pass); */
    $sql = "SELECT * FROM users WHERE email='$mail' AND potvrda=1";
    $res = mysqli_query($db,$sql);
    if(mysqli_num_rows($res)==1)
    {
        $row = mysqli_fetch_object($res);
        if(password_verify($pass,$row->password))
        {
            session_start();
            $_SESSION['id']=$row->id;
            $_SESSION['first_name']=$row->first_name;
            $_SESSION['last_name']=$row->last_name;
            $_SESSION['status']=$row->status;
            $obj = new Log("Uspešna prijava za username: ".$row->first_name." ".$row->last_name."\r\n");
            $obj->upisLogovanja();
            echo 'index.php';
        }
    }
	else
    {
        $obj = new Log("Neuspešna prijava za email: $mail  sa lozinkom: $pass\r\n ");
        $obj->upisLogovanja();
    }
}
if($funkcija=='proveriEmail')
{
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $email = strip_tags($_POST['email']);
    $sql="SELECT * FROM users WHERE email='$email' AND obrisan=0";
    $res=mysqli_query($db,$sql);
    if(mysqli_num_rows($res)==1)
    {
        echo "postoji";
    }
    else{
        echo "ne postoji";
    }
}
?>