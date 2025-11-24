<?php
$type = 'auth';
include "auth.php";
include "config.php";
?>
<?php if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f4f8;
        }

        .card {
            border-radius: 12px;
        }

        label {
            font-weight: 500;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand">Dashboard</span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">

        <!-- Form Card -->
        <div class="card shadow p-4 mb-4">
            <h4 class="mb-3 text-primary">Add / Edit Person</h4>

            <form id="crudForm" enctype="multipart/form-data">

                <input type="hidden" name="id" id="id">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input name="name" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input name="email" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Password</label>
                        <input name="password" class="form-control" type="password">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Age</label>
                        <input name="age" class="form-control" type="number">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input name="phone" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Website</label>
                        <input name="website" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-select">
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Hobbies</label><br>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="hobbies[]" value="Sports" class="form-check-input">
                            <label class="form-check-label">Sports</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="hobbies[]" value="Music" class="form-check-input">
                            <label class="form-check-label">Music</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="hobbies[]" value="Coding" class="form-check-input">
                            <label class="form-check-label">Coding</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Subscription Plan</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="plan" value="free" class="form-check-input">
                            <label class="form-check-label">Free</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="plan" value="pro" class="form-check-input">
                            <label class="form-check-label">Pro</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="plan" value="vip" class="form-check-input">
                            <label class="form-check-label">VIP</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Birthday</label>
                        <input type="date" name="birthday" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Meeting Time</label>
                        <input type="time" name="meeting_time" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Appointment</label>
                        <input type="datetime-local" name="appointment" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Experience Level (0-10)</label>
                        <input type="range" name="experience" min="0" max="10" class="form-range">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Favorite Color</label>
                        <input type="color" name="fav_color" class="form-control form-control-color">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Bio</label>
                        <textarea name="bio" class="form-control"></textarea>
                    </div>
                </div>

                <button class="btn btn-primary w-100">Save</button>

            </form>
        </div>

        <!-- Table Card -->
        <div class="card shadow p-4">
            <h4 class="mb-3 text-success">Records</h4>
            <table class="table table-bordered table-striped" id="dataTable"></table>
        </div>

    </div>



    <div class="modal fade" id="recordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Person Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be injected by JS -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        loadData();

        $("#crudForm").on("submit", function(e) {
            e.preventDefault();
            var form = new FormData(this);

            $.ajax({
                url: "ajax/create.php",
                method: "POST",
                data: form,
                processData: false,
                contentType: false,
                success: function(res) {
                    alert(res);
                    loadData();
                    $("#crudForm")[0].reset();
                }
            });
        });

        function loadData() {
            $.get("ajax/read.php", function(data) {
                $("#dataTable").html(data);
            });
        }

        function editUser(id) {
            $.post("ajax/get.php", {
                id: id
            }, function(res) {
                var data = JSON.parse(res);

                $("#id").val(data.id);
                $("[name=name]").val(data.name);
                $("[name=email]").val(data.email);
                $("[name=age]").val(data.age);
                $("[name=phone]").val(data.phone);
                $("[name=website]").val(data.website);
                $("[name=gender]").val(data.gender);
                $("[name=birthday]").val(data.birthday);
                $("[name=meeting_time]").val(data.meeting_time);
                $("[name=appointment]").val(data.appointment);
                $("[name=experience]").val(data.experience);
                $("[name=fav_color]").val(data.fav_color);
                $("[name=bio]").val(data.bio);
            });
        }

        function deleteUser(id) {
            if (confirm("Delete?")) {
                $.post("ajax/delete.php", {
                    id: id
                }, function(res) {
                    alert(res);
                    loadData();
                });
            }
        }

        function showRecord(id) {
            $.post("ajax/show.php", {
                id: id
            }, function(res) {
                var data = JSON.parse(res);
                if (data.error) {
                    alert(data.error);
                } else {
                    // Show details in a modal
                    let hobbies = JSON.parse(data.hobbies || "[]");
                    let html = `
                <p><strong>Name:</strong> ${data.name}</p>
                <p><strong>Email:</strong> ${data.email}</p>
                <p><strong>Phone:</strong> ${data.phone}</p>
                <p><strong>Age:</strong> ${data.age}</p>
                <p><strong>Website:</strong> ${data.website}</p>
                <p><strong>Gender:</strong> ${data.gender}</p>
                <p><strong>Hobbies:</strong> ${hobbies.join(", ")}</p>
                <p><strong>Subscription Plan:</strong> ${data.plan}</p>
                <p><strong>Birthday:</strong> ${data.birthday}</p>
                <p><strong>Meeting Time:</strong> ${data.meeting_time}</p>
                <p><strong>Appointment:</strong> ${data.appointment}</p>
                <p><strong>Experience:</strong> ${data.experience}</p>
                <p><strong>Favorite Color:</strong> <span style="background:${data.fav_color};padding:0 10px;">&nbsp;</span></p>
                <p><strong>Bio:</strong> ${data.bio}</p>
                ${data.profile_picture ? `<p><img src='uploads/${data.profile_picture}' width='120'></p>` : ''}
            `;
                    $("#recordModal .modal-body").html(html);
                    $("#recordModal").modal("show");
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>