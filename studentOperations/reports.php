<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header and the Actions buttons (post/get)
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
            <div id="bottom">
                <div class="d-flex" style="margin:auto;">

                    <fieldset id="bottomFieldset" style="width:70vw">
                        <legend>
                            <h2>Your Reports </h2>
                        </legend>
                        <form action="" method="post" enctype="multipart/form-data">
                            <table>
                                <thead>
                                    <?php

                                    echo "
                                            <tr>
                                                <th>Semester</th>
                                                <th>Report</th>
                                            </tr>
                                            
                                </thead>
                                <tbody>";
                                    $enrollId = $_SESSION['enrollId'];
                                    // Getting the connection 
                                    require '../PHP/_dbConnect.php';

                                    // Getting all teh reports for the particular student
                                    $sql = "select * from student_reports where std_id='" . $enrollId . "'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_num_rows($result);
                                    // $row = mysqli_fetch_assoc($result);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $i = 1;
                                        while ($i <= 8) {
                                            // Fetching for all the semesters
                                            echo " <tr>
                                                <td>" . $i . "</td>";
                                            if ($row[$i] == 'Not Available') {
                                                echo "<td style='padding:20px;'>NA</td>";
                                            } else {
                                                echo "<td style='padding:20px;'>
                                                    <a class='btn btn' href='" . $row[$i] . "' type='pdf' target='_blank'> View PDF<a>
                                                </td>";
                                            }

                                            $i++;
                                        }
                                    }
                                    ?>
                                    </tbody>
                            </table>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
        <section id="std_dash_footer" style="bottom: -70px;">
            Copyright &copy; 2022-23 SBITM. Developed by Moin Khan
        </section>
    </body>

    </html>


<?php
} else {
    header("Location:login.php");
}
?>

<script>
    document.body.title = 'Student Dashboard';
</script>