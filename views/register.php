<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}
?>

<!-- register form -->
<form method="post" action="register.php" name="registerform">

    <!-- the user name input field uses a HTML5 pattern check -->
    <div>
    <label for="login_input_username">Username </label>
    </div>
	<div>
    <input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />
	</div>
	<div>
    <!-- the email input field uses a HTML5 email type check -->
    <label for="login_input_email">User's email</label>
    </div>
	<div>
    <input id="login_input_email" class="login_input" type="email" name="user_email" required />
	</div>
	<div>
    <label for="login_input_password_new">Password (min. 6 characters)</label>
    </div>
	<div>
    <input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
	</div>
	<div>
    <label for="login_input_password_repeat">Repeat password</label>
    </div>
	<div>
    <input id="login_input_password_repeat" class="login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
    </div>
	<div>
    <input type="submit"  name="register" value="Register" />
	</div>
</form>

<!-- backlink -->
<a href="index.php">Back to Login Page</a>
