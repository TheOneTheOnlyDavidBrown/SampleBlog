<div id ="subscriptions">
    <?php if (isset($results)) : foreach ($results as $row) : ?>
        <?=anchor(base_url()."feed/$row->owner_id",$this->blog_model->userFromID($row->owner_id,'firstname')." ".$this->blog_model->userFromID($row->owner_id,'lastname'));?>
        <?="(".$this->blog_model->userFromID($row->owner_id,'username').")";?>
        <?="<br/>".$this->blog_model->userFromID($row->owner_id,'about')?>
        <hr />
    <?php endforeach; ?>
    <?php endif; ?>
</div>