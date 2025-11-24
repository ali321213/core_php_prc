<?php
include "../config.php";

$id = $_POST['id'] ?? "";

if ($id == "") {
    echo json_encode(['error' => 'No ID provided']);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM persons WHERE id=? AND user_id=? LIMIT 1");
$stmt->bind_param("ii", $id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(['error' => 'Record not found']);
}
?>
