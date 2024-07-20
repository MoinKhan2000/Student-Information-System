<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    require '../PHP/_header.php';
    require './teacher_buttons.php';
    $added = false;
    $amountNotMatched = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['searchEnroll'])) {
            $student_id = $_POST['searchEnroll'];
        }
    }
    if (isset($_POST['approveFees'])) {
        if ($_POST['payToApproveAgain'] != $_POST['payToAprove']) {
            $amountNotMatched = true;
        } elseif (($_POST['payToApproveAgain'] == $_POST['payToApprove']) && ($_POST['payToApproveAgain'] != 0)) {
            $student_id = $_POST['searchEnroll'];
            require '../PHP/_dbConnect.php';
            $sql = "SELECT * FROM `student_fees`WHERE std_id='" . $student_id . "' ORDER BY `fees_id` DESC";
            $i = 0;
            $result = mysqli_query($conn, $sql);
            while ($i != 1) {
                $row = mysqli_fetch_assoc($result);
                $amount_to_pay = $_POST['payToApprove'];
                $t_id = $_SESSION['enrollId'];

                $fees_id = $row['fees_id'];
                $remaining_fees = $row['remaining_fees'];
                $remaining_fees = $remaining_fees - $amount_to_pay;
                $isCompleted = 0;
                if ($remaining_fees == 0) {
                    $isCompleted = 1;
                }
                $sql = "INSERT INTO `student_fees` ( `std_id`, `total_fees`, `amount_paid`, `remaining_fees`, `teacher_id`, `isCompleted`, `time_of_submission`) VALUES ( '$student_id', '50000', $amount_to_pay, $remaining_fees,$t_id, $isCompleted, current_timestamp());";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    die("Could not update the fees into database. ");
                } else {
                    $added = true;
                    $amountNotMatched = false;
                    echo '<script>
                    alert("Successfully Updated.");
                    </script>';
                }
                $i++;
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
        echo '<div class="alert success";>
        Success! Fees record has been updated
          <span>
              <button id="dismisible">&#x2716;</button>
          </span>
      </div>';
    }
    if ($amountNotMatched) {
        echo '<div class="alert Error";>
            <B> &#x2718; </B> Error! Amount Not Matched. Enter the same amount.
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
                <fieldset id="bottomFieldset" style="width:70vw">
                    <legend>
                        <h2><?php
                            $enrollId = $_POST['searchEnroll'];
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

                    <table>
                        <thead>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                echo '<tr>
                                <th>Entry No.</th>
                                <th>Total Fees </th>
                                <th>Paid Amount </th>
                                <th>Remaining Fees</th>
                                <th>Approved By</th>
                                <th>Submission Date</th>
                            </tr>';
                                require '../PHP/_dbConnect.php';

                                $sql = "select * from student_fees where std_id='" . $_POST['searchEnroll'] . "'";
                                $result = mysqli_query($conn, $sql);
                                $row = mysqli_num_rows($result);
                                $num = 1;
                                // $row=mysqli_fetch_assoc($result);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sql2 = "SELECT t_name FROM `teacher_details` WHERE t_id=" . $row['teacher_id'] . "";
                                    $result2 = mysqli_query($conn, $sql2);
                                    $row2 = mysqli_fetch_assoc($result2);
                                    $t_name = $row2['t_name'];
                                    // if ($row['isCompleted'] == '1') {
                                    //     break;
                                    // }
                                    echo " <tr>
                                <td>" . $num . "</td>
                                <td>" . $row['total_fees'] . "</td>
                                <td>" . $row['amount_paid'] . "</td>
                                <td>" . $row['remaining_fees'] . "</td>
                                <td>" . $t_name . "</td>
                                <td>" . $row['time_of_submission'] . " </td>
                                </tr>";
                                    $num++;
                                }
                            }

                            ?>


                        </thead>
                    </table>
                </fieldset>
            </div>
        <div class="d-flex" style="height:50vh">

            <div id="loginForm" style="border:none">
                <fieldset>
                    <legend>
                        <h3 style="color:black">Approve Other Payment.</h3>
                    </legend>

                    <form action="./student_fees_record.php" method="post" onsubmit="myFunc();">
                        <input type='hidden' name='searchEnroll2' value='<?php echo $_POST['searchEnroll'] ?>'>

                        <label for="payToApprove">Enter The Amount</label><input type="number" required name="payToApprove" id="payToApprove">
                        <label for="payToApproveAgain">Re-enter The Amount</label><input type="number" required name="payToApproveAgain" id="payToApproveAgain">
                        <input type='hidden' name='searchEnroll' value='<?php echo $_POST['searchEnroll'] ?>'>

                        <div>
                            <input onclick="return checkUpdate();" id="approveFees" name="approveFees" type="submit" class="btn button" value="Approved">
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
    function checkUpdate() {
        return confirm('Are you sure you want to add this amount into student account?');
    }


    try {
        dismisible = document.getElementById('dismisible');
        dismisible.addEventListener("click", () => {
            document.getElementsByClassName('alert')[0].style.display = "none";
        })
    } catch {

    }

    function myFunc() {
        // event.preventDefault();
        console.log("Moin Khan");
    }
</script>