<?php include "../config.php";

$id = $_POST['id'] ?? "";
$name = secure($_POST['name']);
$email = secure($_POST['email']);
$age = secure($_POST['age']);
$phone = secure($_POST['phone']);
$website = secure($_POST['website']);
$gender = secure($_POST['gender']);
$plan = secure($_POST['plan']);
$birthday = secure($_POST['birthday']);
$meeting_time = secure($_POST['meeting_time']);
$appointment = secure($_POST['appointment']);
$experience = secure($_POST['experience']);
$fav_color = secure($_POST['fav_color']);
$bio = secure($_POST['bio']);

$hobbies = json_encode($_POST['hobbies'] ?? []);

$profile_picture = "";

if (!empty($_FILES['profile_picture']['name'])) {
    $filename = time() . "_" . $_FILES['profile_picture']['name'];
    move_uploaded_file($_FILES['profile_picture']['tmp_name'], "../uploads/$filename");
    $profile_picture = $filename;
}

if ($id == "") {
    // CREATE
    $stmt = $conn->prepare("INSERT INTO persons (user_id,name,email,age,phone,website,gender,hobbies,plan,birthday,meeting_time,appointment,profile_picture,experience,fav_color,bio)
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ississssssssssis",
        $_SESSION['user_id'], $name, $email, $age, $phone, $website, $gender, $hobbies,
        $plan, $birthday, $meeting_time, $appointment, $profile_picture, $experience, $fav_color, $bio
    );

    $stmt->execute();
    echo "Created Successfully";
} else {
    // UPDATE
    $sql = "UPDATE persons SET name=?,email=?,age=?,phone=?,website=?,gender=?,hobbies=?,plan=?,birthday=?,meeting_time=?,appointment=?,experience=?,fav_color=?,bio=?";
    
    if ($profile_picture != "") {
        $sql .= ", profile_picture='$profile_picture'";
    }

    $sql .= " WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssssssssisi", $name,$email,$age,$phone,$website,$gender,$hobbies,$plan,$birthday,$meeting_time,$appointment,$experience,$fav_color,$bio,$id);
    $stmt->execute();

    echo "Updated Successfully";
}
