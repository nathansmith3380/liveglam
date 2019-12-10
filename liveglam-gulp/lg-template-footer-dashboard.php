<?php $container_class = 'container nd19-block-content';
	if( isset($ft_class) && $ft_class == 'footer-dashboard' ){
	  $container_class = 'wrap';
  }
?>
<footer class="<?php echo $ft_class; ?>">
	<div class="first-footer <?php echo $ft_class; ?>">
		<div class="<?php echo $container_class; ?>">
			<div class="newdesign-footer-content">
				<div class="newdesign-footer-item newdesign-skew">
                  <div class="skew-title">
                              <p class="title">Join our Newsletter</p>
                  </div>
				</div>
				<div class="newdesign-footer-item newdesign-subscribe">
					<div class="form-subscribe send_newletter" id="send_newletter">
            <div class="email_news_content">
						  <div class="input-group">
                <label for="email_news" class="hidden">What's Your Email</label>
                <input class="btn input-subscribe email_news" name="email_news" id="email_news" type="email" placeholder="What's Your Email?" required>
                <button class="btn btn-subscribe btn_sendmail">
                  <span class="fas fa-chevron-right" aria-hidden="true"></span>
                </button>
              </div>
              <div class="email_news_error"></div>
					  </div>
					</div>
				</div>
				<div class="newdesign-footer-item social-share">
					<ul class="list_social">
						<li>
							<a href="https://www.instagram.com/liveglam.co" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-instagram.svg" alt="Follow LiveGlam Instagram"></a>
						</li>
						<li>
							<a href="https://www.facebook.com/LiveGlamCo" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-facebook.svg" alt="Follow LiveGlam Facebook"></a>
						</li>
						<li>
							<a href="https://bit.ly/LiveGlamYouTube" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-youtube.svg" alt="Follow LiveGlam Youtube"></a>
						</li>
						<li>
							<a href="https://twitter.com/LiveGlamCo" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-twitter.svg" alt="Follow LiveGlam Twitter"></a>
						</li>
						<li>
							<a href="https://www.snapchat.com/add/liveglamco" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-snapchat.svg" alt="Follow LiveGlam Snapchat"></a>
						</li>
						<li>
							<a href="https://www.pinterest.com/liveglam/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-pinterest.svg" alt="Follow LiveGlam Pinterest"></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="third-footer">
		<div class="container nd19-block-content-s">
			<div class="row">
        <div class="col-md-4 col-12 footer-logo-bg test-here">
          <?php dynamic_sidebar('footer-area-1'); ?>
          <div class="cruelty-free hide-mobile">
            <div class="cruelty-content">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-rabbit.png" alt="Cruelty Logo" />
              <p><span>Cruelty Free Products made with love & filled in the U.S.</span> All of the products we manufacture are vegan, cruelty-free, paraben-free, gluten-free, non-comedogenic and phthalates-free.</p>
            </div>
          </div>
        </div>
        <div class="col-md-8 offset-md-0 col-10 offset-1">
          <div class="row">
            <div class="col-md-3 offset-md-1 col-6">
              <?php dynamic_sidebar('footer-area-2'); ?>
            </div>
            <div class="col-md-8 col-6">
				<div class="row">
					<div class="col-md-6 col-12">
						<?php dynamic_sidebar('footer-area-3'); ?>
					</div>
					<div class="col-md-6 col-12">
					<?php if(!is_user_logged_in()){
						dynamic_sidebar('footer-area-4');
						} else {
						echo '<p class="menu-title">Get Started</p>
						<ul><li><a href="'.esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) ).'">Logout</a></li></ul>';
						}
					?>
					</div>
				</div>
			</div>
          </div>
        </div>
        <div class="col-md-12 show-mobile">
          <div class="cruelty-free">
            <div class="cruelty-content">
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/footer-rabbit.png" alt="Cruelty Logo" />
              <p><span>Cruelty Free Products made with love & filled in the U.S.</span> All of the products we manufacture are vegan, cruelty-free, paraben-free, gluten-free, non-comedogenic and phthalates-free.</p>
            </div>
          </div>
        </div>
			</div>
		</div>
	</div>
	<div class="fourth-footer">
		<div class="container nd19-block-content-xs">
			<div class="row">
				<div class="col-md-4">
					<p class="copyright">© <?php echo date('Y'); ?> LiveGlam, Inc. All rights reserved</p>
				</div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-11 offset-md-1">
              <p class="safety">Your Info is safe with us. Secured by Expedited SSL.</p>
            </div>
          </div>
        </div>
			</div>
		</div>
	</div>
</footer>