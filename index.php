<?php
include "header.php";
$type = 'guest';
include "auth.php";
include "config.php";
?>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = secure($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['user_id'] = $result['id'];
        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid login";
    }

    // if ($result && md5($password) === $result['password']) {
    //     $_SESSION['user_id'] = $result['id'];
    //     header("Location: home.php");
    //     exit;
    // } else {
    //     $error = "Invalid login";
    // }
}
?>

<style>
    body {
        background: #f0f2f5;
    }

    .login-card {
        max-width: 420px;
        margin: 80px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background: #fff;
    }
</style>

<div class="login-card">
    <h3 class="text-center mb-4">Login</h3>

    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php } ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <button class="btn btn-primary w-100">Login</button>
    </form>

    <div class="text-center mt-3">
        <a href="register.php">Create an Account</a>
    </div>
</div>
