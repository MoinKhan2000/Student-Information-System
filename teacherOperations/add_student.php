<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $added = false;
    $allStudents = false;
    $seeStudent = false;
    $alreadyExist = false;
    require '../PHP/_header.php';
    require './teacher_buttons.php';
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


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['addStudentSubmit'])) {
            $added = false;
            $enrollNo = $_POST['enrollNo'];
            $studentName = $_POST['studentName'];
            $fatherName = $_POST['fatherName'];
            $motherName = $_POST['motherName'];
            $pYear = $_POST['pYear'];
            $pSemester = $_POST['pSemester'];
            $branch = $_POST['branch'];
            $sMobile = $_POST['sMobile'];
            $fMobile = $_POST['fMobile'];
            $collegeName = $_POST['collegeName'];
            $admissionYear = $_POST['admissionYear'];
            $files = $_FILES['image'];
            // print_r($files);

            $fileName = $files['name'];
            $fileError = $files['error'];
            $fileTemp = $files['tmp_name'];

            // Checking if the student is already present or not.
            require_once '../PHP/_dbConnect.php';
            $existId = "select * from std_details where std_id='$enrollNo'";
            $result = mysqli_query($conn, $existId);
            $row = mysqli_num_rows($result);
            if ($row > 0) {
                $alreadyExist = true;
            } else {
                if ($fileError == 0) {
                    $fileExtension = explode('.', $fileName);
                    $fileExtensionCheck = strtolower(end($fileExtension));
                    $fileExtensionStored = array('png', 'jpeg', 'jpg');
                    if (in_array($fileExtensionCheck, $fileExtensionStored)) {
                        require '../PHP/_dbConnect.php';
                        $destinationFile = '../upload/students/' . $fileName;
                        move_uploaded_file($fileTemp, $destinationFile);

                        $sql = "INSERT INTO `std_details` (`std_id`, `std_name`, `std_f_name`, `std_m_name`, `std_year`, `std_sem`, `std_branch`, `std_mobile_no`, `std_father_mobile_no`, `std_college_name`, `std_admission_year`,`image`) VALUES ('$enrollNo', '$studentName', '$fatherName', '$motherName', '$pYear', '$pSemester', '$branch', '$sMobile', '$fMobile', '$collegeName', '$admissionYear','$destinationFile')";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $added = true;
                            // Sending the data to the Attandence table
                            $sql = "INSERT INTO `attendance` (`student_name`, `student_id`) VALUES ('$studentName', '$enrollNo')";
                            require '../PHP/_dbConnect.php';
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                $added = true;
                                // Sending the data to the Fees Table
                                $sql = "INSERT INTO `student_fees` (`std_id`,`remaining_fees`,`teacher_id`)VALUES ('$enrollNo',50000," . $_SESSION['enrollId'] . ")";
                                $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    $added = true;
                                    // Sending the data to the report Table
                                    $sql = "INSERT INTO `student_reports` (`std_id`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUES ('$enrollNo', 'Not Available', 'Not Available', 'Not Available', 'Not Available', 'Not Available', 'Not Available', 'Not Available', 'Not Available')";
                                    $result = mysqli_query($conn, $sql);
                                    if (!$result) {
                                        die("Error in adding the student in the report table");
                                    }
                                } elseif (!$result) {
                                    die("Error in adding the student in the Fees table");
                                }
                            } elseif (!$result) {
                                die("Error in adding the student into the attendance table ");
                            }
                        }
                    }
                } elseif (!$result) {
                    die("Error in addin tha student into the student table");
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
    } elseif ($alreadyExist) {
        echo '<div class="alert";>
       <B> &#x2718; </B> Warning! This Student Already Exists.
        <span>
            <button id="dismisible">&#x2716;</button>
        </span>
    </div>';
    }
    ?>
    <div id="main_viewDetails">
        <div id="left_viewDetails">
            <FORM method="get" action="" enctype="multipart/form-data">
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
                <form action="" method="post" enctype="multipart/form-data">
                    <fieldset id="bottomFieldset" style="width:60%">
                        <legend>
                            <h2>&nbsp;Fill this form to Add Student &nbsp; </h2>
                        </legend>
                        <table id="tableForAdd">
                            <tr>
                                <th>EnrollMent No.</th>
                                <td> <input required type="text" maxlength="12" name="enrollNo" id="enrollNo"></td>
                            </tr>
                            <tr>
                                <th>Image</th>
                                <td>
                                    <input id="chooseFile" type="file" name="image" id="image">
                                </td>
                            </tr>
                            <th>Student Name</th>
                            <td> <input required type="text" name="studentName" id="studentName"></td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td> <input required type="text" name="fatherName" id="fatherName"></td>
                            </tr>
                            <tr>
                                <th>Mother Name.</th>
                                <td> <input required type="text" name="motherName" id="motherName"></td>
                            </tr>
                            <tr>
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
                            </tr>
                            <tr>
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
                            </tr>
                            <tr>
                                <th>Branch</th>
                                <td> <select name="branch" id="branch">
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
                                <th>Student Mobile No.</th>
                                <td> <input type="number" required name="sMobile" id="sMobile"></td>
                            </tr>
                            <tr>
                                <th>Father Mobile No.</th>
                                <td> <input type="number" required name="fMobile" id="fMobile"></td>
                            </tr>
                            <tr>
                                <th>College Name</th>
                                <td>
                                    <textarea required name="collegeName" id="collegeName" cols="30" rows="4"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>Admission Year</th>
                                <td>
                                    <select name="admissionYear" id="admissionYear">
                                        <?php
                                        $i = 2000;
                                        while ($i <= 2023) {
                                            echo '<option value="' . $i . '">' . $i . '</option>';
                                            if ($i == 2020) {
                                                echo '<option selected value="' . $i . '">' . $i . '</option>';
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </select>

                                </td>
                            </tr>
                        </table>
                        <button type="submit" id="addStudentSubmit" name="addStudentSubmit" class="btn2 btn3"> Submit Details</button>
                    </fieldset>



                </form>
            </div>

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