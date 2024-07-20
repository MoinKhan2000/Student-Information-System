<?php
$loggedIn = false;
$wrongPass = false;
$notPresent = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../PHP/_dbConnect.php';
    if ($_POST['whoIs'] == 'Student') {
        $enrollId = $_POST['enroll'];
        $password = $_POST['password'];
        $password = sha1($password);
        $sql = "SELECT * FROM `student` WHERE std_id='$enrollId'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            if ($row['std_password'] == $password) {
                $userSql = "select std_name from std_details where std_id='$enrollId'";
                $userResult = mysqli_query($conn, $userSql);
                while ($row = mysqli_fetch_assoc($userResult)) {
                    $userName = $row['std_name'];
                }
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['enrollId'] = $enrollId;
                $_SESSION['userName'] = $userName;
                $_SESSION['character'] = 'Student';
                $wrongPass = false;
                $loggedIn = true;
                header("Location:../studentOperations/student_dashboard.php");
            } elseif ($row['std_password'] != $password) {
                $wrongPass = true;
            }
        } else {
            $notPresent = true;
        }
    } elseif ($_POST['whoIs'] == 'Teacher') {
        $t_id = $_POST['enroll'];
        $password = $_POST['password'];
        $password = sha1($password);
        $sql = "SELECT * FROM `teacher` WHERE `t_id`='$t_id'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            // echo "saved - " . $row['t_password'];
            if ($row['t_password'] == $password) {
                $userSql = "select t_name from teacher_details where t_id='$t_id'";
                $userResult = mysqli_query($conn, $userSql);
                while ($row = mysqli_fetch_assoc($userResult)) {
                    $userName = $row['t_name'];
                }
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['enrollId'] = $t_id;
                $_SESSION['userName'] = $userName;
                $_SESSION['character'] = 'Teacher';
                $wrongPass = false;
                $loggedIn = true;
                header("Location:../teacherOperations/teacherDashboard.php");
            } elseif ($row['t_password'] != $password) {
                $wrongPass = true;
            }
        } else {
            $notPresent = true;
        }
    } elseif ($_POST['whoIs'] == 'Admin') {
        $enrollId = $_POST['enroll'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM `admin` WHERE admin_id='$enrollId'";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            if ($row['admin_password'] == $password) {

                $userSql = "select admin_name from admin where admin_id='$enrollId'";
                $userResult = mysqli_query($conn, $userSql);
                while ($row = mysqli_fetch_assoc($userResult)) {
                    $userName = $row['admin_name'];
                }
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['enrollId'] = $enrollId;
                $_SESSION['userName'] = $userName;
                $_SESSION['character'] = 'Admin';
                $wrongPass = false;
                $loggedIn = true;
                header("Location:../Admin_Operations/admin_dashboard.php");
            } elseif ($row['admin_password'] != $password) {
                $wrongPass = true;
            }
        } else {
            $notPresent = true;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn To SiS</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<a href="../teacherOperations/teacherDashboard.php"></a>

<body>
    <?php
    require '../PHP/_header.php';
    ?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($wrongPass) {
            echo '<div class="alert">
           <B> &#9888; </B> Warning! Enter the correct password.
            <span>
                <button id="dismisible">X</button>
            </span>
        </div>';
        } elseif ($notPresent) {
            echo '<div class="alert Error";>
           <B> &#x2718; </B> Error! Account Not Found. SignUp firstly and then logIn.
            <span>
                <button id="dismisible">&#x2716;</button>
            </span>
        </div>';
        }
    }

    ?>
    <div class="d-flex" style="min-height:100vh;margin: 20px; ">
        <div id="loginForm">
            <h1>Login Form</h1>
            <form action="" method="post">
                <div>
                    
                        <input type="text" required name="enroll" id="enrollId" placeholder="Enter Enrollment Id ">

                </div>
                <div>
                        <input type="password" required name="password" id="password" placeholder="Enter Password">
                </div>
                <div>
                    <label for="whoIs">Choose Character
                        <select name="whoIs" id="whoIs">
                            <option value="Student" selected>Student</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </label>
                </div>
                    <button class="loginSignButton" type="submit">Login</button>
                
                <div style="margin:auto; text-align:center">
                    Don't have an account?  <a style="color:#f7009c;text-decoration:none; border:none !important;padding: 5px;" href="signUp.php">sign up now</a>
                </div>
            </form>
        </div>
    </div>
    <?php
    require '../PHP/_footer.php';
    ?>
</body>
<script>
    try {
        dismisible = document.getElementById('dismisible');
        dismisible.addEventListener("click", () => {
            document.getElementsByClassName('alert')[0].style.display = "none";
        })
    } catch {

    }
</script>

</html>