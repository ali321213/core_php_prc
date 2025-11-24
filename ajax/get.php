<?php include "../config.php";

$id = $_POST['id'];
$result = $conn->query("SELECT * FROM persons WHERE id=$id");
echo json_encode($result->fetch_assoc());
