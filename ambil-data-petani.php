<?php

include "connection.php";

$id = $_GET['id'];
$data_petani = $connection->query("SELECT * FROM data_petani WHERE id = '$id'")->fetch_assoc();

echo json_encode($data_petani);
