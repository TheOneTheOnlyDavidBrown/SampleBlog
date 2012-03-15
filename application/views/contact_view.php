<div id="contact_form">
    <?php
        $this->load->helper('captcha');
        echo form_open('validateEmail');
        echo validation_errors("<div class=email_error>","</div>");
        echo form_label('Your Name: ');
        echo form_input('name');

        echo form_label('Your Email Address: ');
        echo form_input('email');
        
        echo form_label('Your Message: ');
        echo form_textarea('message');
        
        echo "<button class='button'><span>Send!</span></button>";

        echo form_close();
    ?>
</div>