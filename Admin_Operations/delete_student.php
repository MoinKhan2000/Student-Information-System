<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Admin') {
    $findStudent = false;
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

        }
    }
    require './admin_headers.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['searchEnroll'])) {
            $findStudent = true;
        }
    }
    if (isset($_GET['deleteStudent'])) {
        require '../PHP/_dbConnect.php';
        $sql = "delete from std_details where std_id=" . $_GET['deleteStudent'] . "";
        // echo $sql;       
        $result = mysqli_query($conn, $sql);
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
                    </form>
                </fieldset>
            </div>
            <div id="bottom">
                <?php
                if ($findStudent) {
                    $enrollId = $_POST['searchEnroll'];
                    require '../PHP/_dbConnect.php';
                    $sql = "select * from std_details where std_id='$enrollId'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_num_rows($result);
                    if ($row == 1) {

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "
                            <fieldset id='bottomFieldset' style='padding-top:10px; width:60%' class='d-block'>
                            <legend>
                            <h2>&nbsp;Student Details &nbsp; </h2>
                        </legend>
                            <div id='bottom'>
                            <div>
                            <form action='' method='get'>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th> EnrollMent No </th>
                                                <td>" . $row['std_id'] . " </td>
                                            </tr>
                                            <tr>
                                                <th> Name </th>
                                                <td>" . $row['std_name'] . " </td>
                                            </tr>
                                            <tr>
                                                <th> Father Name </th>
                                                <td>" . $row['std_f_name'] . " </td>
                                            </tr>
                                            <tr>
                                                <th> Mother Name </th>
                                                <td>" . $row['std_m_name'] . " </td>
                                            </tr>
                                            <tr>
                                                <th>Persuing Year </th>
                                                <td>" . $row['std_year'] . " </td>
                                            </tr>
                                            <tr>
                                                <th>Current Sem </th>
                                                <td>" . $row['std_sem'] . " </td>
                                            </tr>
                                            <tr>
                                                <th> Branch </th>
                                                <td>" . $row['std_branch'] . " </td>
                                            </tr>
                                            <tr>
                                                <th> Mobile Number </th>
                                                <td>" . $row['std_mobile_no'] . " </td>
                                            </tr>
                                            <tr>
                                                <th>Father's Mobile Number </th>
                                                <td>" . $row['std_father_mobile_no'] . " </td>
                                            </tr>
                                            <tr>
                                                <th>College Name </th>
                                                <td>" . $row['std_college_name'] . " </td>
                                            </tr>
                                            <tr>
                                                <th>Admission Year </th>
                                                <td>" . $row['std_admission_year'] . " </td>
                                            </tr>
                                            
                                        </tbody>
                                        
                                    </table>
                                
                            </div>
                        </div>
                        <button type='submit' onclick='return checkDelete()'  id='deleteStudent' value=" . $row['std_id'] . " name='deleteStudent' class='btn2 btn3'> Delete Student</button>
                        </form>
                        
                        ";
                        }
                ?>


                        </fieldset><?php
                                } else {
                                    echo '<h2 class="d-block"> NO RECORD FOUND FOR THIS ENROLLMENT NO - ' . $_POST['searchEnroll'] . '</h2>';
                                    $showAgain = true;
                                }
                            }

                                    ?>
                <div class="d-flex" style="height:50vh;" >

                    <div id="loginForm" style="border:none">
                        <fieldset>
                            <legend>
                                <h3 style="color:black">Search To Delete Student</h3>
                            </legend>
                            <form action="" method="post">
                                <label for="searchEnroll">Enter EnrollMent Id</label><input type="text" required name="searchEnroll" id="searchEnroll">
                                <div>
                                    <input id="searchStd" type="submit" class="btn button" value="Search">
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    <?php
    require '../PHP/_footer.php';
}
    ?>

    <script>
        function checkDelete() {
            return confirm('Are you sure you want to delete this student?');
        }
    </script>