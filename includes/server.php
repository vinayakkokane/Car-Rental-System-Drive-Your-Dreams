<?php
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}

$_SESSION['LAST_ACTIVITY'] = time();

$db = mysqli_connect('localhost', 'root', '', 'cr');

$email = "";
$username = "";
$errors = array();

//if user signup button
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) {
        $errors['username'] = "Username is required";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required";
    }
    if ($password != $cpassword) {
        $errors['password'] = "Passwords aren't matching!";
    }

    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    }
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email = '$email' LIMIT 1";
    $res = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($res);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            $errors['username'] = "Username already exists";
        }

        if ($user['email'] === $email) {
            $errors['email'] = "Email already exists";
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) === 0) {
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $code = rand(999999, 111111);
        $status = "not-verified";
        $insert_data = "INSERT INTO users (username, email, password, code, status)
                        values('$username', '$email', '$encpass', '$code', '$status')";
        $data_check = mysqli_query($db, $insert_data);
        if ($data_check) {
            $subject = "Email Verification Code";
            $message = "Thank you for registering with India's leading and one stop Car rental platform. Drive your Dreams! 
            Your verification code is $code";
            $sender = "From: vinayaklkokane2001@gmail.com";
            if (mail($email, $subject, $message, $sender)) {
                $info = "We've sent a verification code to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header('location: user-otp.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Failed while inserting data into database!";
        }
    }
}
//if user click verification code submit button
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($db, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE code = $otp_code";
    $code_res = mysqli_query($db, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = 'verified';
        $update_otp = "UPDATE users SET code = $code, status = '$status' WHERE code = $fetch_code";
        $update_res = mysqli_query($db, $update_otp);
        if ($update_res) {
            $_SESSION['email'] = $email;
            echo "<script type = \"text/javascript\">
                alert(\"User Registered Succesfully\");
                window.location = (\"login-user.php\")
                </script>";
        } else {
            $errors['otp-error'] = "Failed while updating code!";
        }
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

//if user click login button
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($db, $check_email);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        if (password_verify($password, $fetch_pass)) {

            $_SESSION['email'] = $email;
            $status = $fetch['status'];
            if ($status == 'verified') {

                $qr = "SELECT * FROM users WHERE email = '$email'";
                $res = $db->query($qr);
                $rws = $res->fetch_assoc();
                $_SESSION['username'] = $rws['username'];

                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;

            //for profile completion percentage
                $username = $_SESSION['username'];
                $qr = "SELECT * FROM users WHERE username = '$username'";
                $res = $db->query($qr);
                $rws = $res->fetch_assoc();

                $id = $rws['id'];
                $qr = "SELECT * FROM userprofile WHERE id = '$id'";
                $res1 = $db->query($qr);
                $rws1 = $res1->fetch_assoc();

                $total = 30;
                if ($rws1) {
                    if ($rws1['fname'] != '') {
                        $total += 10;
                    }
                    if ($rws1['lname'] != '') {
                        $total += 10;
                    }
                    if ($rws1['dob'] != '') {
                        $total += 10;
                    }
                    if ($rws1['mob'] != '') {
                        $total += 10;
                    }
                    if ($rws1['country'] != '') {
                        $total += 10;
                    }
                    if ($rws1['city'] != '') {
                        $total += 10;
                    }
                    if ($rws1['address'] != '') {
                        $total += 10;
                    }
                }
                $_SESSION['prof_cmpl'] = $total;

            //open user.php
                header('location: user.php');
            } else {
                $info = "It's look like you haven't verified your email - $email";
                $_SESSION['info'] = $info;
                header('location: user-otp.php');
            }
        } else {
            $errors['email'] = "Incorrect email or password!";
        }
    } else {
        $errors['email'] = "It's look like you're not yet a member! Click on the Sign-up link to get started!.";
    }
}

//if user click continue button in forgot password form
if (isset($_POST['check-email'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $run_sql = mysqli_query($db, $check_email);
    if (mysqli_num_rows($run_sql) > 0) {
        $code = rand(999999, 111111);
        $insert_code = "UPDATE users SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($db, $insert_code);
        if ($run_query) {
            $subject = "Password Reset Code";
            $message = "Your password reset code is $code";
            $sender = "From: vinayaklkokane2001@gmail.com";
            if (mail($email, $subject, $message, $sender)) {
                $info = "We've sent a passwrod reset otp to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: reset-code.php');
                exit();
            } else {
                $errors['otp-error'] = "Failed while sending code!";
            }
        } else {
            $errors['db-error'] = "Something went wrong!";
        }
    } else {
        $errors['email'] = "This email address does not exist!";
    }
}

//if user click check reset otp button
if (isset($_POST['check-reset-otp'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($db, $_POST['otp']);
    $check_code = "SELECT * FROM users WHERE code = $otp_code";
    $code_res = mysqli_query($db, $check_code);
    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

//if user click change password button
if (isset($_POST['change-password'])) {
    $_SESSION['info'] = "";
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
    if ($password !== $cpassword) {
        $errors['password'] = "Confirm password not matched!";
    } else {
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $encpass = password_hash($password, PASSWORD_BCRYPT);
        $update_pass = "UPDATE users SET code = $code, password = '$encpass' WHERE email = '$email'";
        $run_query = mysqli_query($db, $update_pass);
        if ($run_query) {
            $info = "Your password has been changed successfully. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        } else {
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}


//Update password
if (isset($_POST['updpwd'])) {
    $_SESSION['upd-pwd'] = "";
    $email = $_SESSION['email']; //getting this email using session
    $oldpassword = mysqli_real_escape_string($db, $_POST['oldpassword']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($db, $check_email);
    if (mysqli_num_rows($res) > 0) {
        $fetch = mysqli_fetch_assoc($res);
        $fetch_pass = $fetch['password'];
        if (password_verify($oldpassword, $fetch_pass)) {
            if ($password !== $cpassword) {
                $errors['password'] = "Confirm password not matched!";
            } else {
                $email = $_SESSION['email']; //getting this email using session
                $encpass = password_hash($password, PASSWORD_BCRYPT);
                $update_pass = "UPDATE users SET password = '$encpass' WHERE email = '$email'";
                $run_query = mysqli_query($db, $update_pass);
                if ($run_query) {
                    $updpwd = "Your password has been updated successfully! Now you can login with your new password.";
                    $_SESSION['updpwd'] = $updpwd;
                    header('Location: updpwd.php');
                } else {
                    $errors['db-error'] = "Failed to change your password!";
                }
            }
        } else {
            $errors['password'] = "Old password do not match!";
        }
    } else {
        $errors['wrong'] = "Something went wrong!";
    }
}

//if login now button click
if (isset($_POST['login-now'])) {
    header('Location: login-user.php');
}
