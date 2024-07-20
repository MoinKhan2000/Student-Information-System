<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['viewReports'])) {
        header("Location:./reports.php");
    } elseif (isset($_GET['viewDetails'])) {
        // echo $_GET['viewDetails'];
        header("Location:../studentOperations/viewDetails.php");
    } elseif (isset($_GET['viewAttendance'])) {
        header("Location:../studentOperations/viewAttendance.php");
    } elseif (isset($_GET['feesDetails'])) {
        header("Location:./feesDetails.php");
    } elseif (isset($_GET['examDetails'])) {
        // echo $_GET['examDetails'];
        header("Location:./exam_details.php");
    } elseif (isset($_GET['viewMidMarks'])) {
        // echo $_GET['viewMidMarks'];
    } elseif (isset($_GET['nameCorrection'])) {
        header("Location:./corrections.php");
        // echo $_GET['nameCorrection'];
    } elseif (isset($_GET['changePassword'])) {
        header("Location:./change_password.php");
        // echo $_GET['changePassword'];
    } elseif (isset($_GET['notices'])) {
        header("Location:./notices.php");
    } elseif (isset($_GET['helpDesk'])) {
        // echo $_GET['helpDesk'];
        header("Location:./help_desk.php");
    }
}

function getButtons(){
    return '<FORM method="get" action="">
                    <div class="items_viewDetails">
                        <button value="viewDetails" name="viewDetails" id="viewDetails">
                            <h2>View Your Details</h2>
                        </button>
                    </div>
                    <div class="items_viewDetails">
                        <button value="viewReports" name="viewReports" id="viewReports">
                            <h2>View Reports</h2>
                        </button>
                    </div>
                    <div class="items_viewDetails">
                        <button value="viewAttendance" name="viewAttendance" id="viewAttendance">
                            <h2>Attendance.</h2>
                        </button>
                    </div>
                    <div class="items_viewDetails">
                        <button value="feesDetails" name="feesDetails" id="feesDetails">
                            <h2>Fees Details.</h2>
                        </button>
                    </div>
                    <div class="items_viewDetails">
                        <button value="examDetails" name="examDetails" id="examDetails">
                            <h2>Exam Details.</h2>
                        </button>
                    </div>
                    <div class="items_viewDetails">
                        <button value="notices" name="notices" id="notices">
                            <h2>&nbsp;Notices.</h2>
                        </button>
                    </div>
                    <div class="items_viewDetails">
                        <button value="changePassword" name="changePassword" id="changePassword">
                            <h2>Change Password.</h2>
                        </button>
                    </div>
                    <div class="items_viewDetails">
                        <button value="helpDesk" name="helpDesk" id="helpDesk">
                            <h2>Help Desk.</h2>
                        </button>
                </FORM>';
}
