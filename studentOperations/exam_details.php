<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header and the buttons(Actions(post/get))
    require '../PHP/_header.php';
    require './student_buttons.php';
?>

    <body>

        <div id="main_viewDetails">
            <div id="left_viewDetails">
                <!-- Getting all the buttons -->
                <?php
                echo getButtons();
                ?>
            </div>


        </div>
        <div id="right_viewDetails">
            <table>
                <div id="top">
                </div>
                <div id="bottom">
                    <?php
                    // Getting the database Connection 
                    require_once '../PHP/_dbConnect.php';
                    // Selecting all the notices where The category is Exams
                    $sql = "SELECT * from notices where category='Exams';";
                    $result = mysqli_query($conn, $sql);
                    $count = 0;
                    if ($result) {
                        // Fetching all the notices and print on the user side
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sql2 = "SELECT * FROM `sis`.`teacher_details` WHERE `t_id` = " . $row['teacher_id'] . "";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            $teacherName = $row2['t_name'];
                            $count += 1;
                            echo "<div class='noticesItems'>
                            <h3>" . $row['notice_title'] . "</h3>
                            <span>" . $row['notice_description'] . "</span>
                            <h4 style='position: relative;left:30%;background-color:white; color:#ff0080;'>By." . $teacherName . " </h4>
                            <h5 style='position: relative;left:30%;background-color:white; color:#ff0080;'>Date." . $row['time_of_notice'] . " </h5>
                        </div>";
                        }
                    }
                    if ($count == 0) {
                        echo "There is nothing to preview.";
                    }
                    ?>


            </table>
        </div>
        <section id="std_dash_footer" style="top:100vh">
            Copyright &copy; 2022-23 SBITM. Developed by Moin Khan
        </section>
    </body>

    </html>


<?php
} else {
    // If the unautherised user is tryting to access this page then redirect to the login page
    header("Location:login.php");
}
?>

<script>
    document.body.title = 'Student Dashboard';
</script>