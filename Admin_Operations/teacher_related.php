<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Admin') {
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
        } elseif (isset($_POST['addTeacher'])) {
            header("Location:./add_teacher.php");
            $addTeacher = true;
        } elseif (isset($_POST['deleteTeacher'])) {
            header("Location:./delete_teacher.php");
            $deleteTeacher = true;
        } elseif (isset($_POST['editTeacher'])) {
            header("Location:./edit_teacher.php");
            $editTeacher = true;
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['searchT'])) {
            $searchTeacher = true;
        }
    }
    require './admin_headers.php';
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
                        <button type="submit" name="addTeacher" class="btn2">Add Teacher</button>
                        <button type="submit" name="deleteTeacher" class="btn2">Delete Teacher</button>
                        <button type="submit" name="editTeacher" class="btn2">Edit Teacher Details</button>
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