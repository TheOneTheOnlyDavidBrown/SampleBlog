<div id="footer">
	<div class="copyright"><!--label:key(Copyright Text)-->Site by <a target="_BLANK" href="http://www.davidbrownucf.com">David Brown</a><!--/label--></div>

    <?php
        if ($this->session->userdata('is_logged_in'))
        {
            echo anchor('logout','Logout');
        }
    ?>
</div>
	</div>
</div>
 
        </body>
</html>
