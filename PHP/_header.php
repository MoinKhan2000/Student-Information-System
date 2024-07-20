<?php
if (!isset($_SESSION)) {
    session_start();
}
echo '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Login to SIS</title>
</head>

<body>
    <section class="head" style="
">
        <div id="navbar">
            <div class="myLogo">
            ';

// echo '
// <div style="font-size: 55px;"><b style="color: #7430f9;">S</b><b style="color:#f7007c;">I</b><b style="color: #7430f9;">S</b></div>
// <div style="font-size: 13px;">
//     <div style="color: #7430f9;">Student</div>
//     <div style="color: #f7007c;">Information</div>
//     <div style="color: #7430f9;">System
// </div>
// ';




echo '
            <div style="font-size: 55px;">
                <b style="color: #7430f9;" data-text="S">S</b><b style="color:#f7007c;" data-text="I">I</b><b style="color: #7430f9;" data-text="S">S</b>
            </div>
            <div style="font-size: 13px;">
                <div data-text="Student" style="color: #7430f9;">Student</div>
                <div data-text="Information"  style="color: #f7007c;">Information</div>
                <div data-text="System" style="color: #7430f9;">System
            </div>
            ';
echo '
        </div>
            </div>
            <div>
                <ul class="headings">
                    <li><a href="../html/index.php">Home</a></li>
                    <li><a href="../html/services.php">Services</a></li>
                    <li><a href="../html/contact.php">Contact Us</a></li>
                </ul>
            </div>
            <div>';
if (isset($_SESSION['userName'])) {
    if (!isset($_SESSION)) {
        session_start();
    }
    if ($_SESSION['character'] == 'Student') {
        echo '<div class="d-flex"><b id="userNameEdit">Hii ' . $_SESSION['userName'] . '</b>';
        echo '<div>
        <form action="../html/handle_logout.php" method="post" style="display:flex;">
        <a href="../studentOperations/student_dashboard.php"  type="button" id="dashboard" class="btn" name="Dashboard" id="Dashboard">Dashboard</a>
        <button type="submit" class="btn" name="logout" onclick="return confirmLogout();" id="logout">logout</button>
        </form> </div> </div>';
    } elseif ($_SESSION['character'] == 'Admin') {
        echo '<div class="d-flex"><b id="userNameEdit">Hii ' . $_SESSION['userName'] . '</b>';
        echo '<div>
        <form action="../html/handle_logout.php" method="post" style="display:flex;">
        <a href="../Admin_Operations/admin_dashboard.php"  type="button" id="dashboard" class="btn" name="Dashboard" id="Dashboard">Dashboard</a>
        <button type="submit" class="btn" name="logout" onclick="return confirmLogout();" id="logout">logout</button>
        </form> </div> </div>';
    } elseif ($_SESSION['character'] == 'Teacher') {
        echo '<div class="d-flex"><b id="userNameEdit">Hii ' . $_SESSION['userName'] . '</b>';
        echo '<div>
        <form action="../html/handle_logout.php" method="post"  style="display:flex;">
        <a href="../teacherOperations/teacherDashboard.php"  type="button" id="dashboard" class="btn" name="Dashboard" id="Dashboard">Dashboard</a>
        <button type="submit" class="btn" name="logout" onclick="return confirmLogout();" id="logout">logout</button>
        </form> </div> </div>';
    }
} else {
    echo '
                <button type="button" onclick="location.href=\'../html/signup.php\';" class="btn">Signup</button>
                <button onclick="location.href=\'../html/login.php\'" type="button" class="btn">logIn</button>';
}

echo '</div>
        </div>
    </section>
';
?>
<script>
    function confirmLogout() {
        return confirm('Are you sure you want to Logout?');
    }
</script>