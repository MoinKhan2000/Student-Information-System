<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
    $allTeachrs = false;
    $findTeacher = false;
    $addTeacher = false;
    $deleteTeacher = false;
    $editTeacher = false;
    $searchTeacher = false;
    $addNotices = false;
    $deleted = false;
    require '../PHP/_header.php';


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
            header("Location./notices.php");
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['addNotice'])) {
            $noticeTitle = $_POST['noticeTitle'];
            $noticeDesc = $_POST['noticeDesc'];
            $enrollId = $_SESSION['enrollId'];
            $category = $_POST['category'];
            require_once '../PHP/_dbConnect.php';
            $sql = "INSERT INTO `notices` ( `teacher_id`, `notice_title`, `notice_description`,`category`) VALUES ( '$enrollId', '$noticeTitle', '$noticeDesc','$category')";
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                die("Error occured");
            } else {
                $addNotices = true;
            }
        }

        if (isset($_POST['deleteThis'])) {
            require_once '../PHP/_dbConnect.php';
            $sql = "DELETE from notices where notice_id='" . $_POST['deleteThis'] . "' ";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $deleted = true;
            }
        }
    }



?>
    <?php
    if ($addNotices) {
        echo '<div class="alert" style="background-color: #e17fbe;">
    <B> &#x2713; </B> Success! Student Notice Added Successfully.
     <span>
         <button id="dismisible" style="background-color:#e17fbz"">X</button>
     </span>
 </div>';
    }
    if ($deleted) {
        echo '<div class="alert" style="background-color: #e17fbe;">
        <B> &#x2713; </B> Success! Delete the note Successfully.
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
            <form action="" method="post">
                <div id="top" style="    display: flex;
                width: 100%;
                flex-wrap: wrap;
                justify-content: space-between;">
                    <?php
                    require_once '../PHP/_dbConnect.php';
                    $enrollId = $_SESSION['enrollId'];
                    $sql = "Select * from sis.notices where teacher_id='" . $enrollId . "'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="items2">
                    <h2 style="color:#f7007c;"> ' . $row['notice_title'] . '</h2>
                    <div name="notesDesc" id="notesDesc" style="font-weight:bold;">' . $row['notice_description'] . '</div>
                    <div>
                    
                    <button type="submit" onclick="return checkDelete();" value="' . $row['notice_id'] . '" name="deleteThis" class="btn" id="deleteThis">
                        Delete
                    </button>
                    </div>
                </div>';
                    }
                    // echo '<button type="submit"  value="' . $row['notice_id'] . '" name="EditThis" class="btn" id="EditThis">
                    // Edit
                    // </button>'
                    ?>
            </form>
        </div>
        <div id="bottm">
            <div class="d-flex">

                <div id="loginForm" style="border:none;margin: 20px auto;">
                    <fieldset style="width: 50vw; height:auto;">
                        <legend>
                            <h3 style="color:black">Add a new Notice.</h3>
                        </legend>
                        <form style="width: 90%;" action="" method="post">
                            <label for="category">Choose Category<select name="category" id="category" style="border-color:#e83d93;">
                                    <option selected value="Normal">Normal</option>
                                    <option value="Fees">Fees Related</option>
                                    <option value="Attendance">Attendance Related</option>
                                    <option value="Scholarship">Scholarship Related</option>
                                    <option value="Exams">Exam Related</option>
                                </select>
                            </label>
                            <label for="noticeTitle">Enter the title</label><input type="text" required style="border:2px solid #f7007c; font-family: auto; font-size: 18px;" required name="noticeTitle" id="noticeTitle">
                            <br>
                            <label for="noticeDesc">Enter the Description</label><textarea required style="border:2px solid #f7007c;" name="noticeDesc" id="noticeDesc" cols="30" rows="4"></textarea>
                            <div>
                                <input style="width:40% ;border: 2px solid;" id="addNotice" name="addNotice" type="submit" class="btn2 btn3" onclick="return  checkForAdd();" value="Add Notice">
                            </div>
                            <br>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>



    </div>
    </div>



<?php


}

?>



<?php

require '../PHP/_footer.php'; ?>

<script>
    try {
        dismisible = document.getElementById('dismisible');
        dismisible.addEventListener("click", () => {
            document.getElementsByClassName('alert')[0].style.display = "none";
        })
    } catch {

    }

    function checkDelete() {
        return confirm('Are you sure you want to delete this student?');
    }

    function checkForAdd() {
        return confirm('Do you really want to Add this Notice?');
    }
</script>