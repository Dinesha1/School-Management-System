<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit();
} elseif ($_SESSION['usertype'] == 'student') {
    header("location:login.php");
    exit();
}

$host = "localhost";
$user = "root";
$password = "";
$db = "schoolproject";

$data = mysqli_connect($host, $user, $password, $db);

if (!$data) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

if (!$id) {
    echo "No student ID provided!";
    exit();
}

$sql = "SELECT * FROM user WHERE id = '$id'";
$result = mysqli_query($data, $sql);

if (!$result) {
    echo "Error fetching student data: " . mysqli_error($data);
    exit();
}

$info = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $sql = "UPDATE user SET username='$username', email='$email', phone='$phone', password='$password' WHERE id='$id'";
    if (mysqli_query($data, $sql)) {
        $_SESSION['messages'] = "Student updated successfully!";
        header("location:view_student.php");
        exit();
    } else {
        echo "Error updating student: " . mysqli_error($data);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>

    <?php include 'admin_css.php'; ?>
    <style type="text/css">
        label {
            display: inline-block;
            width: 100px;
            text-align: right;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .div_deg {
            background-color: skyblue;
            width: 400px;
            padding-top: 70px;
            padding-bottom: 70px;
        }
    </style>
</head>
<body>

<?php include 'admin_sidebar.php'; ?>

<div class="content">
    <center>
        <h1>Update Student</h1>
        <div class="div_deg">
            <form action="#" method="post">
                <div>
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo isset($info['username']) ? $info['username'] : ''; ?>">
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo isset($info['email']) ? $info['email'] : ''; ?>">
                </div>
                <div>
                    <label>Phone</label>
                    <input type="number" name="phone" value="<?php echo isset($info['phone']) ? $info['phone'] : ''; ?>">
                </div>
                <div>
                    <label>Password</label>
                    <input type="text" name="password" value="<?php echo isset($info['password']) ? $info['password'] : ''; ?>">
                </div>
                <div>
                    <input type="submit" class="btn btn-success" name="update" value="Update">
                </div>
                <input type="hidden" name="student_id" value="<?php echo $id; ?>">
            </form>
        </div>
    </center>
</div>

</body>
</html>
