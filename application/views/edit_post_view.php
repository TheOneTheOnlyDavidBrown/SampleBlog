

<div class="banner"><h4>Editing a post...</h4></div>
<div id="edit_post">
    <?php
    if (isset($results))
    {
        foreach ($results as $row)
        {
            echo validation_errors('<div class="error">', '</div>');

            echo form_open('editPostValidation');
            echo form_hidden('pid',$pid);
            echo form_hidden('uid',$uid);
            echo form_label('Title: ');
            echo form_input('title', $row->title);
            echo anchor(base_url()."deletepost/".$this->session->userdata('id')."/".$row->id,"Delete Post");
            //echo form_error('title', '<div class="error">', '</div>');

            echo form_textarea('content', htmlspecialchars_decode($this->blog_model->br2nl($row->content)));
            //echo form_error('content', '<div class="error">', '</div>');

            echo "<div id = 'draft'>";?>
            <input type='hidden' name='published' value='1' checked="checked" />
            <?php if($row->published==0)
            {
                ?>
                <input type='checkbox' name='published' value='0' checked="checked" />
                <?php
            }
            else
            {
                ?><input type='checkbox' name='published' value='0' /><?php
            }
                echo "Unpublish";
            echo "</div>";
        echo "<button class='button'><span>Save!</span></button>";
            echo form_close();
        }
    }?>
       
</div>
