<?php include "../config.php"; ?>

<table class="table table-striped table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
<?php
$result = $conn->query("SELECT * FROM persons WHERE user_id=".$_SESSION['user_id']);

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['phone']}</td>
        <td>
            <button class='btn btn-sm btn-warning me-1' onclick='editUser({$row['id']})'>
                <i class='bi bi-pencil-fill'></i>
            </button>
            <button class='btn btn-sm btn-danger' onclick='deleteUser({$row['id']})'>
                <i class='bi bi-trash-fill'></i>
            </button>
            <button class='btn btn-sm btn-info' onclick='showRecord(".$row['id'].")'>
                <i class='bi bi-eye-fill'></i>
            </button>
        </td>
    </tr>";
}
?>
    </tbody>
</table>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
