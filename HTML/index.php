<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/index.css">
    <title>SIS-Student Information System.</title>
</head>

<body>
    <?php
    require '../PHP/_header.php';
    ?>


    <!-- Creating second section -->
    <section id="main">
        <h1><span>SBITM </span> Shri Balaji Institute Of Technology  And Managemenent Betul(M.P).</h1>
        <img src="../HTML/logo.png" alt="" id="logo">
        <div class="choice">
            <?php
            if (isset($_SESSION['userName'])) {
            ?>
                <p>Welcome To <span> SIS </span>Student Information System </p>
            <?php
                echo '<div class="d-flex"><span style="padding: 10px;" id="userNameEdit">Hii ' . $_SESSION['userName'] . '</span>';
                echo '<div>
                
                <form action="../html/handle_logout.php" method="post">
               
                <button type="submit" class="btn" name="logout" onclick="return confirmLogout();" id="logout">logout</button>
                </form> </div>
                </div>';
            } else {
            ?>
                <p>Welcome To The <span>Student Information System </span>Login Or Signup to open your account</p>
                <div class="d-flex" style="margin:20px">
                    <div >
                        <a href="../html/login.php" style="font-size:1.3rem;" id="LogIn" class="btn" name="LogIn">LogIn</a>
                    </div>
                    <div> <a href="../html/signUp.php" style="font-size:1.3rem;" id="SignUp" class="btn" name="SignUp"> SignUp</a>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>

    </section>


    <?php
    require '../PHP/_footer.php';
    ?>

</body>

</html>
<script>
    footer = document.getElementById('footer');
    footer.style.position = 'relative';

    function confirmLogout() {
        return confirm('Are you sure you want to Logout?');
    }
</script>