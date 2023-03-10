<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$connection = new mysqli ("lnpp-8-mysql-db", "root", "root", "db_petani");

if ($connection->connect_error != null) {
    echo  "Gagal terhubung ke Database";
    die();
}

