<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['userName']) && $_SESSION['character'] == 'Student') {

    // Getting the header 
    require '../PHP/_header.php';
    // Getting all the buttons for the actions(post/get) request
    require './student_buttons.php';
?>

    <body>

        <div id="main_viewDetails">
            <div id="left_viewDetails">
                <!-- Getting all the buttonsH -->
                <?php
                echo getButtons();
                ?>
            </div>


        </div>

        <section id="std_dash_footer" style="top:100vh">
            Copyright &copy; 2022-23 SBITM. Developed by Moin Khan
        </section>
    </body>

    </html>


<?php
} else {
    // If the person is not the Student then he/she must be redirect to the login page.
    header("Location:login.php");
}
?>
