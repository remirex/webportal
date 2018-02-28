<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 13.5.2017
 * Time: 12:26
 */
require_once'function.php';
$db = connect();
if(!$db) echo 'Greška';
//else echo 'Uspešno';
$funkcija=$_GET['funkcija'];
if($funkcija=='comment')
{
    // čitamo šta nam je došlo get metodom !!!
    $idVesti = mysqli_real_escape_string($db, $_POST['idVesti']);
    $idVesti = strip_tags($_POST['idVesti']);
    $autor = mysqli_real_escape_string($db, $_POST['autor']);
    $autor = strip_tags($_POST['autor']);
    $tekst = mysqli_real_escape_string($db, $_POST['tekst']);
    $tekst = strip_tags($_POST['tekst']);
    $sql = "INSERT INTO komentari (idVesti,autor,tekst) VALUES ('$idVesti','$autor','$tekst')";
    if(mysqli_query($db,$sql) or die(mysqli_error($db)))
    {
        echo "<font style='color:green'>Uspešno ste dodali komentar</font>";
    }else{
        echo "<font style='color:red'>Neuspešno dodavanje komentara</font>";
    }
}