<?php
if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Teacher') {
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
    } elseif (isset($_POST['viewAttendance'])) {
        header("Location:./std_attendance.php");
    } elseif (isset($_POST['feesRelated'])) {
        header("Location:./student_fees.php");
    } elseif (isset($_POST['reportsRelated'])) {
        header("Location:./student_reports.php");
    }
}
