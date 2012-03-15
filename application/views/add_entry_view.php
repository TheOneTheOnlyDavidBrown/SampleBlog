<div class="banner"><h4>Say something new...</h4></div>
<div id="add_entry_form">
    <?php
        echo validation_errors('<div class="error">', '</div>');
        echo form_open('entryValidation');
        echo form_label('Title: ');
        echo form_input('title');
        //echo form_error('title', '<div class="email_error">', '</div>');
        
        echo form_textarea('content');
        //echo form_error('content', '<div class="email_error">', '</div>');
        echo "<div id = 'draft'>";
            echo "<input type='hidden' name='published' value='1' checked='checked' />";
            echo "<input type='checkbox' name='published' value='0' />Unpublish";
        echo "</div>";
        echo "<button class='button'><span>Post!</span></button>";

        echo form_close();
    ?>
</div>

