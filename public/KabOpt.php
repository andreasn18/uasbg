<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "bguas";
$conn = new mysqli($servername, $username, $password, $dbname);

extract($_POST);

$sql = "SELECT * from master_kabupaten where kode_prop = $prov";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $kab = array();
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $kab[$i]['nama_kab'] = addslashes(htmlentities($row['nama_kab']));
        $kab[$i]['kode_kab'] = addslashes(htmlentities($row['kode_kab']));
        $i++;
    }
    echo json_encode($kab);
} else {
    echo json_encode("Gagal");
}
$stmt->close();
$conn->close();
