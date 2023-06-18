<?php

function connectToDatabase(){
    $dbhost = 'tuxa.sme.utc';
    $dbuser = 'nf92p083';
    $dbpass = 'vu8sr3KFG87s';
    $dbname = 'nf92p083';
    $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
    return $connect;
}