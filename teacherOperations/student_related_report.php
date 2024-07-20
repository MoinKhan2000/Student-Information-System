<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $added = false;
    $notAdded = false;
    $allStudents = false;
    $seeStudent = false;
    require '../PHP/_header.php';
    require '../PHP/_dbConnect.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require './teacher_buttons.php';
        if (isset($_POST['viewReport'])) {
            $enrollMent = $_POST['viewReport'];
        }
        if (isset($_POST['submit'])) {
            $sem = $_POST['submit'];
            // echo "myFile$sem";
            if (isset($_FILES["myFile$sem"])) {
                $files = $_FILES["myFile$sem"];
                $fileName = $files['name'];
                $fileError = $files['error'];
                $fileTemp = $files['tmp_name'];
                // print_r($files);
                if ($fileError == 0) {

                    $fileExtension = explode('.', $fileName);
                    $fileExtensionCheck = strtolower(end($fileExtension));
                    $fileExtensionStored = array('pdf');
                    if (in_array($fileExtensionCheck, $fileExtensionStored)) {
                        require '../PHP/_dbConnect.php';
                        $destinationFile = '../upload/' . $fileName;
                        move_uploaded_file($fileTemp, $destinationFile);
                        $column = $_POST['submit'];
                        $sql = "UPDATE `student_reports` SET `$column` ='$destinationFile'  where `std_id`=  '$enrollMent'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            $added = true;
                        }
                    } else {
                        $notAdded = true;
                    }
                }
            }
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
    <?php
    if ($added) {
        echo '<div class="alert" style="background-color: #e17fbe;">
                <B> &#x2713; </B> Success! Result Uploaded Successfully.
            <span>
                <button id="dismisible" style="background-color:#e17fbz"">X</button>
            </span>
            </div>';
    }
    if ($notAdded) {
        echo '<div class="alert Error";>
        <B> &#x2718; </B> Error ! Your pdf could not be uplaoded. Ensure that the extension of a file must be .pdf only! Try Again.
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
            <?php
            require_once './student_related_func.php';
            echo top();
            ?>

            <div id="bottom">
                <div class="d-flex" style="margin:auto;">

                    <fieldset id="bottomFieldset" style="width:70vw">
                        <legend>
                            <h2><?php
                                $enrollId = $_POST['viewReport'];
                                require '../PHP/_dbConnect.php';
                                $sql = "select std_name from std_details where std_id='" . $enrollId . "'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_num_rows($result);
                                $num = 1;
                                $row = mysqli_fetch_assoc($result);
                                $nameOfStudent = $row['std_name'];
                                echo $nameOfStudent . "(" . $enrollId . ")";
                                ?> </h2>
                        </legend>
                        <form action="" method="post" enctype="multipart/form-data">
                            <table>
                                <thead>
                                    <?php
                                    echo "
                                            <tr>
                                                <th>Semester</th>
                                                <th>Scenario</th>
                                                <th style='width:150px'>View</th>
                                                <th>Updated PDF's </th>
                                                <th>Operation</th>
                                                <input type='hidden' name='viewReport' value=" . $_POST['viewReport'] . ">
                                </tr> 
                                            </tr>";
                                    require '../PHP/_dbConnect.php';
                                    $sql = "select * from student_reports where std_id='" . $enrollId . "'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_num_rows($result);
                                    // $row = mysqli_fetch_assoc($result);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $i = 1;
                                        while ($i <= 8) {
                                            echo " <tr>
                                                <td>" . $i . "</td>
                                                <td>" . $row[$i] . "</td>";
                                            if ($row[$i] == 'Not Available') {
                                                echo "<td>
                                                            NA
                                                            </td> 
                                                    ";
                                            } else {
                                                echo "<td>
                                                    <a class='btn' href='" . $row[$i] . "' type='pdf' target='_blank'> View PDF<a>
                                                </td>";
                                            }

                                            echo "<td>
                                                    <input id='chooseFile' type='file' name='myFile" . $i . "'>
                                                </td> 
                                                <td><button type='submit' name='submit' value='" . $i . "' class='btn btn' onclick='return chechUpdate();'>Update </button></td>
                                                </tr>";
                                            $i++;
                                        }
                                    }
                                    ?>
                                </thead>
                            </table>
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
<script>
    try {
        dismisible = document.getElementById('dismisible');
        dismisible.addEventListener("click", () => {
            document.getElementsByClassName('alert')[0].style.display = "none";
        })
    } catch {

    }

    function chechUpdate() {
        return confirm('Are you sure you want upload this result?');
    }
</script>