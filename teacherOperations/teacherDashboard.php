<?php

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['userName'])) {
    require '../PHP/_dbConnect.php';
    $enrollId = $_SESSION['enrollId'];
    $sql = "select * from teacher where t_id ='$enrollId'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);
    if ($row == 1) {
        require '../PHP/_header.php';

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['std_related'])) {
                header("Location:./all_student.php");
                echo $_GET['std_related'];
            } elseif (isset($_GET['tchr_related'])) {
                header("Location:./all_teachers.php");
                echo $_GET['tchr_related'];
            } elseif (isset($_GET['others_related'])) {
                echo $_GET['others_related'];
                header("Location:./others.php");
            } elseif (isset($_GET['notice_related'])) {
                echo $_GET['notice_related'];
                header("Location:./notices.php");
            }
        }

?>

        <body>
            <div>

                <FORM method="get" action="">
                    <div id="std_dash_main" style="height:100vh">
                        <div id="allItems">
                            <div class="items">
                                <img src="../images/student.png" alt="">
                                <button value="std_related" name="std_related" id="std_related">
                                    <h2>Student Related</h2>
                                </button>

                            </div>
                            <!-- <div class="items">
                    <img src="https://cdn-icons-png.flaticon.com/512/6322/6322766.png" alt="">

                    <h2> <button value="viewReport" name="viewReport" id="viewReport">
                            <h2>View Reports.</h2>
                        </button></h2>
                </div> -->
                            <div class="items">

                                <img src="../images/teacher.png" alt="">
                                <button value="tchr_related" name="tchr_related" id="tchr_related">
                                    <h2>Teacher Related</h2>
                                </button>
                            </div>
                            <div class="items">
                                <img src="../images/notice.png" alt="">
                                <button value="notice_related" name="notice_related" id="notice_related">
                                    <h2>Add Notices</h2>
                                </button>
                            </div>
                            <!-- <div class="items">
                        <img src="https://static.thenounproject.com/png/847987-200.png" alt="">
                        <button value="changePassword" name="changePassword" id="changePassword">
                            <h2>Edit Student's Details</h2>
                        </button>
                    </div>
                    <div class="items">
                        <img src="https://cdn-icons-png.flaticon.com/512/208/208963.png" alt="">
                        <button value="examDetails" name="examDetails" id="examDetails">
                            <h2>Add a Teacher</h2>
                        </button>
                    </div> -->
                            <!-- <div class="items">
                    <img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/mid-term-exam-4045415-3341564.png" alt=""> -->
                            <!-- <button value="viewMidMarks" name="viewMidMarks" id="viewMidMarks">
                        <h2>disabled.</h2>
                    </button> -->
                            <!-- </div> -->
                            <!-- <div class="items">
                        <img src="https://cdn1.iconfinder.com/data/icons/education-set-6/512/delete-user-512.png" alt="">
                        <button value="nameCorrection" name="nameCorrection" id="nameCorrection">
                            <h2>Delete a Teacher</h2>
                        </button>
                    </div>

                    <div class="items">
                        <img src="https://cdn1.iconfinder.com/data/icons/education-vol-1-10/512/27-512.png" alt="">
                        <button value="notices" name="notices" id="notices">
                            <h2>&nbsp;Edit Teacher's Details.</h2>
                        </button>
                    </div> -->
                            <div class="items">
                                <img src="../images/helpDesk.png" alt="">
                                <button value="others_related" name="others_related" id="others_related">
                                    <h2>Others</h2>
                                </button>
                            </div>
                        </div>
                </FORM>
            </div>
            <?php
            require '../PHP/_footer.php';
            ?>
            </div>


        </body>

<?php
    }
} else {
    header("Location:../HTML/login.php");
}

?>

<script>
    document.getElementById('std_dash_main').style.alignItems = 'center'
    document.getElementById('std_dash_footer').style.position = 'absolute';
    document.getElementById('std_dash_footer').style.width = '100%';
</script>