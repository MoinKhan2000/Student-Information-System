<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header file as well as all the actions (post/get)
    require '../PHP/_header.php';
    require './student_buttons.php';
    require_once '../PHP/_dbConnect.php';

    $enrollId = $_SESSION['enrollId'];
    $success = false;
    $failure = false;
    $isExists = false;
    if (isset($_POST['deleteIssue'])) {
        $deleteId = $_POST['deleteIssue'];
        $sql = "select * from student_issues where issue_id=$deleteId";
        $result = mysqli_query($conn, $sql);
        if ($row = mysqli_num_rows($result) > 0) {
            $sql = "delete from student_issues where issue_id='$deleteId'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $success = true;
            } else {
                $failure = true;
            }
        } else {
            $isExists = true;
        }
    }
?>
    <?php
    if ($success) {
        echo '<div class="alert success";>
       Success! Your Issue Has Been Send Successfully.
         <span>
             <button id="dismisible">&#x2716;</button>
         </span>
     </div>';
    } elseif ($failure) {
        echo '<div class="alert Error" ;>
    <B> &#x2718; </B> Error! Your Issue Could Not Be Send Due To An Error Try Again!.
        <span>
            <button id="dismisible">&#x2716;</button>
        </span>
    </div>';
    } elseif ($isExists) {
        echo '<div class="alert warning" ;>
    <B> &#x2718; </B>! Your Issue Could Not Be Deleted Due To An Error Try Again!.
        <span>
            <button id="dismisible">&#x2716;</button>
        </span>
    </div>';
    }
    ?>

    <body>
        <div id="main_viewDetails">
            <div id="left_viewDetails">
                <?php
                echo getButtons();
                ?>
            </div>
        </div>
        <div id="right_viewDetails">
            <?php
            // Establishing the connectin to the database
            require_once '../PHP/_dbConnect.php';

            // Selecting all the notices from the notices table 
            $sql = "select * from sis.student_issues where std_id='" . $enrollId . "'";
            $result = mysqli_query($conn, $sql);
            if ($row = mysqli_num_rows($result) > 0) {
                echo '
                <form  action="" method="post">
                <div id="top" style="display: flex;width: 100%;flex-wrap: wrap;justify-content;space-between;">';
                // Fetching all the rows and represeting it to the student
                while ($row = mysqli_fetch_assoc($result)) {
                    $sql2 = "SELECT * FROM `sis`.`teacher_details` WHERE `t_id` = " . $row['t_id'] . "";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    $teacherName = $row2['t_name'];
                    echo '<div class="items2">
                    <h3 style="color:#f7007c;">';

                    switch ($row['category']) {
                        case "Corrections":
                            echo "Correction";
                            break;
                        case "examRelated":
                            echo "Exam Related";
                            break;
                        case "feesRelated":
                            echo "Fees Related";
                            break;
                        case "complainAgainstSomeone":
                            echo "Complain";
                            break;
                        case "Others":
                            echo "Others";
                            break;
                    }

                    echo ($row['solved'] == 'N') ? "( Pending )" : "( Solved )";
                    echo '
                    </h3>
                        <div name="notesDesc" id="notesDesc">' . $row['description'] . '</div>
                    <div>
                    <h5 style="color:#f7007c; background-color:white;"> To : ' . $teacherName . '</h5>
                    <h5 ">At : ' . $row['timestamp'] . '</h5>
                    <button type="submit" name="deleteIssue"  onclick="return checkDelete();" value="' . $row['issue_id'] . '" class="btn2"  style="width:70%;" id="deleteIssue">Delete</button>
                    </div>
                    </div>
                </form>
                </div>     ';
                }
            } else {
                echo '<h1 style="padding:40px;"> There is nothing for you.</h1>';
            }
            ?>
            <form action="./help_desk_issue.php" method="post">
                <button type="submit" class="btn2 btn3"> Post An Issue</button>
            </form>
        </div>

        </div>

        <?php
        require '../PHP/_footer.php';
        ?>
    </body>

    </html>


<?php
} else {
    header("Location:login.php");
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



    function checkDelete() {
        return confirm('Are you sure you want to delete this issue?');
    }
</script>