<?php
require '../PHP/_header.php';
?>
<!-- <div id="mainForContact">
    <div class="services">
    <section class="serviceItems">
        <div id="contactRight" class="serviceRight">
            <img src="contactBg.png" alt="">
        </div>
        <div id="contactLeft" class="serviceLeft">
        <div class="d-flex-main" style="min-height:100vh;">
        <div id="loginForm" style="min-width:25%;margin: 20px auto;height: fit-content; ">
            <h1>SignUp Form</h1>
            <form action="" method="post">
                <div>
                    <input required type="text" name="enroll" id="enrollId" placeholder="Enter Your Enrollment Id">
                </div>
                <div>
                    <input required type="email" name="email" id="email" placeholder="Enter Your Email ID">
                </div>
                <div>
                    <input required type="text" name="userName" id="userName" placeholder="Enter Your UserName">
                </div>
                <div><input required type="password" name="password" id="password" placeholder="Enter Your Password">
                </div>
                <div><input required type="password" name="cPassword" id="cPassword" placeholder="Re-Enter Your Password">
                </div>
                <div>
                    <label for="whoIs">Choose Character<select name="whoIs" id="whoIs">
                            <option value="Student" selected>Student</option>
                            <option value="Teacher">Teacher</option>
                        </select>
                    </label>
                </div>

                <div>
                    <button type="submit" class="loginSignButton">Sign Up</button>
                </div>
                <div style="margin:auto; text-align:center">
                    Already have an account? <a style="color:#f7009c;text-decoration:none;" href="login.php">Login now</a>

                </div>
            </form>

        </div>
    </div>
        </div>
    </section>
    </div>
</div> -->
<div id="content">
    <div id="mainForContact">
        <div id="leftContact">
            <div>
                <h1>Send us a Message</h1>
                <div id="emailLogo">
                    <img src="mail.png" alt="">
                </div>
            </div>
            <div id="contactForm">
                <form action="">
                    <div>
                        <span>
                            <div> Your Name</div>
                            <input type="text" name="contactName" id="contactName">
                        </span>
                        <!-- <fieldset>
                            <legend> Your Name</legend>
                            <span>
                                <input type="text" name="contactName" id="contactName">
                            </span>
                        </fieldset> -->
                        <span>
                            <div> Email Address</div>
                            <input type="text" name="contactName" id="contactName">
                        </span>
                    </div>
                    <div>
                        <span>
                            <div> Phone</div> <input type="number" name="contactNumber" id="contactNumber">
                        </span>
                        <span>
                            <div> Issue? If Any.</div> <input type="text" name="contactIssue" id="contactIssue">
                        </span>
                    </div>
                    <div id="contactMessageDiv">
                        <div>
                            Message
                        </div>
                        <textarea name="contactMessage" id="contactMessage" cols="30" rows="3"></textarea>

                    </div>
                    <div>
                        <button type="submit" class="sendContactForm">Send Message</button>
                    </div>

                </form>
            </div>
        </div>
        <div id="rightContact">
            <h1>Contact information</h1>
            <div>
                <div class="iconItems">
                    <div class="icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/2838/2838912.png" alt="">
                    </div>
                    <span><h4>Location:</h4> Shri Balaji Institute of Technology and Management
                        Khasra No.238
                        8th Mile Stone NH-69,
                        Betul-Bhopal Highway,
                        Gram Gohchi, Post-Sakadehi,
                        Betul-460005</span>
                </div>
                <div class="iconItems">
                    <div class="icon">
                        <img src="https://cdn.icon-icons.com/icons2/2248/PNG/512/phone_icon_136322.png" alt="">
                    </div>
                    <span><h4>Mobile:</h4> 8818806611,97627 23690 </span>
                </div>
                <div class="iconItems">
                    <div class="icon">
                        <img src="https://cdn-icons-png.flaticon.com/512/666/666162.png" alt="">
                    </div>
                    <span><h4>Email:</h4> sbitm0545@gmail.com, principal@sbitmbetul.edu.in,
                         chadokarsatish111@gmail.com</span>
                </div>
            </div>
            <div class="iconsSocialMedia">
                <span class="icons">
                    <div class="icon">
                        <img src="images/logo-instagram.svg" alt="">
                        <img src="images/mail-outline.svg" alt="">
                        <img src="images/call-outline.svg" alt="">
                    </div>
                </span>
            </div>
        </div>
    </div>

</div>

<?php
require '../PHP/_footer.php';
