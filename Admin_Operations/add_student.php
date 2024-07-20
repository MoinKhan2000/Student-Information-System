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
        $sql = "INSERT INTO `std_details` (`std_id`, `std_name`, `std_f_name`, `std_m_name`, `std_year`, `std_sem`, `std_branch`, `std_mobile_no`, `std_father_mobile_no`, `std_college_name`, `std_admission_year`) VALUES ('$enrollNo', '$studentName', '$fatherName', '$motherName', '$pYear', '$pSemester', '$branch', '$sMobile', '$fMobile', '$collegeName', '$admissionYear');
        ";
        require '../PHP/_dbConnect.php';
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $added = true;
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
                        <button type="submit" id="findStudent" name="findStudent" class="btn2">Find Particular Student</button>
                        <button type="submit" name="allStudents" class="btn2">All Students</button>
                        <button type="submit" name="addStudent" class="btn2">Add Student</button>
                        <button type="submit" name="deleteStudent" class="btn2">Delete Student</button>
                        <button type="submit" name="editStudent" class="btn2">Edit Student Details</button>
                    </form>
                </fieldset>
            </div>
            <div id="bottom">
                <form action="" method="post">
                    <fieldset id="bottomFieldset" style="width:60%">
                        <legend>
                            <h2>&nbsp;Fill the form to Add Student &nbsp; </h2>
                        </legend>
                        <table id="tableForAdd">
                            <tr>
                                <th>EnrollMent No.</th>
                                <td> <input required type="text" maxlength="12" name="enrollNo" id="enrollNo"></td>
                            </tr>
                            <tr>
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
                        <button type="submit" id="addStudentSubmit" class="btn2 btn3"> Submit Details</button>
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