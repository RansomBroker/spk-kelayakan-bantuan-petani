<?php

include "connection.php";

$id = $_GET['id'];

$data_alternatif = $connection->query("
        SELECT
            *
        FROM
            data_petani
        INNER JOIN
            data_kriteria
        ON 
            data_petani.id = data_kriteria.id_petani
        WHERE data_kriteria.id = '$id'
	")->fetch_assoc();

echo json_encode($data_alternatif);
