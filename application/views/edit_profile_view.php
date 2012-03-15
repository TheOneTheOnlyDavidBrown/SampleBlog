<div class="banner"><h4>Edit your profile...</h4></div>
<div id="edit_profile">
    <?php
        
        if (isset($results))
        {
            foreach ($results as $row)
            {
                echo form_open('editProfileValidation');
                echo form_hidden('uid',$this->session->userdata('id'));
                
                echo form_label('First Name: ');
                echo form_input('firstname', $row->firstname);
                echo form_error('firstname', '<div class="email_error">', '</div>');
                
                echo form_label('Last Name: ');
                echo form_input('lastname', $row->lastname);
                echo form_error('lastname', '<div class="email_error">', '</div>');
                
                echo form_label('Email Address: ');
                echo form_input('email', $row->email);
                echo form_error('email', '<div class="email_error">', '</div>');
                
                echo form_label('Username: ');
                echo form_input('username', $row->username);
                echo form_error('username', '<div class="email_error">', '</div>');

                echo form_label('Tell us about yourself: ');
                echo form_textarea('about', htmlspecialchars_decode($this->blog_model->br2nl($row->about)));
                echo form_error('about', '<div class="email_error">', '</div>');
                
                echo "<button class='button'><span>Save</span></button>";

                echo form_close();
            }
        }
    ?>
       
</div>