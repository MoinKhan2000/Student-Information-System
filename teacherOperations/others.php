<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $added = false;
    $deleted = false;
    $allStudents = false;
    $seeStudent = false;
    $alreadyExist = false;
    require '../PHP/_header.php';
    require './teacher_buttons.php';
    require_once '../PHP/_dbConnect.php';
    $solved = false;
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['std_related'])) {
            header("Location:./student_related.php");
            echo $_GET['std_related'];
        } elseif (isset($_GET['tchr_related'])) {
            header("Location:./teacher_related.php");
            echo $_GET['tchr_related'];
        } elseif (isset($_GET['others_related'])) {
            echo $_GET['others_related'];
            header("Location:./others.php");
        } elseif (isset($_GET['notice_related'])) {
            header("Location:./notices.php");
        }
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['solved'])) {
            $issueId = $_POST['solved'];
            $sql = "UPDATE `student_issues` SET `solved` = 'Y' WHERE `student_issues`.`issue_id` = $issueId";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $solved = true;
            }
        }
        if (isset($_POST['deleteIssue'])) {
            $issueId = $_POST['deleteIssue'];
            $sql = "delete from student_issues where issue_id=$issueId";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $deleted = true;
            }
        }
    }

?>
    <?php
    if ($solved) {
        echo '<div class="alert" style="background-color: #e17fbe;">
       <B> &#x2713; </B> Success! Issue Has Been Solved.
        <span>
            <button id="dismisible" style="background-color:#e17fbz"">X</button>
        </span>
    </div>';
    } elseif ($deleted) {
        echo '<div class="alert" style="background-color: #e17fbe;">
        <B> &#x2713; </B> Success! Issue Has Been Deleted.
         <span>
             <button id="dismisible" style="background-color:#e17fbz"">X</button>
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

            <div id="bottom">
                <?php
                // Establishing the connectin to the database
                require_once '../PHP/_dbConnect.php';
                $enrollId = $_SESSION['enrollId'];
                // Selecting all the notices from the notices table 
                $sql = "select * from sis.student_issues where t_id=" . $enrollId . "";
                $result = mysqli_query($conn, $sql);
                if ($row = mysqli_num_rows($result) > 0) {
                    echo '
                <form  action="" method="post">
                <div id="top" style="display: flex;width: 100%;flex-wrap: wrap;justify-content;space-between;">';
                    // Fetching all the rows and represeting it to the student
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sql2 = "SELECT * FROM `sis`.`std_details` WHERE `std_id` = '" . $row['std_id'] . "'";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        $studentName = $row2['std_name'];
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
                    <input type="hidden" name="searchEnroll" value="' . $row['std_id'] . '">
                    <h5 style="color:#f7007c; background-color:white;"> From : ' . $studentName . '.<a type="submit" style="color:blue;" href="./find_student.php?searchEnroll=' . $row['std_id'] . '"> ' . $row['std_id'] . '</a>
                    
                    </h5>
                    <h5 ">At : ' . $row['timestamp'] . '</h5>
                    <div class="d-flex" style="justify-content:space-around;">
                   
                    <button type="submit" name="deleteIssue"  onclick="return checkDelete();" value="' . $row['issue_id'] . '" class="btn" id="deleteIssue">Delete</button>';
                        if ($row['solved'] == 'N') {
                            echo '<button type="submit" onclick="return checkSolved();"  value="' . $row['issue_id'] . '" name="solved" class="btn" id="solved">Solved</button>';
                        }
                        echo ' </div>
                    </div>
                   
                    </div>
                        </form>     ';
                    }
                } else {
                    echo '<h1 style="padding:40px;"> There is nothing for you.';
                }
                ?>
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

    function checkSolved() {
        return confirm('Are You Sure That The Issue Has Been Solved?');
    }

    function checkDelete() {
        return confirm('Are you sure you want to delete this Issue?');
    }
    collegeName.innerText = 'Shri Balaji Institute Of Technology And Management Betul(M.P)';
</script>