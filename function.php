<?php
function connect()
{
    $db = @ mysqli_connect('localhost','root','','');
    if(!$db) return false;
    // č ć ž đ š
    mysqli_query($db,'SET NAMES UTF8');
    return $db;
}
// funkcija za proveru unosa podataka
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function prikaziMeni($db)
{
    $sql = "SELECT * FROM kategorije";
    $res = mysqli_query($db,$sql);
    while($row = mysqli_fetch_object($res))
    {
        echo "<li><a href='index.php?naziv=$row->naziv'>$row->naziv</a></li>";
    }
}
?>