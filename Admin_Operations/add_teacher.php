<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Admin') {
    $added = false;
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
            header("Location:./delete_teacher.php");
            $deleteTeacher = true;
        } elseif (isset($_POST['editTeacher'])) {
            header("Location:./edit_teacher.php");
            $editTeacher = true;
        }
    }
    require './admin_headers.php';

    $alreadyExists = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $added = false;
        $tId = $_POST['tId'];
        $tName = $_POST['tName'];
        $fName = $_POST['fName'];
        $tEmail = $_POST['tEmail'];
        $tMobile = $_POST['tMobile'];
        $tBranch = $_POST['tBranch'];
        $collegeName = $_POST['collegeName'];
        $tSalary = $_POST['tSalary'];
        $tQualification = $_POST['tQualification'];
        $dateOfJoining = $_POST['dateOfJoining'];
        // $image=$_POST['image']; 
        $files = $_FILES['image'];
        // echo $tName;
        // echo '<br>';
        // print_r($files);

        $fileName = $files['name'];
        $fileError = $files['error'];
        $fileTemp = $files['tmp_name'];

        // print $fileName;
        // print "<br>";
        // print$fileTemp;
        // print("<br>   ");
        $fileExtension = explode('.', $fileName);
        $fileExtensionCheck = strtolower(end($fileExtension));
        // echo end($fileExtension);
        // print_r($fileExtension);

        // if the t_id is already assigned to another teacher than throwing an error
        require '../PHP/_dbConnect.php';
        $sql = "select * from teacher_details where t_id=" . $tId;
        $result = mysqli_query($conn, $sql);
        $row = mysqli_num_rows($result);
        if ($row > 0) {
            $alreadyExists = true;
        } else {
            $fileExtensionStored = array('png', 'jpeg', 'jpg');
            if (in_array($fileExtensionCheck, $fileExtensionStored)) {
                $destinationFile = '../upload/' . $fileName;
                move_uploaded_file($fileTemp, $destinationFile);
                $sql = "INSERT INTO `teacher_details` (`t_id`, `t_name`, `t_father_name`, `t_mobile`, `t_email`, `t_dept`, `t_salary`, `t_qualification`, `t_college_name`, `t_date_of_joining`, `t_image`) VALUES ('$tId', '$tName', '$fName', '$tMobile', '$tEmail', '$tBranch', '$tSalary', '$tQualification', '$collegeName', '$dateOfJoining', '$destinationFile')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $added = true;
                }
            }
        }
    }
?>
    <?php
    if ($added) {

        echo '<div class="alert" style="background-color: #e17fbe;">
       <B> &#x2713; </B> Success! Student Added Successfully.
        <span>
            <button id="dismisible" style="background-color:#e17fbz"">X</button>
        </span>
    </div>';
    } elseif ($alreadyExists) {
        echo '<div class="alert error" style="background-color:#ff6262;">
       <B> &#x2718; </B> Warning! This Teacher Id Already Exists.
        <span>
            <button id="dismisible">&#x2716;</button>
        </span>
    </div>';
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
                        <button type="submit" name="addTeacher" class="btn2">Add Teacher</button>
                        <button type="submit" name="deleteTeacher" class="btn2">Delete Teacher</button>
                        <button type="submit" name="editTeacher" class="btn2">Edit Teacher Details</button>
                    </form>
                </fieldset>
            </div>
            <div id="bottom">
                <form action="" method="post" enctype="multipart/form-data">
                    <fieldset id="bottomFieldset" style="width:60%">
                        <legend>
                            <h2>&nbsp;Fill the form to Add Teacher &nbsp; </h2>
                        </legend>
                        <table id="tableForAdd">
                            <tr>
                                <th>Teacher Id</th>
                                <td> <input required type="text" maxlength="12" name="tId" id="tId"></td>
                            </tr>
                            <tr>
                                <th>Teacher Name</th>
                                <td> <input required type="text" name="tName" id="tName"></td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td> <input required type="text" name="fName" id="fName"></td>
                            </tr>
                            <tr>
                                <th>Mobile No</th>
                                <td> <input type="number" required name="tMobile" id="tMobile"></td>
                            </tr>
                            <tr>
                                <th>Email Id</th>
                                <td> <input type="email" required name="tEmail" id="tEmail"></td>
                            </tr>
                            <!-- <tr>
                                <th>Persuing Year</th>
                                <td> <select name="pYear" id="pYear">
                                        <?php
                                        $i = 1;
                                        while ($i <= 4) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                            $i++;
                                        }
                                        ?>
                                    </select>

                                </td>
                            </tr> -->
                            <!-- <tr>
                                <th>Persuing Semester</th>
                                <td><select name="pSemester" id="pSemester">
                                        <?php
                                        $i = 1;
                                        while ($i <= 8) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                            $i++;
                                        }
                                        ?>
                                    </select></td>
                            </tr> -->
                            <tr>
                                <th>Teacher Department</th>
                                <td> <select name="tBranch" id="tBranch">
                                        <?php
                                        $i = 0;
                                        $arr = ['Computer Science Engineering', 'Artificial Intellegence', 'Electronics and Communication', 'Electrical Engineering', 'Civil Engineering'];
                                        while ($i < sizeof($arr)) {
                                            echo '<option value="' . $arr[$i] . '">' . $arr[$i] . '</option>';
                                            $i++;
                                        }
                                        ?>
                                    </select>
                            </tr>

                            <tr>
                                <th>Teacher Salary (&#x20B9;).</th>
                                <td> <input type="number" required name="tSalary" id="tSalary"></td>
                            </tr>
                            <tr>
                                <th>Qualifications.</th>
                                <td>
                                    <textarea required name="tQualification" id="tQualification" cols="30" rows="4"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>College Name</th>
                                <td>
                                    <textarea required name="collegeName" id="collegeName" cols="30" rows="4"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Date Of Joining</th>
                                <td>
                                    <input type="date" name="dateOfJoining" id="dateOfJoining">

                                </td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td><input type="file" name="image" id="image"></td>
                            </tr>
                        </table>
                        <button type="submit" id="addTeacher" class="btn2 btn3"> Submit Details</button>
                    </fieldset>
                </form>
            </div>

        </div>



    <?php
    require '../PHP/_footer.php';
}
    ?>
    <script>
        try {
            dismisible = document.getElementById('dismisible');
            dismisible.addEventListener("click", () => {
                document.getElementsByClassName('alert')[0].style.display = "none";
            })
        } catch {

        }
        collegeName.innerText = 'Shri Balaji Institute Of Technology And Management Betul(M.P)';
    </script>