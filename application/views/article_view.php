
<ul class="list">
    
    <?php if (isset($results)) : foreach ($results as $row) : ?>
    <li class="clearfix">
        <a class="title" href="<?=base_url()?>article/<?=$row->id;?>">
            <?=$row->title;?>
        </a>
        
        <?php if ($row->published==0): ?>
            [Draft]
        <?php endif;?>
        
        <span class="date"><?="By ".$this->blog_model->userFromID($row->user_id,'firstname')." ".$this->blog_model->userFromID($row->user_id,'lastname')." on ".date("Y-m-d", $row->date)." at ".date("g:ia", $row->date); ?></span>
        
        <p class="summary"><?=htmlspecialchars_decode($row->content);?></p>
        
            <?php if($this->session->userdata('id')==$row->user_id):?>
                <form action="<?=base_url()?>editpost/<?=$row->user_id."/".$row->id?>">
                    <button class="button"><span>Edit Post</span></button>
                </form>
            <?php endif;?>
    </li>

    <?php endforeach; ?>

    <?php endif; ?>

    <li class="clearfix">
        
            <h4>Comments</h4>
            <?php $this->load->view('comments_form_view');
            if(isset($comments))
            {
                foreach ($comments as $comment)
                {
                    echo "<div id ='comments'>";
                    echo "<div class='blog_comment_name'>".anchor(base_url()."feed/".$comment->user_id, $this->blog_model->userFromID($comment->user_id,'firstname')." ".$this->blog_model->userFromID($comment->user_id,'lastname'))." says:</div>";
                    echo "<div class='blog_comment_content'>".$comment->content."</div>";
                    echo "<div class='blog_comment_date'>".date("Y-m-d", $comment->date)." at ".date("g:ia", $comment->date)."</div>";
                    if ($comment->user_id == $this->session->userdata('id')):?>
                    
                        <div class="post_links">
                            <form action="<?=base_url()?>deletecomment/<?=$comment->user_id?>/<?=$comment->post_id?>/<?=$comment->id?>">
                                <button class="button"><span>Delete Comment</span></button>
                            </form>
                            
                        </div>

                    <?php endif;
                    echo "</div>";
                }
            }
            ?>
    </li>
</ul>
