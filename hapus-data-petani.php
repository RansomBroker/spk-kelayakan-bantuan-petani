<?php

include "connection.php";
include "helper.php";

$id = $_GET['id'];
$query = $connection->query("
    DELETE FROM data_petani WHERE id = '$id'
");

redirect('olah-data.php?halaman=olah-data');
