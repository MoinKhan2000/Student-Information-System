<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header file as well as all the actions (post/get)
    require '../PHP/_header.php';
    require './student_buttons.php';
?>

    <body>
       
        <FORM method="get" action="">
            <div id="std_dash_main">
                <div class="items">
                    <img src="../images/id.png" alt="">
                    <button value="viewDetails" name="viewDetails" id="viewDetails">
                        <h2>View Your Details</h2>
                    </button>

                </div>
                <div class="items">
                    <img src="../images/viewReports.png" alt="">

                    <h2> <button value="viewReports" name="viewReports" id="viewReports">
                            <h2>View Reports.</h2>
                        </button></h2>
                </div>
                <div class="items">

                    <img src="../images/viewAttendance.png" alt="">
                    <button value="viewAttendance" name="viewAttendance" id="viewAttendance">
                        <h2>View Attendance.</h2>
                    </button>
                </div>
                <div class="items">
                    <img src="../images/fees.png" alt="">
                    <button value="feesDetails" name="feesDetails" id="feesDetails">
                        <h2>Fees Details.</h2>
                    </button>
                </div>
                <div class="items">
                    <img src="../images/exam.png" alt="">
                    <button value="examDetails" name="examDetails" id="examDetails">
                        <h2>Exam Details.</h2>
                    </button>
                </div>
                <!-- <div class="items">
                    <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/mid-term-exam-4045415-3341564.png" alt="">
                    <button value="viewMidMarks" name="viewMidMarks" id="viewMidMarks">
                        <h2>View Mid Term Marks.</h2>
                    </button>
                </div> -->
                <!-- <div class="items">
                    <img src="https://cdn-icons-png.flaticon.com/512/1387/1387931.png" alt="">
                    <button value="nameCorrection" name="nameCorrection" id="nameCorrection">
                        <h2>Apply For Correction.</h2>
                    </button>
                </div> -->
                <div class="items">
                    <img src="../images/changePassword.png" alt="">
                    <button value="changePassword" name="changePassword" id="changePassword">
                        <h2>Change Password.</h2>
                    </button>
                </div>
                <div class="items">
                    <img src="../images/notice.png" alt="">
                    <button value="notices" name="notices" id="notices">
                        <h2>&nbsp;Notices.</h2>
                    </button>
                </div>
                <div class="items">
                    <img src="../images/helpDesk.png" alt="">
                    <button value="helpDesk" name="helpDesk" id="helpDesk">
                        <h2>Help Desk.</h2>
                    </button>
                </div>
        </FORM>
        </div>
        <section id="std_dash_footer">
            Copyright &copy; 2022-23 SBITM. Developed by Moin Khan
        </section>
    </body>

    </html>


<?php
} else {
    header("Location:login.php");
}
?>

<script>
    document.body.title = 'Student Dashboard';
</script>