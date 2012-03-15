<div id ="search_people">
    
        
    <?php if (isset($results) && $results != false) :?>
        <h3>Results for <i><?=$searchString?></i></h3><br />
        <?php foreach ($results as $row) : ?>
    <?php
        echo anchor(base_url()."feed/".$row['id'], $row['firstname']." ".$row['lastname']." (".$row['username'].")");
    ?>
        <hr />
    <?php endforeach; ?>
    <?php else:?>
        <?php if (isset($searchString)):?>
            <h3>There are no users with the name <i><?=$searchString?></i></h3>
        <?php else:?>
            <h3>Search empty</h3>
        <?php endif; ?>
    <?php endif; ?>
</div>