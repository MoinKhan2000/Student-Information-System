<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header and the Action buttons.
    require '../PHP/_header.php';
    require './student_buttons.php';
?>
    <div id="main_viewDetails">
        <div id="left_viewDetails">
            <?php
            // Getting all the buttons.
            echo getButtons();
            ?>
        </div>


    </div>
    <div id="right_viewDetails">
        <h1>
            Hii <?php echo $_SESSION['userName']; ?>
        </h1>
        <?php
        // echo $_SESSION['userName'];
        $enrollId = $_SESSION['enrollId'];

        // Establishing the connection. 
        require '../PHP/_dbConnect.php';

        // Selecting the particular student from the database to show the details.
        $sql = "select * from std_details where std_id='$enrollId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($result);
        if ($row == 1) {
            // Showing all the details of the student in the tabular format.
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div>
            <fieldset id='bottomFieldset' style='width:65vw'>
                <legend>
                    <h2>Your Details </h2>
                </legend>
                <table>
                        
                    <tbody>
                    <tr>
                            <th>Image </th>
                            <td>
                            <img style='height:100px;' src='" . $row['image'] . "'alt='Image'>
                            </td>
                    <tr>
                    <tr>
                            <th> EnrollMent No </th>
                            <td>" . $row['std_id'] . " </td>
                        </tr>
                        <tr>
                            <th> Name </th>
                            <td>" . $row['std_name'] . "  </td>
                        </tr>
                        <tr>
                            <th> Father Name </th>
                            <td>" . $row['std_f_name'] . "  </td>
                        </tr>
                        <tr>
                            <th> Mother Name </th>
                            <td>" . $row['std_m_name'] . "  </td>
                        </tr>
                        <tr>
                            <th>Persuing Year </th>
                            <td>" . $row['std_year'] . "  </td>
                        </tr>
                        <tr>
                            <th>Current Sem </th>
                            <td>" . $row['std_sem'] . "  </td>
                        </tr>
                        <tr>
                            <th> Branch </th>
                            <td>" . $row['std_branch'] . "  </td>
                        </tr>
                        <tr>
                            <th> Mobile Number </th>
                            <td>" . $row['std_mobile_no'] . "  </td>
                        </tr>
                        <tr>
                            <th>Father's Mobile Number </th>
                            <td>" . $row['std_father_mobile_no'] . "  </td>
                        </tr>
                        <tr>
                            <th>College Name </th>
                            <td>" . $row['std_college_name'] . "  </td>
                        </tr>
                        <tr>
                            <th>Admission Year </th>
                            <td>" . $row['std_admission_year'] . "  </td>
                        </tr>

                    </tbody>
                </table>
            </fieldset>
        </div>
    </div>";
            }
        } else {
            echo '<h2 class="d-block"> Noting to show for now! Try after some time later</h2>';
        }

        ?>


    </div>


    <?php
    require('../PHP/_footer.php')
    ?>
<?php
} else {
    header("location:../HTML/index.php");
}
