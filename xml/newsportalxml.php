<?php
require_once '../function.php';
$db = connect();
if(!$db) echo 'Greška';
//else echo 'Uspešno';
$sql="SELECT * FROM news ORDER BY id DESC ";
$res = mysqli_query($db,$sql);
$xmlDOM=new DOMDocument('1.0','utf-8');
$svevesti=$xmlDOM->createElement('svevesti');
while($row=mysqli_fetch_object($res))
{
    $vest=$xmlDOM->createElement('vest');
    $idvesti=$xmlDOM->createAttribute('id');
    $idvesti->value=$row->id;
    $naslov=$xmlDOM->createElement('naslov',$row->naslov);
    $opis=$xmlDOM->createElement('opis',$row->opis);
    $link=$xmlDOM->createElement('link',"http://localhost/portal/big_news.php?id='".$row->id."'");
    $sadrzaj=$xmlDOM->createElement('sadrzaj',$row->sadrzaj);
    $datum=$xmlDOM->createElement('datum',$row->datum);
    $autor=$xmlDOM->createElement('autor',$row->autor);
    $vest->appendChild($idvesti);
    $vest->appendChild($naslov);
    $vest->appendChild($opis);
    $vest->appendChild($link);
    $vest->appendChild($sadrzaj);
    $vest->appendChild($datum);
    $vest->appendChild($autor);
    $svevesti->appendChild($vest);
}
$xmlDOM->appendChild($svevesti);
$xmlDOM->save('NewsPortalXML.xml');
header('content-type:text/xml');
echo $xmlDOM->saveXML();
