<?php
require './student_related.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['seeStudent'])) {
        header("Location:./find_student.php");
    } elseif (isset($_POST['allStudents'])) {
        header("Location:./all_student.php");
    } elseif (isset($_POST['addStudent'])) {
    } elseif (isset($_POST['deleteStudent'])) {
    } elseif (isset($_POST['editStudent'])) {
    }
}

                    echo '<fieldset id="bottomFieldset">
                    <legend>
                        <h2>Available Students</h2>
                    </legend>
                    <table>
                        <tbody>
                            <tr>
                                <th>EnrollMent Id</th>
                                <th>Student Name</th>
                                <th>Current Year</th>
                                <th>Current Semester</th>
                                <th>Branch</th>
                                <th>Mobile No.</th>
                                <th>Father Mobile No.</th>
                                <th>View More Details</th>
                            </tr>';


                    require '../PHP/_dbConnect.php';
                    $sql = "select * from std_details";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo " <tr>
                                    <td>" . $row['std_id'] . "</td>
                                    <td>" . $row['std_name'] . "</td>
                                    <td>" . $row['std_year'] . "</td>
                                    <td>" . $row['std_sem'] . "</td>
                                    <td>" . $row['std_branch'] . "</td>
                                    <td>" . $row['std_mobile_no'] . "</td>
                                    <td>" . $row['std_father_mobile_no'] . "</td>
                                    </tr>";
                    }

                    // <!-- <td>".$row['']."</td> -->
                    echo '</tbody></table></fieldset></div>';
