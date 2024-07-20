<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Admin') {
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
        } elseif (isset($_POST['addTeacher'])) {
            header("Location:./add_teacher.php");
            $addTeacher = true;
        } elseif (isset($_POST['deleteTeacher'])) {
            // header("Location:./delete_teacher.php");
            $deleteTeacher = true;
        } elseif (isset($_POST['editTeacher'])) {
            // header("Location:./edit_teacher.php");
            $editTeacher = true;
        }
    }
    require './admin_headers.php';

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
                        <button type="submit" name="addTeacher" class="btn2">Add Teacher</button>
                        <button type="submit" name="deleteTeacher" class="btn2">Delete Teacher</button>
                        <button type="submit" name="editTeacher" class="btn2">Edit Teacher Details</button>
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