
<div class="banner"><h4>
<?php
    $uid=$this->uri->segment(2);
    if($uid == $this->session->userdata('id') || $uid==false)
        echo "Your recent posts...";
    else
        echo "Recent updates...";
?>
</h4></div>

<div id="subscribe_button">
    <?php 
        if ($this->session->userdata('is_logged_in'))
        {
            if ($this->session->userdata('id') != $uid && $uid)
            {
                if ($isSubscribed == 0):?>
                    <form action='<?=base_url()."subscribe/".$uid?>'>
                        <button class="button"><span>Subscribe</span></button>
                    </form>
                    <?php else: ?> 
                    <form action='<?=base_url()."unsubscribe/".$uid?>'>
                        <button class="button"><span>Unsubscribe</span></button>
                    </form>
                <?php endif; 
            }
        }
    ?>
    
</div>

<?php echo $this->pagination->create_links();?>
<ul class="list">
    <?php if (isset($results)) : foreach ($results as $row) : ?>
    <li class="clearfix">
        <?php $commentCount = $this->blog_model->getCommentCount($row->id); ?>
        
        <a class="title" href ="<?=base_url()?>article/<?=$row->id?>">
                <?=$row->title;?>
        </a>
                
        <?php if ($row->published==0): ?>
            [Unpublished]
        <?php endif;?>

        <span class="date">
            <?="By ". anchor("feed/".$row->user_id, $this->blog_model->userFromID($row->user_id, "firstname")." ".$this->blog_model->userFromID($row->user_id, "lastname"))." on ".date("Y-m-d", $row->date)." at ".date("g:ia", $row->date); ?>
        </span>
        
        <p class="summary">
            <?=htmlspecialchars_decode($row->preview);?>
        </p>
        
        <div class="post_links">

            <?php if($this->session->userdata('id')==$row->user_id):?>

            <form action="<?=base_url()?>editpost/<?=$row->user_id."/".$row->id?>">
                <button class="button"><span>Edit Post</span></button>
            </form>
            <?php endif;?>

            <form action="<?=base_url()?>article/<?=$row->id?>">
                <button class="button"><span>Read More (<?=$commentCount?> Comment<?php if ($commentCount!=1) echo "s";?>)</span></button>
            </form>
        </div>        
    </li>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php echo $this->pagination->create_links();?>
</ul>
