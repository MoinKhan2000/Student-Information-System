<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $findStudent = false;
    $success = false;
    require '../PHP/_header.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require './teacher_buttons.php';
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
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['searchEnroll'])) {
            $findStudent = true;
        }
        if (isset($_POST['saveChanges'])) {
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

            $fileName = $files['name'];
            $fileError = $files['error'];
            $fileTemp = $files['tmp_name'];
            if ($fileError == 0) {
                $fileExtension = explode('.', $fileName);
                $fileExtensionCheck = strtolower(end($fileExtension));
                $fileExtensionStored = array('png', 'jpeg', 'jpg');
                if (in_array($fileExtensionCheck, $fileExtensionStored)) {
                    require '../PHP/_dbConnect.php';
                    $destinationFile = '../upload/students/' . $fileName;
                    move_uploaded_file($fileTemp, $destinationFile);

                    $sql = "UPDATE `std_details` SET`std_name`='$studentName', `std_f_name`='$fatherName', `std_m_name`='$motherName', `std_year`= '$pYear', `std_sem`= '$pSemester', `std_branch`='$branch', `std_mobile_no`='$sMobile', `std_father_mobile_no`='$fMobile', `std_college_name`= '$collegeName', `std_admission_year`='$admissionYear' , `image`='$destinationFile' where `std_id`='$enrollNo'";
                    require '../PHP/_dbConnect.php';
                    $result = mysqli_query($conn, $sql);
                    $success = true;
                }
            }
        }
    }



?>
    <?php
    if ($success) {
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
            <?php
            require_once './student_related_func.php';
            echo top();
            ?>
            <div id="bottom_form">
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
                            <form action='' method='post' enctype='multipart/form-data'>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <th>Image </th>
                                                <td>
                                                <img style='height:300px;' src='" . $row['image'] . "'alt='Image'>
                                                <input id='chooseFile' type='file' name='image' id='image'>
                                                </td>
                                            <tr>
                                                <th> EnrollMent No </th>
                                                <td><input disabled value='" . $row['std_id'] . " '   type='text' maxlength='12' name='enrollNo' id='enrollNo'>
                                                <input  value='" . $row['std_id'] . " '   type='hidden' maxlength='12' name='enrollNo' id='enrollNo'></td>
                                            </tr>
                                            <tr>
                                                <th> Name </th>
                                                <td><input   type='text' name='studentName' id='studentName' value='" . $row['std_name'] . "' ></td>
                                            </tr>
                                            <tr>
                                                <th> Father Name </th>
                                                <td><input   type='text' name='fatherName' id='fatherName' value='" . $row['std_f_name'] . "'> </td>
                                            </tr>
                                            <tr>
                                                <th> Mother Name </th>
                                                <td> <input   type='text' name='motherName' id='motherName' value='" . $row['std_m_name'] . "'> </td>
                                            </tr>
                                            <tr>
                                                <th>Persuing Year </th>
                                                <td><input   type='number' name='pYear' id='pYear' value='" . $row['std_year'] . "'>  </td>
                                            </tr>
                                            <tr>
                                                <th>Current Sem </th>
                                                <td><input   type='number' name='pSemester' id='pSemester' value='" . $row['std_sem'] . "'>  </td>
                                            </tr>
                                            <tr>
                                                <th> Branch </th>
                                                <td><input   type='text' name='branch' id='branch' value='" . $row['std_branch'] . "'>  </td>
                                            </tr>
                                            <tr>
                                                <th> Mobile Number </th>
                                                <td><input   type='number' name='sMobile' id='sMobile' value='" . $row['std_mobile_no'] . "'>  </td>
                                            </tr>
                                            <tr>
                                                <th>Father's Mobile Number </th>
                                                <td><input   type='number' name='fMobile' id='fMobile' value=" . $row['std_father_mobile_no'] . ">  </td>
                                            </tr>
                                            <tr>
                                                <th>College Name </th>
                                                <td><textarea name='collegeName' id='collegeName' cols='30'  rows='4'>" . $row['std_college_name'] . "</textarea> </td>
                                            </tr>
                                            <tr>
                                                <th>Admission Year </th>
                                                <td><input   type='number' name='admissionYear' id='admissionYear' value=" . $row['std_admission_year'] . ">  </td>
                                            </tr>
                                            
                                        </tbody>
                                        
                                    </table>
                                
                            </div>
                        </div>
                        <button type='submit' onclick='return checkDelete()'  id='saveChanges' value=" . $row['std_id'] . " name='saveChanges' class='btn2 btn3'> Update Changes</button>
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
                <input type="hidden" name="">
                <div class="d-flex" style="height:50vh">

                    <div id="loginForm" style="border:none">
                        <fieldset>
                            <legend>
                                <h3 style="color:black">Search To Edit Student</h3>
                            </legend>
                            <form action="" method="post">
                                <label for="searchEnroll">Enter EnrollMent Id</label><input type="text" required name="searchEnroll" id="searchEnroll">
                                <div>
                                    <input id="searchStd" type="submit" class="btn2 btn3" value="Search">
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
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
        return confirm('Are you sure you want to save these changes?');
    }
</script>
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