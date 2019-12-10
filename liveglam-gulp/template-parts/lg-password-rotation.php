<?php
  /**
   * Template Name: Password Rotation Page
   *
   * @package Liveglam
   */
  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }


get_header();

if ( !class_exists('Liveglam_Password_Rotation') ) {

	if ( is_user_logged_in() ) {
		wp_safe_redirect(site_url('my-account'));
		exit;
	}
	else {
		wp_safe_redirect(site_url());
		exit;
	}
	
}

$current_user = wp_get_current_user();
$expire = Liveglam_Password_Rotation::is_expired($current_user);

// Redirect
if ( $expire  === false ) {
	wp_safe_redirect(site_url('my-account'));
	exit;
}

?>

<div class="new-form-login pasword-rotation">
  	<div class="container">
		<div class="login-content">
			<?php if ($expire === true): ?>

			<div class="force-reset-password form-content">
				<p class="login-title nd19-hero-title">Time to brush up your account!</p>
				<p class="login-subtitle nd19-section-subtitle">Uh oh, your password has expired!</p>
				<p class="login-desc nd19-section-subtitle">In order to login and get back to the glam, please reset your password now.</p>
				<p class="form-row form-row-login mt-5 form-action">
					<a id="reset_button" class="btn-primary">Reset Password</a>
				</p>
				<div class="simplemodal-login-activity" style="display: none;"><span class="fas fa-spinner fa-pulse fa-3x fa-fw"></span></div>
			</div>

			<?php elseif ($expire !== false): ?>
			
			<div class="notify-reset-password form-content">
				<p class="login-title nd19-hero-title">Welcome Back,<br class="show-mobile"> Beautiful!</p>
				<p class="login-subtitle nd19-section-subtitle">You have <span class="remaining"><?php echo $expire; ?></span> days left to change your password.</p>
				<p class="login-desc nd19-section-subtitle">Your password is about to expire. For security, you have to reset your password every <span class="limit"><?php echo Liveglam_Password_Rotation::get_limit(); ?></span> days.</p>
				<p class="form-row form-row-login mt-5 form-action">
					<a id="reset_button" class="btn-primary">Reset Password</a>
				</p>
				<div class="no-account form-action">
					<a class="lets-fix-that skip_button" href="<?php echo !empty($_GET['redirect_to']) ? $_GET['redirect_to'] : site_url('my-account'); ?>">Skip for now</a>
				</div>
				<div class="simplemodal-login-activity" style="display: none;"><span class="fas fa-spinner fa-pulse fa-3x fa-fw"></span></div>
			</div>

			<?php endif; ?>


			<div class="reset-password-form" style="display: none;">
				<p class="login-title nd19-hero-title">Change Your Password</p>
				<div class="lg-change-password">
					<div class="lg-change-password-notice lg-notice"></div>
					<form class="edit-password lost_reset_password" action="" method="post">
					<p class="form-row form-row-wide">
						<label for="password_old"><?php _e('Old Password', 'woocommerce'); ?></label>
						<input type="password" class="input-text form-control password_old mt-2" id="password_old"
							name="password_old" placeholder="Confirm Your Previous Password"/>
					</p>
					<p class="form-row form-row-wide">
						<label for="password_1"><?php _e('New Password', 'woocommerce'); ?></label>
						<input type="password" class="input-text form-control password_new1 mt-2" id="password_1"
							name="password_new1" placeholder="Enter Your New Password"/>
					</p>
					<p class="form-row form-row-wide">
						<label for="password_2"><?php _e('Confirm Password', 'woocommerce'); ?></label>
						<input type="password" class="input-text form-control password_new2 mt-2 mb-3" id="password_2"
							name="password_new2" placeholder="Confirm Your New Password"/>
					</p>
					<p class="btn-submit-profile text-center">
						<button type="submit" class="button save_password lg-edit-button-profile btn-primary lg_vadilate_pay" name="save_password">Update Password</button>
					</p>

					<?php if ($expire !== true && $expire !== false): ?>
					<div class="no-account form-action">
						<a class="lets-fix-that skip_button" href="<?php echo !empty($_GET['redirect_to']) ? $_GET['redirect_to'] : site_url('my-account'); ?>">Skip for now</a>
					</div>
					<?php endif; ?>

					</form>
				</div>
			</div>

			<div class="success-reset-password" style="display: none;">
				<p class="login-title nd19-hero-title">Check your email for the confirmation link.</p>
				<p class="login-desc nd19-section-subtitle">A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox.</p>
				<p class="login-desc nd19-section-subtitle">Please wait at least 10 minutes before attempting another reset.</p>
			</div>

		</div>
	</div>
