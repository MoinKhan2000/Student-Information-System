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
    require '../PHP/_header.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['findTeacher'])) {
            header("Location:./find_teacher.php");
            $findTeacher = true;
        } elseif (isset($_POST['allTeachers'])) {
            header("Location:./all_teachers.php");
            $allTeachrs = true;
        } elseif (isset($_POST['editDetails'])) {
            header("Location:./editDetails.php");
            $editDetails = true;
        }elseif(isset($_POST['changePassword'])){
            header("Location:./change_password.php");
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['searchT'])) {
            $searchTeacher = true;
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
            echo $_GET['notice_related'];
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
            <div id="top">
                <fieldset>
                    <form action="" method="post">
                        <button type="submit" id="findTeacher" name="findTeacher" class="btn2">Find Particular Teacher</button>
                        <button type="submit" name="allTeachers" class="btn2">All Teacher</button>
                        <button type="submit" name="editDetails" class="btn2">Edit Your Details</button>
                        <button type="submit" name="changePassword" class="btn2">Change Your Password</button>


                    </form>
                </fieldset>
            </div>




        </div>
    </div>



<?php


}

?>



<?php

require '../PHP/_footer.php'; ?>