<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Admin') {
    $allStudents = false;
    $seeStudent = false;
    require '../PHP/_header.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['findStudent'])) {
            header("Location:./find_student.php");
        } elseif (isset($_POST['allStudents'])) {
            header("Location:./all_student.php");
        } elseif (isset($_POST['addStudent'])) {
            header("Location:./add_student.php");
        } elseif (isset($_POST['deleteStudent'])) {
            header("Location:./delete_student.php");
        } elseif (isset($_POST['editStudent'])) {
            header("Location:./edit_student.php");
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
                        <button type="submit" id="findStudent" name="findStudent" class="btn2">Find Particular Student</button>
                        <button type="submit" name="allStudents" class="btn2">All Students</button>
                        <button type="submit" name="addStudent" class="btn2">Add Student</button>
                        <button type="submit" name="deleteStudent" class="btn2">Delete Student</button>
                        <button type="submit" name="editStudent" class="btn2">Edit Student Details</button>
                    </form>
                </fieldset>
            </div>

        </div>



    <?php


}

    ?>



    <?php

    require '../PHP/_footer.php'; ?>