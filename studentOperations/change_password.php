<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {
    require '../PHP/_header.php';
    require './student_buttons.php';
    $student_id = $_SESSION['enrollId'];
    $passNotMatch = false;
    $incorrectPassowrd = false;
    $changedSuccess = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['submit'])) {
            require '../PHP/_dbConnect.php';
            $oldPassword = $_POST['oldPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];
            if ($newPassword == $confirmNewPassword) {
                $sql = "select std_password from student where std_id='" . $_SESSION['enrollId'] . "'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $password = $row['std_password'];
                if ($password == $oldPassword) {
                    $newPassword = sha1($newPassword);
                    $sql = "UPDATE `student` SET `std_password` = '" . $newPassword . "' WHERE `student`.`std_id` = '" . $_SESSION['enrollId'] . "';";
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
            <?php
            echo getButtons();
            ?>
        </div>


    </div>

    <div id="right_viewDetails">

        <div id="bottom">
            <div class="d-flex" style="height:97vh;width: 100%; ">
                <div id="loginForm" style="width:auto; padding:20px;">
                    <h1 style="width:100%;color:white; border:none;">Change Password</h1>
                    <form action="" method="post">
                        <label for="oldPassword"> Old Password?</label><input type="password" required name="oldPassword" id="oldPassword">
                        <label for="newPassword"> New Password?</label><input type="password" required name="newPassword" id="newPassword">
                        <label style="width:101%" for="confirmNewPassword"> Re-enter New Password?</label><input type="password" required name="confirmNewPassword" id="confirmNewPassword">

                        <div>
                            <button type="submit" class="loginSignButton" name="submit" name="submit">Change Password</button>


                            <!-- <input  type="submit"  class="btn3" value="Change Password"> -->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    require('../PHP/_footer.php')
    ?>
<?php
} else {
    header("location:../HTML/index.php");
}
?>

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