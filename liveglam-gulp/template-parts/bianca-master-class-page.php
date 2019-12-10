<?php

  /**
   * Template Name: Bianca Master Class Page
   *
   * @package Liveglam
   */

  if(!is_user_logged_in() ){
    wp_redirect(home_url('/my-account/?referer='.urlencode(home_url('/bianca-master-class/'))));
    exit;
  }

  $is_active_user = false;
  $status_member = array('active','pause');
  if(!empty($subscriptions_status = LiveGlam_Subscription_Status::get_status())){
    foreach($subscriptions_status as $key => $value){
      if(in_array($value, $status_member)){
        $is_active_user = true;
        break;
      }
    }
  }
  if( !$is_active_user ){
    wp_redirect(home_url('/my-account/')); exit;
  }
  get_header(); ?>

<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/biancamc-banner-desktop.png" class="hide-mobile" style="width: 100%" />
<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/biancamc-banner-mobile.png" class="show-mobile" style="width: 100%" />

<div class="container">

  <?php the_content(); ?>

</div>

<?php get_footer(); ?>
