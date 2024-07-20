<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header file as well as Actions (post/get)
    require '../PHP/_header.php';
    require './student_buttons.php';


    // Creating a table to insert todays date if already created then no.
    require_once '../PHP/_dbConnect.php';
    $currentDate = date("j/n/Y");
    $checkForTodayDate = "SHOW COLUMNS FROM sis.attendance like '$currentDate'";
    $resultForTodayDate = mysqli_query($conn, $checkForTodayDate);
    $row = mysqli_num_rows($resultForTodayDate);
    if ($row == 0) {
        if (date("l") == 'Sunday' || date("l") == 'Saturday') {
        } else {
            $sql = "ALTER TABLE `attendance` ADD `$currentDate` CHAR(1)  DEFAULT 'A'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // echo 'Table created successfully';
            } else {
                die("Error");
            }
        }
    }
?>
    <div id="main_viewDetails">
        <div id="left_viewDetails">
            <?php
            // Getting all the buttons
            echo getButtons();
            ?>
        </div>


    </div>
    <div id="right_viewDetails">
        <div id="bottom">
            <fieldset id="bottomFieldset" style="width:80vw">
                <legend>
                    <h2>Your Attendance Details</h2>
                </legend>
                <table style="padding:20px;">

                    <div id="bottom">
                        <?php
                        $enrollId = $_SESSION['enrollId'];
                        $nextday = "26-2-2023";
                        require '../PHP/_dbConnect.php';

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
                                $sql = "SELECT `$columnName` FROM `attendance` where student_id ='$enrollId'";
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
    require('../PHP/_footer.php')
    ?>
<?php
} else {
    header("location:../HTML/index.php");
}
