<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Liveglam
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">

    <meta name="p:domain_verify" content="d2a82baee20ce0798edecbd055ef9cf7"/>
    <meta name="revisit-after" content="2 days">
    <meta name="copyright" content="LiveGlam">

    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <meta name="author" content="">
    <meta name="theme-color" content="#f05e7c"/>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <script>
        var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
    </script>

    <?php wp_head(); ?>

    <!-- google search console verification don't remove after validation -->
<meta name="google-site-verification" content="GiQHgRGuX3AatblFhMPyQMfkTwyjVfutAWYUkExcYBs" />
<meta name="google-site-verification" content="U5D66vu4fhzlPkqNw1jz3eU1QYuLJq5rkhylc-Ib78c" />

  <?php if(!is_checkout() && !is_page(PAGE_PRE_CHECKOUT) && get_option('options_enable_snowflake') === '1'){ ?>
    <style>
      /* customizable snowflake styling */
      .snowflake { color: #fff; font-size: 1em; font-family: Arial;text-shadow: 4px 0px 4px #0000001a; }
      @-webkit-keyframes snowflakes-fall{0%{top:-10%}100%{top:100%}}@-webkit-keyframes snowflakes-shake{0%{-webkit-transform:translateX(0px);transform:translateX(0px)}50%{-webkit-transform:translateX(80px);transform:translateX(80px)}100%{-webkit-transform:translateX(0px);transform:translateX(0px)}}@keyframes snowflakes-fall{0%{top:-10%}100%{top:100%}}@keyframes snowflakes-shake{0%{transform:translateX(0px)}50%{transform:translateX(80px)}100%{transform:translateX(0px)}}.snowflake{position:fixed;top:-10%;z-index:9999;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;cursor:default;-webkit-animation-name:snowflakes-fall,snowflakes-shake;-webkit-animation-duration:10s,3s;-webkit-animation-timing-function:linear,ease-in-out;-webkit-animation-iteration-count:infinite,infinite;-webkit-animation-play-state:running,running;animation-name:snowflakes-fall,snowflakes-shake;animation-duration:10s,3s;animation-timing-function:linear,ease-in-out;animation-iteration-count:infinite,infinite;animation-play-state:running,running}.snowflake:nth-of-type(0){left:1%;-webkit-animation-delay:0s,0s;animation-delay:0s,0s}.snowflake:nth-of-type(1){left:10%;-webkit-animation-delay:1s,1s;animation-delay:1s,1s}.snowflake:nth-of-type(2){left:20%;font-size:1.4vw;-webkit-animation-delay:6s,.5s;animation-delay:6s,.5s}.snowflake:nth-of-type(3){left:30%;font-size:2.2vw;-webkit-animation-delay:4s,2s;animation-delay:4s,2s}.snowflake:nth-of-type(4){left:40%;-webkit-animation-delay:2s,2s;animation-delay:2s,2s}.snowflake:nth-of-type(5){left:50%;-webkit-animation-delay:8s,3s;animation-delay:8s,3s}.snowflake:nth-of-type(6){left:60%;font-size:3.2vw;-webkit-animation-delay:6s,2s;animation-delay:6s,2s}.snowflake:nth-of-type(7){left:70%;-webkit-animation-delay:2.5s,1s;animation-delay:2.5s,1s}.snowflake:nth-of-type(8){left:80%;font-size:4vw;-webkit-animation-delay:1s,0s;animation-delay:1s,0s}.snowflake:nth-of-type(9){left:90%;font-size:0.8vw;-webkit-animation-delay:3s,1.5s;animation-delay:3s,1.5s}
    </style>
    <div class="snowflakes" aria-hidden="true">
      <div class="snowflake">❄</div>
      <div class="snowflake">❅</div>
      <div class="snowflake">❆</div>
      <div class="snowflake">❄</div>
      <div class="snowflake">❅</div>
      <div class="snowflake">❆</div>
      <div class="snowflake">❄</div>
      <div class="snowflake">❅</div>
      <div class="snowflake">❆</div>
      <div class="snowflake">❄</div>
    </div>
  <?php } ?>
</head>
<?php
global $subsStatus;
$subsStatus = LiveGlam_Subscription_Status::get_status();
$lgs_co = new LG_Setting_Checkout_Validation();
if($lgs_co->is_enable_loading_spinner()): ?>
    <div id="ajax-loading-screen" class="loaded">
        <div class="loading-icon" style="">
            <span class="default-loading-icon spin"></span>
        </div>
    </div>
    <script type="text/javascript">
        /* script show and hide loading before page load complete */
        jQuery(window).on('load', function(){
            setTimeout(removeLoader(), 0);
        });
        function removeLoader(){
            document.getElementById('ajax-loading-screen').style.display = 'none';
        }
        jQuery(window).on('beforeunload', function(){
            //setTimeout(show_hide_loader('ajax-loading-screen',true), 2000);
            document.getElementById('ajax-loading-screen').style.display = 'block';
            document.getElementById('ajax-loading-screen').style.opacity = 0;
            jQuery('#ajax-loading-screen').animate({opacity: 1}, 2000);
        });
    </script>
<?php endif; ?>

    <?php if( ( is_account_page() && is_user_logged_in() )
    || is_post_type_archive( array('monthly_brushes','monthly_lipstick','monthly_eyeshadows') )
    || ( is_post_type_archive(array('product')) && is_user_logged_in() )
    || ( is_product() && is_user_logged_in() )
    || is_page( array('rewards') ) ) :
        wc_get_template( 'lg-header-dashboard.php' );
    elseif ( is_page(LGS_CONFIRMATION_PAGES) ):
        wc_get_template( 'lg-header-confirmation.php' );
    elseif ( is_checkout() || is_page(PAGE_PRE_CHECKOUT) || is_page('pre-checkout2') ):
      wc_get_template( 'lg-header-checkout.php' );
    else :
        wc_get_template( 'lg-header-homepage.php' );
    endif;
    ?>