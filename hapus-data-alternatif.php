<?php

include "connection.php";
include "helper.php";

$id = $_GET['id'];
$query = $connection->query("
    DELETE FROM data_kriteria WHERE id = '$id'
");

redirect('olah-data.php?halaman=olah-data');
