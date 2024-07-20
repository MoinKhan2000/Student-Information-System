<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $allStudents = false;
    $seeStudent = false;
    require '../PHP/_header.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require './teacher_buttons.php';
        if (isset($_POST['viewReport'])) {
            echo $_POST['viewReport'];
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
            <?php
            require_once './student_related_func.php';
            echo top();
            ?>

            <div id="bottom">
                <h1 style="border-color:black"> Welcome to the Reports Section</h1>
                <fieldset id="bottomFieldset" style="width: 90%;">
                    <legend>
                        <h2>All Students</h2>
                    </legend>
                    <table>
                        <tbody>
                            <tr>
                                <th>Sr No.</th>
                                <th>EnrollMent Id</th>
                                <th>Student Name</th>
                                <th>Current Semester</th>
                                <th>Branch</th>
                                <th>Mobile No.</th>
                                <th>View Fees Record</th>
                            </tr>

                            <?php
                            require '../PHP/_dbConnect.php';
                            $sql = "select * from std_details where  not std_id='' ";
                            $result = mysqli_query($conn, $sql);
                            $i = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "
                                <tr>
                                <form action='./student_related_report.php' method='post'>
                                <td style='font-weight:bold'>" . $i . "</td>
                                <td>" . $row['std_id'] . "</td>
                                <td>" . $row['std_name'] . "</td>
                                <td>" . $row['std_sem'] . "</td>
                                <td>" . $row['std_branch'] . "</td>
                                <td>" . $row['std_mobile_no'] . "</td>
                                <td><button type='submit' class='btn'>View Report</button></td> 
                                <input type='hidden' name='viewReport' value=" . $row['std_id'] . ">
                                </form>
                                </tr> 
                            ";
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