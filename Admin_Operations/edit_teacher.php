<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Admin') {
    $searchTeacher = false;
    $added=false;
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['searchT'])) {
            $searchTeacher = true;
        }
    }
    if (isset($_POST['editStudent'])) {
        $added = false;
        $tId = $_POST['tId'];
        $tName = $_POST['tName'];
        $fName = $_POST['fName'];
        $tEmail = $_POST['tEmail'];
        $tMobile = $_POST['tMobile'];
        $t_dept = $_POST['t_dept'];
        $collegeName = $_POST['collegeName'];
        $tSalary = $_POST['tSalary'];
        $tQualification = $_POST['tQualification'];
        $dateOfJoining = $_POST['dateOfJoining'];
        // $image=$_POST['image']; 
        $files = $_FILES['image'];
        // print_r($files);

        $fileName = $files['name'];
        $fileError = $files['error'];
        $fileTemp = $files['tmp_name'];
        // print_r($files);
        // echo $fileError;
        // exit;
        // print $fileName;
        // print "<br>";
        // print$fileTemp;
        // print("<br>   ");
        // echo end($fileExtension);
        // print_r($fileExtension);
        if ($fileError == 0) {

            $fileExtension = explode('.', $fileName);
            $fileExtensionCheck = strtolower(end($fileExtension));

            $fileExtensionStored = array('png', 'jpeg', 'jpg');
            if (in_array($fileExtensionCheck, $fileExtensionStored)) {
                require '../PHP/_dbConnect.php';
                $destinationFile = '../upload/' . $fileName;
                move_uploaded_file($fileTemp, $destinationFile);

                $sql = "UPDATE `teacher_details` SET `t_id`='$tId', `t_name`='$tName', `t_father_name`='$fName', `t_mobile`='$tMobile', `t_email`='$tEmail', `t_dept`='$t_dept', `t_salary`='$tSalary', `t_qualification`='$tQualification', `t_college_name`='$collegeName', `t_date_of_joining`='$dateOfJoining',`t_image`='$destinationFile' where `t_id`='$tId'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $added = true;
                }
            }
        } else {
            require '../PHP/_dbConnect.php';
            $sql = "UPDATE `teacher_details` SET `t_id`='$tId', `t_name`='$tName', `t_father_name`='$fName', `t_mobile`='$tMobile', `t_email`='$tEmail', `t_dept`='$t_dept', `t_salary`='$tSalary', `t_qualification`='$tQualification', `t_college_name`='$collegeName', `t_date_of_joining`='$dateOfJoining'  where `t_id`='$tId'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $added = true;
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
                    <form action="" method="post" enctype="multipart/form-data">
                        <fieldset id="bottomFieldset" style="width:80%">
                            <legend>
                                <h2>&nbsp;Teacher' . 's Details &nbsp; </h2>
                            </legend>
                            <table id="tableForAdd">
                                <tr>
                                    <th>Image</th>
                                    <td>
                                    <img style="width:200px;" src="' . $row['t_image'] . '" alt="Image">
                                    <input type="file" name="image" id="image">
                                    </td> 
                                </tr>
                                <tr>
                                    <th>Teacher Id</th>
                                    <td><input  required type="text" maxlength="12" value="' . $row['t_id'] . '" name="tId" id="tId"></td>
                                </tr>
                                <tr>
                                    <th>Teacher Name</th>
                                    <td><input required type="text" name="tName" id="tName" value="' . $row['t_name'] . '"> </td>
                                </tr>
                                <tr>
                                    <th>Father Name</th>
                                    <td> <input required type="text" value="' . $row['t_father_name'] . '" name="fName" id="fName"> </td>
                                </tr>
                                <tr>
                                    <th>Mobile No</th>
                                    <td> <input type="number" required name="tMobile" value="' . $row['t_mobile'] . '" id="tMobile"> </td>
                                </tr>
                                <tr>
                                    <th>Email Id</th>
                                    <td>  <input type="email" value="' . $row['t_email'] . '" required name="tEmail" id="tEmail"></td>
                                </tr>
                                <tr>
                                    <th>Teacher Department</th>
                                    <td >
                                    <select name="t_dept" id="t_dept">
                                    '; ?>
                            <?php
                            $i = 0;
                            $arr = ["Computer Science Engineering", "Artificial Intellegence", "Electronics and Communication", "Electrical Engineering", "Civil Engineering"];
                            echo '<option selected value=".' . $row['t_dept'] . '."</option>';
                            while ($i < sizeof($arr)) {
                                echo "<option value='" . $arr[$i] . "'>" . $arr[$i] . "</option>";
                                $i++;
                            }
                            echo '<option selected value=".' . $row['t_dept'] . '.">' . $row['t_dept'] . '</option>';
                            ?>
                <?php
                            echo ' </select>
                                    
                                </tr>

                                <tr>
                                    <th>Teacher Salary (&#x20B9;).</th>
                                    <td><input type="number" required name="tSalary" value="' . $row['t_salary'] . '" id="tSalary"></td>
                                </tr>
                                <tr>
                                    <th>Qualifications.</th>
                                    <td><textarea required name="tQualification" id="tQualification" cols="30" rows="4">' . $row['t_qualification'] . '</textarea>
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <th>College Name</th>
                                    <td>
                                    <textarea required name="collegeName" id="collegeName" cols="30" rows="4">' . $row['t_college_name'] . '</textarea>
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <th>Date Of Joining</th>
                                    <td>
                                    <input value="' . $row['t_date_of_joining'] . '" type="date" name="dateOfJoining" id="dateOfJoining">
                                   
                                    </td>
                                </tr>                               
                            </table>
                            <button type="submit" name="editStudent" id="editStudent" class="btn2 btn3"> Submit Details</button>
                        </fieldset>
                    </form>';
                        }
                    } else {
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

<!-- // <input required type="text" maxlength="12" name="tId" id="tId"> -->
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

<script>
    try {
        dismisible = document.getElementById('dismisible');
        dismisible.addEventListener("click", () => {
            document.getElementsByClassName('alert')[0].style.display = "none";
        })
    } catch {

    }
</script>