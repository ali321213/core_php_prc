<?php include "../config.php";

$id = $_POST['id'];
$conn->query("DELETE FROM persons WHERE id=$id");
echo "Deleted Successfully";
