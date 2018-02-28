<?php
class Log
{
    public $text;
    public function  __construct($text)
    {
        $this->text = $text;
    }
    public function upisLogovanja()
    {
        $ime_datoteke = "log/logovanje.txt";
        $upis = date("d.m.Y H:i:s",time())." - ".$this->text;
        // otvaranje datoteke !!!
        $f = fopen($ime_datoteke,"a");
        // upis u datoteku !!!
        fwrite($f,$upis);
        fclose($f);
    }
    public function insertVesti()
    {
        $ime_datoteke = "log/insert.txt";
        $upis = date("d.m.Y H:i:s",time())." - ".$this->text;
        // otvaranje datoteke !!!
        $f = fopen($ime_datoteke,"a");
        // upis u datoteku !!!
        fwrite($f,$upis);
        fclose($f);
    }
    public function updateVesti()
    {
        $ime_datoteke = "log/update.txt";
        $upis = date("d.m.Y H:i:s",time())." - ".$this->text;
        // otvaranje datoteke !!!
        $f = fopen($ime_datoteke,"a");
        // upis u datoteku !!!
        fwrite($f,$upis);
        fclose($f);
    }
}