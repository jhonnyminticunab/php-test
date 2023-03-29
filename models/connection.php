<?php

class connection{

    static public function connect(){

        $link = new PDO("mysql:host=localhost;dbname=apponlin_80","root","");
//        $link = new PDO("mysql:host=localhost;dbname=apponlin_80","apponlin_nimajho","j771012G08802b");
        $link->exec("set names utf8");

        return $link;

    }

}
