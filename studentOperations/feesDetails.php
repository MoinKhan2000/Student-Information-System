<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {
    // Getting the header file and the Buttons (Actions (get/post))
    require '../PHP/_header.php';
    require './student_buttons.php';
    $student_id = $_SESSION['enrollId'];
?>
    <div id="main_viewDetails">
        <div id="left_viewDetails">

            <?php
            // Getting all the buttons
            echo getButtons();
            ?>
        </div>


    </div>
    <div id="right_viewDetails">
        <div id="right_viewDetails">

            <div id="bottom">
                <fieldset id="bottomFieldset" style="width:65vw">
                    <legend>
                        <h2>Your Fees Details</h2>
                    </legend>

                    <table>

                        <thead>
                        <tbody>



                            <?php
                            // Making a table for the representation at the student side
                            echo '<tr>
                                <th>Entry No.</th>
                                <th>Total Fees </th>
                                <th>Paid Amount </th>
                                <th>Remaining Fees</th>
                                <th>Approved By</th>
                                <th>Submission Date</th>
                            </tr>';

                            // Establishing the connection from the php folder 
                            require '../PHP/_dbConnect.php';

                            // Fetching all the records from the database for the particular student
                            $sql = "select * from student_fees where std_id='" . $student_id . "'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_num_rows($result);
                            $num = 1;
                            $row = mysqli_fetch_assoc($result);

                            // If there is more than one row then fethcing all the rows and presenting it to the student
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sql2 = "SELECT t_name FROM `teacher_details` WHERE t_id=" . $row['teacher_id'] . "";
                                $result2 = mysqli_query($conn, $sql2);
                                $row2 = mysqli_fetch_assoc($result2);
                                $t_name = $row2['t_name'];
                                // if ($row['isCompleted'] == '1') {
                                //     break;
                                // }
                                echo " <tr>
                                <td>" . $num . "</td>
                                <td>" . $row['total_fees'] . "</td>
                                <td>" . $row['amount_paid'] . "</td>
                                <td>" . $row['remaining_fees'] . "</td>
                                <td>" . $t_name . "</td>
                                <td>" . $row['time_of_submission'] . " </td>
                                </tr>";
                                $num++;
                            }


                            ?>
                        </tbody>

                        </thead>
                    </table>
                </fieldset>
            </div>
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
    // Redirecting the user if not valid to the login page
    header("location:../HTML/index.php");
}
