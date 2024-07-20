<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header as well as the Actions (get/post) from the folders
    require '../PHP/_header.php';
    require './student_buttons.php';
?>

    <body>

        <div id="main_viewDetails">
            <div id="left_viewDetails">

                <?php
                // Getting all the buttons
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
                    // Establishing the connectin to the database
                    require_once '../PHP/_dbConnect.php';

                    // Selecting all the notices from the notices table 
                    $sql = "select * from sis.notices where notice_id>0";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        // Fetching all the rows and represeting it to the student
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sql2 = "SELECT * FROM `sis`.`teacher_details` WHERE `t_id` = " . $row['teacher_id'] . "";
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            $teacherName = $row2['t_name'];
                            echo "<div class='noticesItems'>
                            <h3>" . $row['notice_title'] . "</h3>
                            <span>" . $row['notice_description'] . "</span>
                            <h4 style='position: relative;left:30%; color:#ff0080;'>By." . $teacherName . " <br>( ".$row['time_of_notice']." )</h4>
                        </div>";
                        }
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
    // Redirecting the user if not valid.
    header("Location:login.php");
}
?>
