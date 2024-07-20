<?php
$isNotTeacher = true;
$passMatch = true;
$alreadyExist = false;
$signup = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['whoIs'] == 'Student') {
        require "../PHP/_dbConnect.php";
        $eId = $_POST['enroll'];
        $uName = $_POST['userName'];
        $pass = $_POST['password'];
        $cPass = $_POST['cPassword'];
        $email = $_POST['email'];
        $isStudent = "select * from std_details where std_id='$eId'";
        $signup = false;
        $result = mysqli_query($conn, $isStudent);
        $row = mysqli_num_rows($result);
        if ($row != 0) {
            $isStudent = false;
            $existId = "select * from student where std_id='$eId'";
            $result = mysqli_query($conn, $existId);
            $row = mysqli_num_rows($result);
            if ($row > 0) {
                $alreadyExist = true;
            } else {
                if ($pass == $cPass) {
                    require '../PHP/_dbConnect.php';
                    $sql = "INSERT INTO `student` (`std_id`, `std_name`, `std_password`,  `std_email`, `time_of_joining`) VALUES ('$eId', '$uName','$pass',  '$email', current_timestamp())";
                    $result = mysqli_query($conn, $sql);
                    $signup = true;
                    $isStudent = true;
                } else {
                    $passMatch = false;
                }
            }
        } else {
            $isStudent = false;
        }
    } elseif ($_POST['whoIs'] == 'Teacher') {
        $isStudent = true;
        $passMatch = true;
        $alreadyExist = false;
        $isNotTeacher = true;
        require "../PHP/_dbConnect.php";
        $eId = $_POST['enroll'];
        $uName = $_POST['userName'];
        $pass = $_POST['password'];
        $cPass = $_POST['cPassword'];
        $email = $_POST['email'];
        $sql = "select * from teacher_details where t_id='$eId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($result);
        if ($row != 0) {
            $isNotTeacher = false;
            $existId = "select * from teacher where t_id='$eId'";
            $result = mysqli_query($conn, $existId);
            $row = mysqli_num_rows($result);
            if ($row > 0) {
                $alreadyExist = true;
            } else {
                if ($pass == $cPass) {
                    require '../PHP/_dbConnect.php';
                    $sql = "INSERT INTO `teacher` (`t_name`, `t_id`, `t_password`,  `t_email`, `time_of_joining`) VALUES ('$uName', '$eId','$pass',  '$email', current_timestamp())";
                    $result = mysqli_query($conn, $sql);
                    $signup = true;
                } else {
                    $passMatch = false;
                }
            }
        } else {
            $isNotTeacher = true;
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
    <title>SignUp - To SiS </title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>

<body>
    <?php
    require '../PHP/_header.php';
    ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        // If the password is not matching then throwing an error.
        if (!$passMatch) {
            echo '<div class="alert">
           <B> &#9888; </B> Warning! Enter the same passwords try again.
            <span>
                <button id="dismisible">X</button>
            </span>
        </div>';
        } elseif ($alreadyExist) {
            echo '<div class="alert Error";>
           <B> &#x2718; </B> Error! Account has already been created for this EnrollMent No. you can logIn.
            <span>
                <button id="dismisible">&#x2716;</button>
            </span>
        </div>';
        } elseif ($signup) {
            echo '<div class="alert success";>
           Success! You can login now!
             <span>
                 <button id="dismisible">&#x2716;</button>
             </span>
         </div>';
        } else {

            if ($_POST['whoIs'] == 'Student') {
                if ($isStudent == false) {
                    echo '<div class="alert Error";>
                <B> &#x2718; </B> Error! No Records Match For This Student Enrollment Number. Contact to the Teacher.
                    <span>
                        <button id="dismisible">&#x2716;</button>
                    </span>
                </div>';
                }
            } elseif ($_POST['whoIs'] == 'Teacher') {
                if ($isNotTeacher) {
                    echo '<div class="alert Error";>
                <B> &#x2718; </B> Error! No Records Match For This Teacher Id. Contact to an Admin.
                 <span>
                     <button id="dismisible">&#x2716;</button>
                 </span>
             </div>';
                }
            }
        }
    }



    ?>
    <div class="d-flex-main" style="min-height:100vh;">
        <div id="loginForm" style="min-width:25%;margin: 20px auto;height: fit-content; ">
            <h1>SignUp Form</h1>
            <form action="" method="post">
                <div>
                    <input required type="text" name="enroll" id="enrollId" placeholder="Enter Your Enrollment Id">
                </div>
                <div>
                    <input required type="email" name="email" id="email" placeholder="Enter Your Email ID">
                </div>
                <div>
                    <input required type="text" name="userName" id="userName" placeholder="Enter Your UserName">
                </div>
                <div><input required type="password" name="password" id="password" placeholder="Enter Your Password">
                </div>
                <div><input required type="password" name="cPassword" id="cPassword" placeholder="Re-Enter Your Password">
                </div>
                <div>
                    <label for="whoIs">Choose Character<select name="whoIs" id="whoIs">
                            <option value="Student" selected>Student</option>
                            <option value="Teacher">Teacher</option>
                        </select>
                    </label>
                </div>

                <div>
                    <button type="submit" class="loginSignButton">Sign Up</button>
                </div>
                <div style="margin:auto; text-align:center">
                    Already have an account? <a style="color:#f7009c;text-decoration:none;padding: 5px;" href="login.php">Login now</a>

                </div>
            </form>

        </div>
    </div>

    <?php
    require '../PHP/_footer.php';
    ?>
</body>
<script>
    document.body.title = 'SignUp.php';
    try {
        dismisible = document.getElementById('dismisible');
        dismisible.addEventListener("click", () => {
            document.getElementsByClassName('alert')[0].style.display = "none";
        })
    } catch {

    }
</script>

</html>