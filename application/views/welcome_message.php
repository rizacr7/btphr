<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_login.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="company-logo">
                    <img src="<?php echo base_url(); ?>assets/img/btplogo.png" alt="Company Logo" height="70"/>
                </div>
                <h3>Fleet Management System</h3>
                <p>Please sign in to your corporate account</p>
            </div>
            
            <form class="login-form" id="loginForm" novalidate>
                <div class="form-group">
                    <div class="input-wrapper">
                        <input type="text" id="username" name="username" required>
                        <label for="username">Username</label>
                        <span class="input-border"></span>
                    </div>
                    <span class="error-message" id="usernameError"></span>
                </div>

                <div class="form-group">
                    <div class="input-wrapper password-wrapper">
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                        <label for="password">Password</label>
                        <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                            <span class="toggle-icon"></span>
                        </button>
                        <span class="input-border"></span>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>

                <div class="form-options">
                    <div class="remember-wrapper">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember" class="checkbox-label">
                            <span class="checkbox-custom"></span>
                            Keep me signed in
                        </label>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <span class="btn-text">Sign In</span>
                    <span class="btn-loader"></span>
                </button>

                <div id="alertMessage" class="alert-message" style="display:none;"></div>
                
            </form>

        </div>
    </div>

    <style>
    .alert-message {
        margin-top: 15px;
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 14px;
        display: none;
        text-align: center;
    }
    .alert-message.error {
        background-color: #ffe5e5;
        color: #c00;
        border: 1px solid #ffb3b3;
    }
    .alert-message.success {
        background-color: #e6ffed;
        color: #0a8020;
        border: 1px solid #a2f0b1;
    }
    .alert-message .icon {
        margin-right: 5px;
    }
    </style>

    <script src="../../shared/js/form-utils.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/script.js"></script>

    <script>
    $(document).ready(function() {
         $("#loginForm").on("submit", function(e) {
            e.preventDefault();

            let formData = {
                username: $("#username").val(),
                password: $("#password").val(),
                remember: $("#remember").is(":checked") ? 1 : 0
            };

            $(".btn-loader").show();
            $(".btn-text").text("Signing in...");
            $("#alertMessage").hide().removeClass("error success");

            $.ajax({
                url: "<?php echo base_url('index.php/Welcome/login'); ?>",
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    $(".btn-loader").hide();
                    $(".btn-text").text("Sign In");

                    if (response.status === "success") {
                        $("#successMessage").fadeIn();
                        $("#alertMessage").hide();
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1500);
                    } else {
                        // tampilkan alert error
                        $("#alertMessage")
                            .addClass("error")
                            .html('<span class="icon">⚠️</span> ' + response.message)
                            .fadeIn();
                    }
                },
                error: function() {
                    $(".btn-loader").hide();
                    $(".btn-text").text("Sign In");
                    $("#alertMessage")
                        .addClass("error")
                        .html('<span class="icon">❌</span> Terjadi kesalahan koneksi.')
                        .fadeIn();
                }
            });
        });
    });
    </script>

</body>
</html>