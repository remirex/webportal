<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 8.6.2017
 * Time: 11:37
 */
require_once'function.php';
$db=connect();
if($_POST['id']!=''and $_POST['type']!='')
{
    if($_POST['type']=='likes')
    {
        $likes=$_POST['type'];
        $id=$_POST['id'];
        $sql="UPDATE komentari SET likes=$likes+1 WHERE id=$id";
        mysqli_query($db,$sql);
        $sql="SELECT likes FROM komentari WHERE id=$id";
        $res=mysqli_query($db,$sql);
        $row=mysqli_fetch_object($res);
        echo $row->likes;
    }
    elseif($_POST['type']=='unlikes')
    {
        $unlikes=$_POST['type'];
        $id=$_POST['id'];
        $sql="UPDATE komentari SET unlikes=$unlikes+1 WHERE id=$id";
        mysqli_query($db,$sql);
        $sql="SELECT unlikes FROM komentari WHERE id=$id";
        $res=mysqli_query($db,$sql);
        $row=mysqli_fetch_object($res);
        echo $row->unlikes;
    }
}