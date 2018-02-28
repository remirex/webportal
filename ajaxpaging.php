<?php
/**
 * Created by PhpStorm.
 * User: Mirko
 * Date: 15.6.2017
 * Time: 17:41
 */
require_once'function.php';
$db=connect();
if(!$db) echo 'Greška';
//else echo 'Uspešno';
if(isset($_GET['strana']) and is_numeric($_GET['strana']))
{
    $strana=$_GET['strana'];
    $sql="SELECT * FROM news LIMIT ".($strana*10).",10";
    $res=mysqli_query($db,$sql);
    while($row=mysqli_fetch_object($res))
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
else echo 'Nepostojeća strana.';
