<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $allStudents = false;
    $seeStudent = false;
    require '../PHP/_header.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require './teacher_buttons.php';
        if (isset($_POST['updateAttendance'])) {

            // Creating a table to insert todays date if already created then no.
            require_once '../PHP/_dbConnect.php';
            $currentDate = date("j/n/Y");
            $checkForTodayDate = "SHOW COLUMNS FROM sis.attendance like '$currentDate'";
            $resultForTodayDate = mysqli_query($conn, $checkForTodayDate);
            $row = mysqli_num_rows($resultForTodayDate);
            // If the column is not created then creating the column.
            if ($row == 0) {
                $sql = "ALTER TABLE `attendance` ADD `$currentDate` CHAR(1)  DEFAULT 'A'";
                print $sql;
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo $sql;
                    // echo 'Table created successfully';
                } else {
                    die("Error");
                    echo $sql;
                }
            }
            $i = 1;
            while ($i < $_POST['numberOfStudent']) {
                // Looping from 1 till  numbeOfStudent.
                $id = $_POST['student' . $i . ''];
                $case = $_POST['case' . $i . ''];

                // Updating the record for each student 
                $sql = "UPDATE `attendance` SET `$currentDate` = '$case' WHERE `attendance`.`student_id` = '$id'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                } else {
                    die("Error");
                }
                $i++;
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
            echo $_GET['notice_related'];
            header("Location:./notices.php");
        }
    }
?>
    <div id="main_viewDetails">
        <div id="left_viewDetails">
            <FORM method="get" action="">
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
            <?php
            require_once './student_related_func.php';
            echo top();
            ?>
            <div id="bottom">


                <?php
                //    Getting the Connection file 
                require_once '../PHP/_dbConnect.php';
                ?>
                <?php
                echo "<form action='' method='post'>";
                ?>
                <fieldset id="bottomFieldset" style="width: 90%;">
                    <legend>
                        <h2>Today's Attendance :
                            <?php
                            $date = date("j/n/Y");
                            echo $date;
                            echo date(" l ");
                            ?>
                        </h2>
                    </legend>
                    <table>
                        <?php
                        $isNotToUpdate = false;
                        require '../PHP/_dbConnect.php';
                        $sql = "select * from attendance where not student_id='' ORDER BY student_name";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        $date = date("j/n/Y");

                        // Fetching all the students for the attendance only when there is neither sunday nor saturdat
                        // echo date(" l ");
                        if (date("l") == 'Sunday' || date("l") == 'Saturday') {
                            echo '<h1 style="padding:40px;"> It\'s "' . date("l") . '" today and you cannot add today\'s attendance.Because It\'s Holiday today.';
                            $isNotToUpdate = true;
                        } else {
                            echo '<tbody>
                            <tr id="headingTr">
                                <th>
                                    Student Name
                                </th>
                                <th>
                                    Student Id
                                </th>
                                <th>
                                    Student Atd. Record
                                </th>
                                <th>
                                    Scenario
                                </th> 
                            </tr>';
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>" . $row['student_name'] . "</td>
                                        <td >" . $row['student_id'] . "</td>
                                        <td>
                                            <form action='./student_attendance.php' method='get'>
                                                <button type='submit' class='btn' name='student_id' value='" . $row['student_id'] . "' >View</button>
                                            </form>
                                        </td>";
                                echo "<input  type='hidden'  value='" . $row['student_id'] . "' name='student" . $i . "'><td>";
                                $currentDate = date("j/n/Y");
                                $checkForTodayDate = "SHOW COLUMNS FROM sis.attendance like '$currentDate'";
                                $resultForTodayDate = mysqli_query($conn, $checkForTodayDate);
                                $row2 = mysqli_num_rows($resultForTodayDate);
                                if ($row2 == 1) {
                                    $sql = "SELECT * FROM `attendance` where student_id='" . $row['student_id'] . "'";
                                    $resultForID = mysqli_query($conn, $sql);
                                    $row3 = mysqli_fetch_assoc($resultForID);
                                    echo '
                                <select name="case' . $i . '" id="case' . $i . '">
                                    <option selected value="' . $row3['' . $currentDate . ''] . '" style="background-color:white";>' . $row3['' . $currentDate . ''] . '</option>
                                    <option value="A" style="background-color:red"; value="A">Apsent</option>
                                    <option value="P" style="background-color:green"; value="A">Present</option>
                                    <option value="L" style="background-color:whitesmoke color:blueviolet"; value="A">Leave</option>
                                </select>
                                    </td>
                                </tr>';
                                } else {
                                    echo "
                                    <select name='case" . $i . "' id='case." . $i . "'>
                                        <option value='A' style='background-color:red' ; value='A'>Apsent</option>
                                        <option value='P' style='background-color:green' ; value='P'>Present</option>
                                        <option value='L' style='background-color:whitesmoke; color:blueviolet;' value='L'>Leave</option>
                                    </select>
                                    </td>
                                    
                                </tr>";
                                }
                                $i++;
                            }
                        }
                        ?>
                        </tbody>

                    </table>
                </fieldset>
                <?php
                if ($isNotToUpdate == false) {

                    echo "
                    <input type='hidden' value='" . $i . "' name='numberOfStudent'>
                        <button type='submit'  id='updateAttendance' name='updateAttendance'  onclick='return updateAttendanceRecord()' class='btn2 btn3'> Update Attendance
                        </button>
                            </form>";
                } else {
                    echo '';
                }
                ?>
            </div>

        </div>

    </div>

<?php
    require '../PHP/_footer.php';
} else {
    header("Location../HTML/login.php");
}
?>
<script>
    function updateAttendanceRecord() {
        return confirm('Are you sure you want to update this record ?');
    }
    try {
        dismisible = document.getElementById('dismisible');
        dismisible.addEventListener("click", () => {
            document.getElementsByClassName('alert')[0].style.display = "none";
        })
    } catch {

    }
    collegeName.innerText = 'Shri Balaji Institute Of Technology And Management Betul(M.P)';
</script>



<!-- SHOW COLUMNS FROM sis.attendance like '%/4/2023'; -->