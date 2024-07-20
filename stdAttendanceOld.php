<?php
require '../PHP/_dbConnect.php';

// Checking for the database is created or not for this year if not then create.
$databaseCreated = true;
$year = date("Y");
$year = 2021;
$sqlForDatabase = "SHOW DATABASES LIKE 'sis_attendance_" . $year . "'";
$result = mysqli_query($conn, $sqlForDatabase);
$row = mysqli_num_rows($result);
// echo 'Database exists  = ';
// echo $row;
// echo '<br>';
if ($row == 0) {
    $sql = 'CREATE DATABASE sis_attendance_' . $year . '';
    $result = mysqli_query($conn, $sql);
    $database = 'sis_attendance_' . $year . '';
    $conn = mysqli_connect($servername, $username, $password, $database);
}

// Cheking for the table is created or not for this month if not then create.
$month = date("F");
$sql = 'SHOW TABLES FROM `sis_attendance_' . $year . '` LIKE "' . $month . '"';
// echo '<br>';
// echo $sql;
$result = mysqli_query($conn, $sql);
// echo '<br>';
$row = mysqli_num_rows($result);
// echo 'Table exists or not = ';
// echo $row;
// echo '<br>';
if ($row == 0) {
    // echo 'Table does not exists';
    // echo '<br>';
    $month = date("F");
    $database = 'sis_attendance_' . $year . '';
    $conn = mysqli_connect($servername, $username, $password, $database);
    $createTable = "create table  $month  (`s_id` VARCHAR(12) NOT NULL , `s_name` VARCHAR(20) NOT NULL ,`scenario` CHAR(1) NOT NULL DEFAULT 'A' ) ";
    // echo $createTable;
    $result = mysqli_query($conn, $createTable);
}

// Cheking for today's entry if the column is not created for today then create

$database = 'sis_attendance_' . $year . '';
$conn = mysqli_connect($servername, $username, $password, $database);
$month = date("F");
$date = date("j");
$sql = 'SHOW columns FROM ' . $month . '  LIKE "' . $date . '"';
// echo '<br>' . $sql . '<br>';
$result = mysqli_query($conn, $sql);
$row = mysqli_num_rows($result);
if ($row == 0) {
    $sql = "ALTER TABLE $month ADD `$date` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP ";
    // echo $sql . '<br>';
    // echo 'Column Creted' . '<br>';
    $result = mysqli_query($conn, $sql);
} else {
    // echo 'Column exists = ' . $row;
}


?>
<?php



if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $allStudents = false;
    $seeStudent = false;
    require '../PHP/_header.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['findStudent'])) {
            header("Location:./find_student.php");
        } elseif (isset($_POST['allStudents'])) {
            header("Location:./all_student.php");
        } elseif (isset($_POST['addStudent'])) {
            header("Location:./add_student.php");
        } elseif (isset($_POST['deleteStudent'])) {
            header("Location:./delete_student.php");
        } elseif (isset($_POST['editStudent'])) {
            header("Location:./edit_student.php");
        } elseif (isset($_POST['viewAttendance'])) {
            header("Location:./std_attendance.php");
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
            echo $_GET['others_related'];
        } elseif (isset($_GET['notice_related'])) {
            echo $_GET['notice_related'];
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
            <div id="top">
                <fieldset>
                    <form action="" method="post">
                        <button type="submit" id="findStudent" name="findStudent" class="btn2">Find Particular Student</button>
                        <button type="submit" name="allStudents" class="btn2">All Students</button>
                        <button type="submit" name="addStudent" class="btn2">Add Student</button>
                        <button type="submit" name="deleteStudent" class="btn2">Delete Student</button>
                        <button type="submit" name="editStudent" class="btn2">Edit Student Details</button>
                        <button type="submit" name="viewAttendance" class="btn2">Attendance</button>
                    </form>
                </fieldset>
            </div>
            <div id="bottom">
                <fieldset id="bottomFieldset" style="width: 90%;">
                    <legend>
                        <h2>&nbsp; Available Students &nbsp;</h2>
                    </legend>
                    <table>
                        <tbody>
                            <tr>
                                <th>Sr No.</th>
                                <th>Student Id</th>
                                <th>Student Name</th>
                                <th>Date</th>
                            </tr>

                            <?php
                            require '../PHP/_dbConnect.php';
                            $sql = "select * from teacher_details where  not t_id='' ";
                            $result = mysqli_query($conn, $sql);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                                <form action='./find_teacher.php' method='post'>
                                <tr>
                                <td style='font-weight:bold'>" . $i . "</td>
                                <td>" . $row['t_id'] . "</td>
                                <td>" . $row['t_name'] . "</td>
                                <td>" . $row['t_dept'] . "</td>
                                <td>" . $row['t_salary'] . "</td>
                                <td>" . $row['t_mobile'] . "</td>
                                <td>" . $row['t_date_of_joining'] . "</td>
                                <input type='hidden' name='searchT' value=" . $row['t_id'] . ">
                                <td><button type='hidden'  class='btn' >View</button></td> 
                                </tr> 
                            </form>";
                                $i++;
                            }

                            ?>
                        </tbody>
                    </table>
                </fieldset>
            </div>

        </div>

    </div>



<?php
    require '../PHP/_footer.php';
}
?>