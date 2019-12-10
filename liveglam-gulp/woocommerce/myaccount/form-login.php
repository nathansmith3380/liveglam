<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>

<div class="new-form-login">
  <div class="container">
      <div class="login-content">

        <?php do_action('woocommerce_before_customer_login_form'); ?>

        <form method="post" class="login">

          <p class="login-title nd19-hero-title"><?php _e('Welcome Back, Beautiful!', 'woocommerce'); ?></p>
          <p class="login-desc nd19-hero-subtitle hide-mobile"><?php _e('It\'s a great day to be Glamazing.', 'woocommerce'); ?></p>


          <?php do_action('woocommerce_login_form_start'); ?>

          <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="username"><?php _e('Username or E-mail', 'woocommerce'); ?>
              <span class="required">*</span></label>
            <input tabindex="10" type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" placeholder="you@email.com" value="<?php echo (!empty($_POST['username']))?esc_attr($_POST['username']):''; ?>"/>
          </p>
          <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="password"><?php _e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
            <a class="login-lostpassword float-right" href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Forgot your password?', 'woocommerce'); ?></a>
            <input tabindex="20" class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" placeholder="Password"/>
          </p>

          <?php do_action('woocommerce_login_form'); ?>

          <p class="form-row form-row-login">
            <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
            <button tabindex="100" type="submit" class="woocommerce-Button btn-primary btn-block" name="login" value="<?php esc_attr_e('Login', 'woocommerce'); ?>"><?php esc_html_e('Login', 'woocommerce'); ?></button>
          </p>

          <p class="form-row d-none">
            <label for="rememberme" class="woocommerce-form__label woocommerce-form__label-for-checkbox inline">
              <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"/>
              <span><?php _e('Remember me', 'woocommerce'); ?></span>
            </label>
          </p>

          <hr>

          <div class="no-account">
            No LiveGlam Account Yet?<br>
            <a href="<?php echo home_url(PAGE_PRE_CHECKOUT)?>" class="lets-fix-that">Let's Fix That</a>
          </div>

          <?php do_action('woocommerce_login_form_end'); ?>

        </form>


        <?php do_action('woocommerce_after_customer_login_form'); ?>

      </div>
  </div>
</div>
