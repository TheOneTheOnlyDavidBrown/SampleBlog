<div id ="subscribers">
    <?php if (isset($results)) : foreach ($results as $row) : ?>
        <?=anchor(base_url()."feed/$row->subscriber_id",$this->blog_model->userFromID($row->subscriber_id,'firstname')." ".$this->blog_model->userFromID($row->subscriber_id,'lastname'));?>
        <?="(".$this->blog_model->userFromID($row->subscriber_id,'username').")";?>
        <?="<br/>".$this->blog_model->userFromID($row->subscriber_id,'about')?>
        <hr />
    <?php endforeach; ?>
    <?php endif; ?>
</div>