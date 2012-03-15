</div>
</div>
</div>

<div id="sidebar">
    <div id ="login_form_sidebar">
                
    <?php
        echo form_open(base_url().'loginValidation');
        echo form_label('Username: ');
        echo form_input('username');
        echo form_label('Password: ');
        echo form_password('password');
        echo "<button class='button'><span>Login</span></button>";
        echo anchor(base_url()."recoverpassword", "Forgot Username/Password?");
        echo form_close();
    ?>
    </div>
</div>
</div>