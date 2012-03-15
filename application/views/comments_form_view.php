<div id="comment_form">
    <?php if ($this->session->userdata('is_logged_in')):?>
    <h6>Leave a comment...</h6>
    <?php
        echo form_open('commentValidation/'.$this->uri->segment(2));
        echo form_hidden('pid',$this->uri->segment(2));
        
        echo form_textarea('comment', '');
        echo form_error('comment', '<div class="error">', '</div>');
        
        echo "<button class='button'><span>Post comment!</span></button>";
        
        echo form_close();

        else:?>
            You must be logged in to post a comment. Please <a href="">Login</a> or <a href="<?=base_url()?>register">Register now</a>
        <?php endif;?>
</div>