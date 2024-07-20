<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {

    require '../PHP/_header.php';
    require './teacher_buttons.php';
    $passNotMatch = false;
    $incorrectPassowrd = false;
    $changedSuccess = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['findTeacher'])) {
            header("Location:./find_teacher.php");
            $findTeacher = true;
        } elseif (isset($_POST['allTeachers'])) {
            header("Location:./all_teachers.php");
            $allTeachrs = true;
        } elseif (isset($_POST['editDetails'])) {
            header("Location:./editDetails.php");
            $editDetails = true;
        } elseif (isset($_POST['changePassword'])) {
            header("Location:./change_password.php");
        }

        if (isset($_POST['submit'])) {
            require '../PHP/_dbConnect.php';
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];
            if ($newPassword == $confirmNewPassword) {
                $sql = "select t_password from teacher where t_id='" . $_SESSION['enrollId'] . "'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $password = $row['t_password'];
                if ($password == $oldPassword) {
                    $newPassword = sha1($newPassword);
                    $sql = "UPDATE `teacher` SET `t_password` = '" . $newPassword . "' WHERE `teacher`.`t_id` = '" . $_SESSION['enrollId'] . "';";
                    $result = mysqli_query($conn, $sql);
                    $changedSuccess = true;
                } else {
                    $incorrectPassowrd = true;
                }
            } else {
                $passNotMatch = true;
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['std_related'])) {
            header("Location:./student_related.php");
            echo $_GET['std_related'];
        } elseif (isset($_GET['tchr_related'])) {
            header("Location:./teacher_related.php");
            echo $_GET['tchr_related'];
        } elseif (isset($_GET['others_related'])) {
            header("Location:./others.php");
        } elseif (isset($_GET['notice_related'])) {
            header("Location:./notices.php");
        } elseif (isset($_GET['chagePassword'])) {
            header("Location:./change_password.php");
        }
    }



?>
    <?php
    if ($passNotMatch) {
        echo '<div class="alert">
        <B> &#9888; </B> Warning! Enter the Same Passwords.
        <span>
            <button id="dismisible">X</button>
        </span>
    </div>';
    } elseif ($incorrectPassowrd) {
        echo '<div class="alert Error" ;>
    <B> &#x2718; </B> Error! Your Passwords Does Not Matches Enter Correct Passowrd.
        <span>
            <button id="dismisible">&#x2716;</button>
        </span>
    </div>';
    } elseif ($changedSuccess) {
        echo '<div class="alert success";>
           Success! Your Passwords Has Been Changed Successfully.
             <span>
                 <button id="dismisible">&#x2716;</button>
             </span>
         </div>';
    }
    ?>
    <div id="main_viewDetails">
        <div id="left_viewDetails">
            <FORM method="get" action="" enctype="multipart/form-data">
                <div class="items_viewDetails">
                    <button value="std_related" name="std_related" id="std_related">
                        <h2>Student Related</h2>
                    </button>

                </div>
                <div class="items_viewDetails">

                    <button value="tchr_related" name="tchr_related" id="tchr_related">
                        <h2>Teacher Related</h2>
                    </button>
                </div>
                <div class="items_viewDetails">
                    <button value="notice_related" name="notice_related" id="notice_related">
                        <h2>Add Notices</h2>
                    </button>
                </div>
                <div class="items_viewDetails">
                    <button value="others_related" name="others_related" id="others_related">
                        <h2>Others</h2>
                    </button>
                </div>
            </FORM>
        </div>
        <div id="right_viewDetails">
            <div id="top">
                <fieldset>
                    <form action="" method="post">
                        <button type="submit" id="findTeacher" name="findTeacher" class="btn2">Find Particular Teacher</button>
                        <button type="submit" name="allTeachers" class="btn2">All Teacher</button>
                        <button type="submit" name="editDetails" class="btn2">Edit Your Details</button>
                        <button type="submit" name="changePassword" class="btn2">Change Your Password</button>

                    </form>
                </fieldset>
            </div>
            <div id="bottom_form">
                <div class="d-flex" style="height: 100vh;width: 100%;">
                    <div id="loginForm" style="width:auto; padding:20px;">
                        <h1 style="width:100%; color:white; border:none;">Change Password</h1>
                        <form action="" method="post">
                            <label for="oldPassword"> Old Password?</label><input type="password" required name="oldPassword" id="oldPassword">
                            <label for="newPassword"> New Password?</label><input type="password" required name="newPassword" id="newPassword">
                            <label style="width:101%" for="confirmNewPassword"> Re-enter New Password?</label><input type="password" required name="confirmNewPassword" id="confirmNewPassword">

                            <div>
                                <button type="submit" class="loginSignButton" name="submit" >Change Password</button>
                                <!-- <input type="submit"  class="btn3" > -->
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>



    <?php
    require '../PHP/_footer.php';
}
    ?>
    <script>
        try {
            dismisible = document.getElementById('dismisible');
            dismisible.addEventListener("click", () => {
                document.getElementsByClassName('alert')[0].style.display = "none";
            })
        } catch {

        }
    </script>