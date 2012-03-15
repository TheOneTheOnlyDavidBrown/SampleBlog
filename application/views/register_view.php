<div id="registration_container">
    <div id="registration_form">
        <h3>Register! It's easy and free</h3>
        <?php
            echo form_open('registrationValidation');
            echo form_label('First Name: ');
            echo form_input('firstname', set_value('firstname'));
            echo form_error('firstname', '<div class="error">', '</div>');

            echo form_label('Last Name: ');
            echo form_input('lastname', set_value('lastname'));
            echo form_error('lastname', '<div class="error">', '</div>');

            echo form_label('Your Email Address: ');
            echo form_input('email', set_value('email'));
            echo form_error('email', '<div class="error">', '</div>');

            echo form_label('Desired Username: ',set_value('username'));
            echo form_input('username');
            echo form_error('username', '<div class="error">', '</div>');

            echo form_label('Password: ');
            echo form_password('password');
            echo form_error('password', '<div class="error">', '</div>');

            echo form_label('Password Confirmation: ');
            echo form_password('password_conf');
            echo form_error('password_conf', '<div class="error">', '</div>');

            echo "<button class='button'><span>Register</span></button>";
            echo form_close();
        ?>
    </div>
</div>