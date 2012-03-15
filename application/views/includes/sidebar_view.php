</div>
</div>
</div>

<div id="sidebar">
	<!--position:name(Sidebar)-->
	<!--view:name(VerticalMenu)-->
	<div class="vertical-menu">
	<div class="vertical-menu-container">

		<div class="vertical-menu-content">
			<div class="vertical-menu-content-container">

<ul class="v-menu">
	<li><a href="<?=base_url()?>"><span>Home</span></a></li>
            <ul class="sub-v-menu">
                <li>
                    <a href="<?=base_url()?>subscriptions">
                        Subscriptions <?="(".$this->blog_model->getCount('subscriptions').")";?>
                    </a>
                </li>
                <li>
                    <a href="<?=base_url()?>subscribers">
                        Subscribers <?="(".$this->blog_model->getCount('subscribers').")";?>
                    </a>
                </li>
            </ul>
	<li>
		<a href=<?=base_url()."feed/".$this->session->userdata('id');?>><span>Profile</span></a>
		<ul class="sub-v-menu">
                    <li>
                        <a href="<?=base_url()?>editprofile">
                            Edit Profile
                        </a>
                    </li>
                    <!--li>
                        <a href="#">
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Privacy
                        </a>
                    </li-->
                    <li>
                        <a href="<?=base_url()."logout"?>">
                            Log out
                        </a>
                    </li>
		</ul>
	</li>
	<!--li><a href="#"><span>About</span></a></li-->
</ul>

			</div>
		</div>
	</div>
</div>
	<!--htmlblock:name(Contact Info)-->
<div class="block">
	<div class="block-container">
		<div class="block-header">
			<div class="block-header-container">
				<h6>Contact Info</h6>
			</div>
		</div>
		<div class="block-content">
			<div class="block-content-container">
                            <a href ="<?=base_url().'contact'?>">Click here to contact the website administer for assistance</a>
			</div>
		</div>
	</div>
</div><!--/htmlblock-->
<!--htmlblock:name(Email Subscription)-->
<!--div class="block">
	<div class="block-container">
		<div class="block-header">
			<div class="block-header-container">
				<h6>Subscribe via email:</h6>
			</div>
		</div>
		<div class="block-content">
			<div class="block-content-container">
				<form action="#">
    <input name="email" type="text" style="margin-bottom:3px;padding:3px;width:95%;" />
    <button class="button"><span>Submit</span></button>
</form>
			</div>
		</div>
	</div>
</div--><!--/htmlblock-->

	<!--/position-->
</div>
</div>