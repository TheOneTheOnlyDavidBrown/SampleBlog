<div id="menu">
    <ul>
        

        
        <?php
        if ($this->session->userdata('is_logged_in')):?>
            <li><a href="<?=base_url()."feed/all";?>"><span>Subscriptions Feed</span></a></li>
            <li class="separator"></li>
            <li><a href="<?=base_url().'feed/'.$this->session->userdata('id');?>"><span>Your Posts</span></a></li>
            <li class="separator"></li>
            <li><a href="<?=base_url().'addentry';?>"><span>Update Your Feed!</span></a></li>
            <div id ="search">
                
                
            <?php
                echo form_open('searchpeople');
                echo form_input('search', set_value('search'));
                echo form_submit('submit', 'Search');
                echo form_close();
            ?>
            </div>
         <?php else:?>
            <div id ="login_form">
                
            <?php
                echo form_open(base_url().'loginValidation');
                echo form_label('Username: ');
                echo form_input('username');
                echo form_label('Password: ');
                echo form_password('password');
                echo form_submit('submit', 'Login');
                echo form_close();
            ?>
            </div>
         <?php endif; ?>
     
    </ul>
</div>

<div id="main-container" class="clearfix">
	<!--Two column-->
<div id="main">
	<div class="inner-main">
	<div class="main-tl"></div>
	<div class="main-tr"></div>
	<div class="main-bl"></div>
	<div class="main-br"></div>
	<div class="main-tc"></div>
	<div class="main-bc"></div>
	<div class="main-cl"></div>
	<div class="main-cr"></div>
	<div class="main-cc"></div>
	<div class="main-container">