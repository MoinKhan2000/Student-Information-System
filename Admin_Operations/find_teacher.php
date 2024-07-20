<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Admin') {
    $searchTeacher = false;
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
            header("Location:./delete_teacher.php");
            $deleteTeacher = true;
        } elseif (isset($_POST['editTeacher'])) {
            header("Location:./edit_teacher.php");
            $editTeacher = true;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['searchT'])) {
            $searchTeacher = true;
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
                <?php
                if ($searchTeacher) {
                    require '../PHP/_dbConnect.php';
                    $eId = $_POST['searchT'];
                    // echo $eId;
                    $sql = "select * from teacher_details where t_id='$eId'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_num_rows($result);
                    if ($row == 1) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo ' 
                        <fieldset id="bottomFieldset" style="width:80%">
                            <legend>
                                <h2>&nbsp;Teacher' . 's Details &nbsp; </h2>
                            </legend>
                            <table id="tableForAdd">
                              <center>  <img style="width:100px%;" src="' . $row['t_image'] . '" alt="Image"></center>
                                <tr>
                                    <th>Teacher Id</th>
                                    <td>' . $row['t_id'] . '</td>
                                </tr>
                                <tr>
                                    <th>Teacher Name</th>
                                    <td> ' . $row['t_name'] . '</td>
                                </tr>
                                <tr>
                                    <th>Father Name</th>
                                    <td>' . $row['t_father_name'] . ' </td>
                                </tr>
                                <tr>
                                    <th>Mobile No</th>
                                    <td> ' . $row['t_mobile'] . '</td>
                                </tr>
                                <tr>
                                    <th>Email Id</th>
                                    <td> ' . $row['t_email'] . '</td>
                                </tr>
                                <tr>
                                    <th>Teacher Department</th>
                                    <td>' . $row['t_dept'] . ' </td>
                                </tr>

                                <tr>
                                    <th>Teacher Salary (&#x20B9;).</th>
                                    <td>' . $row['t_salary'] . ' </td>
                                </tr>
                                <tr>
                                    <th>Qualifications.</th>
                                    <td>
                                    ' . $row['t_qualification'] . '
                                    </td>
                                </tr>
                                <tr>
                                    <th>College Name</th>
                                    <td>
                                    ' . $row['t_college_name'] . '
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date Of Joining</th>
                                    <td>
                                    ' . $row['t_date_of_joining'] . '
                                    </td>
                                </tr>
                               
                                    

                            </table>
                        </fieldset>';
                        }
                    }else{
                        echo '<h2 class="d-block"> NO RECORD FOUND FOR THIS ENROLLMENT NO - ' . $_POST['searchT'] . '</h2>';
                    }
                }
                ?>

                <div class="d-flex" style="height:50vh">

                    <div id="loginForm" style="border:none">
                        <fieldset>
                            <legend>
                                <h3 style="color:black">Search Teacher</h3>
                            </legend>
                            <form action="" method="post">
                                <label for="searchT">Enter Teacher Id</label><input type="text" required name="searchT" id="searchT">
                                <div>
                                    <input id="searchTeacher" type="submit" class="btn button" value="Search">
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>

            </div>
        </div>
    </div>


<?php
    require '../PHP/_footer.php';
}
?>

<!--// <input required type="text" maxlength="12" name="tId" id="tId"> -->
<!-- // <input required type="text" name="tName" id="tName">
// <input required type="text" name="fName" id="fName">
// <input type="number" required name="tMobile" id="tMobile">
// <input type="email" required name="tEmail" id="tEmail">
// <input type="number" required name="tSalary" id="tSalary">
// <textarea required name="tQualification" id="tQualification" cols="30" rows="4"></textarea>
// <textarea required name="collegeName" id="collegeName" cols="30" rows="4"></textarea>
<input type="date" name="dateOfJoining" id="dateOfJoining">

<img src="" alt="">

-->