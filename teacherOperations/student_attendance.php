<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $allStudents = false;
    $seeStudent = false;
    require '../PHP/_header.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $stdId = $_GET['student_id'];
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
            echo $_GET['notice_related'];
            header("Location:./notices.php");
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require './teacher_buttons.php';
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
            <h1>
                <?php
                require '../PHP/_dbConnect.php';
                $stdId = $_GET['student_id'];
                $sql = "select std_name from std_details where std_id='$stdId'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $name = $row['std_name'];
                    echo $name . "(" . $stdId . ")";
                } else {
                    die();
                }

                ?>
            </h1>
            <div id="bottom">
                <fieldset id="bottomFieldset" style="width:80vw">
                    <legend>
                        <h2>Your Attendance Details</h2>
                    </legend>
                    <table style="padding:20px;">

                        <div id="bottom">
                            <?php


                            echo '
                    <tr id="headingTr">
                            <th>Date</th>
                            <th>Day</th>
                            <th>Scenario</th>
                    </tr>';

                            // Starting date for each month
                            $dateForBegin = date("Y/m/1");

                            // Starting date for only March 2023 (Starting Date For The Attendance(Created Date))
                            // $dateForBegin = date("Y/m/6");
                            // echo $dateForBegin;

                            // Starting date Object created by $dateForBegin
                            $begin = new DateTime($dateForBegin);

                            // Getting the date in the for of Y-n-d (Year-month-date) (n-Numaric Representation of month without 0 in the starting)
                            $date = date("Y-n-d");

                            // Creating the Object for the current date
                            $end = new DateTime("$date");

                            $noOfPresents = 0;
                            $totalDays = 0;

                            // Looping the date from the beginning( starting from 1st date for current month) till the current date.
                            for ($i = $begin; $i <= $end; $i->modify("+1 day")) {

                                // Making the column name.
                                $columnName = $i->format("j/n/Y");

                                // Getting the day for each date 
                                $timestamp = strtotime($i->format("d-n-Y"));    // Conversion of dates in the d-n-Y form
                                $day = date('l', $timestamp);                   // Only d-n-Y supported by the date('l',$timestamp)
                                // If the day is Saturday or Sunday then not showing the results. Otw showing the results.

                                if ($day == 'Saturday' || $day == 'Sunday') {
                                } else {

                                    $totalDays += 1;

                                    $sql = "SELECT `$columnName` FROM `attendance` where student_id ='$stdId'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $status = $row[$columnName];
                                    // echo $status;
                                    $status = ($status == 'P');
                                    if ($status == true) {
                                        $noOfPresents += 1;
                                    }
                                    echo '
                            <tr">
                                    <td>' . $columnName . '</td>
                                    <td>' . $day . '</td>
                                    <td>' . $row["$columnName"] . '</td> 
                            </tr>';
                                }
                            }
                            ?>

                    </table>
                </fieldset>
                <div id="percentage">
                    <h2 style="text-align:center;color:black;background: blur;background: #dedcdc;">
                        <?php
                        echo 'Total Days : ' . $totalDays . "<br>";
                        echo 'No Of Presents : ' . $noOfPresents . "<br>";
                        $percentage = ($noOfPresents / $totalDays) * 100;
                        echo 'Attendance Percentage = ' . $percentage . "%";
                        ?>
                    </h2>
                </div>
            </div>
        </div>

    </div>



<?php
    require '../PHP/_footer.php';
}