</div>


<?php get_footer(); ?>

<script>

jQuery(document).ready(function($) {

	$('.pasword-rotation #reset_button').on('click', function() {
		$('.form-content').hide();
		$('.reset-password-form').show();
	});

	$('body').on('keyup change','form.edit-password #password_old, form.edit-password #password_1', function () {
		lgs_validate_change_pw();
	});

	$('body').on('keyup change','form.edit-password #password_2', function () {
		var password_1 = $('form.edit-password input#password_1').val(),
			password_2 = $('form.edit-password input#password_2').val(),
			current_element = $('form.edit-password #password_2').closest('p');

		if( password_1 != password_2 && password_2 ){
			current_element.addClass('woocommerce-invalid woocommerce-invalid-required-field');
			current_element.find('input').addClass('ErrorField');
			current_element.find('#password_2-error').remove();
			current_element.append('<label id="password_2-error" class="error" for="password_2">Please enter the same password as above</label>');
		} else {
			current_element.removeClass('woocommerce-invalid woocommerce-invalid-required-field');
			current_element.find('input').removeClass('ErrorField');
			current_element.find('#password_2-error').remove();
		}
		lgs_validate_change_pw();
	});

	function lgs_validate_change_pw() {
		var password_old = $('form.edit-password input#password_old').val(),
			password_1 = $('form.edit-password input#password_1').val(),
			password_2 = $('form.edit-password input#password_2').val();
		var password_strong = 0;
		if( $('form.edit-password .woocommerce-password-strength').hasClass('good') || $('form.edit-password .woocommerce-password-strength').hasClass('strong') ){
			password_strong = 1;
		}
		if (password_old && password_1 && password_2 && password_1 == password_2 && password_strong == 1) {
			$('form.edit-password .lg-edit-button-profile').removeClass('lg_vadilate_pay');
		} else {
			$('form.edit-password .lg-edit-button-profile').addClass('lg_vadilate_pay');
		}
	}

	$('form.edit-password').on('submit', function () {
		var password_old = $('form.edit-password input#password_old').val(),
			password_new1 = $('form.edit-password input#password_1').val(),
			password_new2 = $('form.edit-password input#password_2').val();
		if (password_old && password_new1 && password_new2) {
			$('form.edit-password').find('.save_password.lg-edit-button-profile').html('<i class="fas fa-circle-notch fa-spin fa-lg fa-fw"></i> Updating ...').addClass('ch_background').prop("disabled", true);

			var data = {
				'action': 'lg_action_update_password',
				'password_old': password_old,
				'password_new1': password_new1,
				'password_new2': password_new2
			};
			$.post(ajaxurl, data, function (response) {
				$('.lg-change-password-notice').removeClass('woocommerce-error woocommerce-message').addClass(response.class).text(response.message);
				$('form.edit-password input#password_old').val('');
				$('form.edit-password input#password_1').val('');
				$('form.edit-password input#password_2').val('');
				setTimeout(function () {
					$('.lg-change-password-notice').removeClass('woocommerce-error woocommerce-message').text('');
				},10000);
				$('form.edit-password').find('.save_password.lg-edit-button-profile').text('Update Password').removeClass('ch_background').prop("disabled", false);

				if (response.class === 'woocommerce-message') location.reload();
			}, 'json');
		}
		return false;
	});
});

</script>