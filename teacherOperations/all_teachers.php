<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $allStudents = false;
    $seeStudent = false;
    require '../PHP/_header.php';
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
                        <button type="submit" id="findTeacher" name="findTeacher" class="btn2">Find Particular Teacher</button>
                        <button type="submit" name="allTeachers" class="btn2">All Teacher</button>
                        <button type="submit" name="editDetails" class="btn2">Edit Your Details</button>
                        <button type="submit" name="changePassword" class="btn2">Change Your Password</button>

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
                            <tr id="headingTr">
                                <th>Sr No.</th>
                                <th>Teacher Id</th>
                                <th>Teacher Name</th>
                                <th>Department</th>
                                <th>Salary</th>
                                <th>Mobile No.</th>
                                <th>Date Of Joining</th>
                                <th>View More</th>
                            </tr>

                            <?php
                            require '../PHP/_dbConnect.php';
                            $sql = "select * from teacher_details where  not t_id='' ";
                            $result = mysqli_query($conn, $sql);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                                <tr>
                                <form action='./find_teacher.php' method='post'>
                                <td style='font-weight:bold'>" . $i . "</td>
                                <td>" . $row['t_id'] . "</td>
                                <td>" . $row['t_name'] . "</td>
                                <td>" . $row['t_dept'] . "</td>
                                <td>" . $row['t_salary'] . "</td>
                                <td>" . $row['t_mobile'] . "</td>
                                <td>" . $row['t_date_of_joining'] . "</td>
                                <input type='hidden' name='searchT' value=" . $row['t_id'] . ">
                                <td><button type='hidden'  class='btn' >View</button></td> 
                                </form>
                                </tr> ";
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