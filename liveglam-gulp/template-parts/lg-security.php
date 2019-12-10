<?php
/**
 * Template Name: Security Page
 *
 * @package Liveglam
 */

$current_page = get_the_ID();

// Get pages using this securify template to show them as link boxes in the hero
$security_pages = get_posts(array(
    'post_type'     => 'page',
    'fields'        => 'ids',
    'orderby'       => 'menu_order',
    'order'         => 'ASC',
    'meta_key'      => '_wp_page_template',
    'meta_value'    => 'template-parts/lg-security.php'
));

// Get Custom Field Values
$is_general_page    = get_field('general_page');
$refer_to_the_title = get_field('refer_to_the_title');
$last_modified      = get_field('last_modified');
$show_controls      = get_field('show_controls');

// Get Controls Value
if ( $show_controls && is_user_logged_in() ) {

    $current_user = wp_get_current_user();

    $trans_email = get_user_meta($current_user->ID,'_lg_transaction_email', true);
    if ( empty($trans_email) ) {
        wpMandrill::getConnected();
        $result = wpMandrill::$mandrill->request('rejects/list', array('email' => $current_user->user_email));
        $result = empty($result) ? 'True' : 'False';
        update_user_meta($current_user->ID,'_lg_transaction_email', $result);
    }

    $mailchimp = get_user_meta($current_user->ID,'_lg_mailchimp_status',true);
    if ( empty($mailchimp) ) {
        $mailchimp = apply_filters('lg_get_mailchimp_status', 'subscribed');
        update_user_meta($current_user->ID,'_lg_mailchimp_status', $mailchimp);
    }
    
    $in_twilio_bl = !empty(get_user_meta($current_user->ID,'_lg_twilio_blacklist',true)) ? true : false;
    if ( !$in_twilio_bl && !empty($twilio_bl = get_option('twilio_blacklist')) ) {
        if ( in_array($current_user->ID, $twilio_bl) ){
            $in_twilio_bl = true;
            update_user_meta($current_user->ID,'_lg_twilio_blacklist',1);
        }
    }
}

get_header(); ?>

<div class="security-hero">
    <div class="container">
        <div class="skew-bg"><div class="hero-title nd19-hero-title">Security</div></div>
        <div class="flex-group">
            <?php foreach ($security_pages as $page): if (get_field('general_page', $page)) continue; ?>
            <a class="flex-item <?php echo is_page($page) ? 'active' : ( $is_general_page ? '' : 'd-desktop' ); ?>" href="<?php echo get_permalink($page); ?>">
                <img class="link-logo d-desktop" src="<?php echo get_field('logo_image', $page); ?>">
                <div class="link-title nd19-block-content"><?php echo get_the_title($page); ?></div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php if (!$is_general_page): ?>
<div class="security-content">
    <div class="container">

        <div class="page-title d-desktop nd19-section-title"><?php echo get_the_title(); ?></div>
        <hr>
        
        <!-- Show the page content -->
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
            the_content();
        endwhile; endif; ?>

        <!-- Show Controls Section -->
        <?php if ($show_controls): ?>
            <hr>
            <div class="content-title" id="control-options">How To Control What Personal Data You Provide</div>
            <p>If you have an account on this site, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us directly or that gathered as a result of your willing transactions/engagement with us (as discussed in this policy.) You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p>

            <table class="nd19-block-content">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Opt out/in of any tracking initiated by personalization experiences from LiveGlam.com</td>
                        <td>
                            <div class="checkbox_field">
                                <a href="<?php echo home_url('/privacy-policy?convert_optout=1');?>" id="convert_optout" class="button d-none">Opt Out.</a>
                                <a href="<?php echo home_url('/privacy-policy?convert_canceloptout=1');?>" id="convert_canceloptout" class="button d-none">Opt in.</a>
                                <input type="checkbox" name="action_optout_in" id="action_optout_in" class="gpdr-checkbox-custom gpdr-toggle d-none" <?php echo empty($_COOKIE['convert_optout'])?'checked': ''; ?>/>
                                <label for="action_optout_in" class="checkbox-label action_optout_in"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Opt out/in of any tracking initiated by google anlytics</td>
                        <td>
                            <div class="checkbox_field">
                                <input type="checkbox" name="action_ga_optout_in" id="action_ga_optout_in" class="gpdr-checkbox-custom gpdr-toggle d-none" <?php echo empty($_COOKIE['ga-disable-'.ga_get_option('ga_id')])?'checked': ''; ?>/>
                                <label for="action_ga_optout_in" class="checkbox-label action_ga_optout_in"></label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php if (!is_user_logged_in()): ?>
                <p>If you are logged in then you will be provided with the option below to opt in/out of different communication and notification services and ability to request account deletion and data erasure.</p>
                <p><a href="<?php echo home_url('/my-account/'); ?>" class="simplemodal-login">Please login</a> if you are a customer.</a></p>
            <?php else: ?>
                <p>Following are the options to opt out/in of different communication and notification services and ability to request account deletion and data erasure.</p>
            <?php endif; ?>

            <?php if(is_user_logged_in()): ?>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <label class="nd19-block-content" for="action_twilio_notifications">SMS Notifications
                            <a href="#" data-toggle="tooltip" title="We recommend you remain subscribed to transactional sms notifications, as these are often related to your purchases, account information, and any transaction you made on our site (including any abandoned transactions).">
                            <i class="fas fa-info-circle" aria-hidden="true"></i></a>
                            </label>
                        </td>
                        <td>
                            <div class="checkbox_field">
                                <input type="checkbox" name="action_twilio_notifications" id="action_twilio_notifications" class="gpdr-checkbox-custom gpdr-toggle d-none" value="twilio" name="action" <?php echo !$in_twilio_bl?'data-action_type="unsubscribed" checked':'data-action_type="subscribed" '; ?>/>
                                <label for="action_twilio_notifications" class="checkbox-label"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label  class="nd19-block-content" for="action_mandrill">Transactional emails
                            <a href="#" data-toggle="tooltip" title="We recommend you remain subscribed to transactional e-mail notifications, as these are often related to your purchases, account information, and any transaction you have made on our site (including any abandoned transactions.)">
                            <i class="fas fa-info-circle" aria-hidden="true"></i></a></label>
                        </td>
                        <td>
                            <div class="checkbox_field">
                                <input type="checkbox" name="action_mandrill" id="action_mandrill" class="gpdr-checkbox-custom gpdr-toggle d-none" value="mandrill" name="action" <?php echo empty($result)||$result=='True'?'checked':''; ?>/>
                                <label  for="action_mandrill" class="checkbox-label"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="nd19-block-content" for="action_mailchimp">Marketing emails</label></td>
                        <td>
                            <div class="checkbox_field">
                                <input type="checkbox" name="action_mailchimp" id="action_mailchimp" class="gpdr-checkbox-custom gpdr-toggle d-none" value="mailchimp" name="action" <?php echo $mailchimp != 'subscribed'?'data-action_type="add" ':'data-action_type="delete" checked'; ?>/>
                                <label for="action_mailchimp" class="checkbox-label"></label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="nd19-block-content" >Request a copy of your personal data</label></td>
                        <td><button class="btn-primary btn-sm" id="action_personal_data" value="action_personal_data">Request</button></td>
                    </tr>
                    <tr>
                        <td><label class="nd19-block-content" >Request to Erase your data</label></td>
                        <td><button class="btn-primary btn-sm" id="action_erase_data" value="remove_personal_data">Request</button></td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>
        <?php endif; ?>

        <hr>

        <!-- Show changes / contact section -->
        <div class="content-title">Changes To Our <?php echo get_the_title(); ?></div>
        <p>If we decide to change our <?php echo $refer_to_the_title; ?>, we will update the <?php echo $refer_to_the_title; ?> modification date below.<br>
        This policy was last modified on <?php echo $last_modified; ?></p>

        <hr>

        <div class="content-title">Contacting Us</div>
        <p>If there are any questions regarding our <?php echo $refer_to_the_title; ?>, you may contact us using the information below:</p>
        <p>
            LiveGlam Inc.<br>
            705 W. 9th St.<br>
            Los Angeles, CA 90015<br>
            USA<br>
            Email: <a href="mailto:support@liveglam.com">support@liveglam.com</a>
        </p>
    </div>
</div>

<div class="security-links d-mobile">
    <div class="container">
    <?php foreach ($security_pages as $page):
        if (is_page($page) || get_field('general_page', $page)) continue; ?>
        <a class="link nd19-block-content" href="<?php echo get_permalink($page); ?>"><?php echo get_the_title($page); ?></a>
    <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>



    <!-- Action Success Dialog -->
    <div id="security_action_result" class="mfp-hide form_process">
        <div class="result_content">
        <div class="result_title">
            <img src="<?php echo get_stylesheet_directory_uri()?>/assets/img/green-check.png">
        </div>
        <div class="result_message"></div>
        </div>
    </div>
    </div>

    <?php
        function ga_get_option($key) {
            $aga_options = array();
            $aga_optimize = array();
            $aga_conversion = array();
            $aga_advance_track = array();
            $aga_purchase_code = array();

            if (!empty(unserialize(get_option('aga_options')))) {
                $aga_options = unserialize(get_option('aga_options'));
            }
            if (!empty(unserialize(get_option('aga_optimize_settings')))) {
                $aga_optimize = unserialize(get_option('aga_optimize_settings'));
            }
            if (!empty(unserialize(get_option('aga_conversion_settings')))) {
                $aga_conversion = unserialize(get_option('aga_conversion_settings'));
            }
            if (!empty(unserialize(get_option('aga_advanced_tracking_settings')))) {
                $aga_advance_track = unserialize(get_option('aga_advanced_tracking_settings'));
            }
            if (!empty(unserialize(get_option('aga_purchase_code')))) {
                $aga_purchase_code = unserialize(get_option('aga_purchase_code'));
            }
            $aga_admin_settings = array_merge($aga_options, $aga_optimize, $aga_conversion, $aga_advance_track, $aga_purchase_code);
            if (isset($aga_admin_settings[$key])) {
                return $aga_admin_settings[$key];
            }
        }
        $tracking_id = ga_get_option('ga_id');
    ?>

    <script>
        var disableStr = 'ga-disable-' + '<?php echo $tracking_id; ?>';
        function gaOptin() {
            Cookies.remove(disableStr);
            window[disableStr] = false;
        }

        jQuery(document).ready(function () {
            jQuery('body').on('click','.action_ga_optout_in',function(){
                jQuery('#action_ga_optout_in').is(':checked') ? gaOptout() : gaOptin();
            });

            jQuery('#action_mailchimp').click(function () {
                jQuery(this).parent().find('label').css('pointer-events', 'none');
                var data = {
                    'action': 'lg_gdpr_mailchimp_communication',
                    'current_status': '<?php echo $mailchimp;?>'
                };
                
                jQuery.post(window.ajaxurl, data, function (response) {
                    (response == 'unsubscribed')
                        ? jQuery('#security_action_result .result_message').text('Successfully unsubscribed from makerting email communications.')
                        : jQuery('#security_action_result .result_message').text('Successfully subscribed to makerting email communications.');

                    jQuery.magnificPopup.open({
                        items: { src: '#security_action_result' },
                        type: 'inline',
                        callbacks: {
                            close: function () {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            });

            jQuery('#action_mandrill').click(function () {
                jQuery(this).parent().find('label').css('pointer-events', 'none');
                var data = {
                    'action': 'lg_gdpr_mandrill_communication'
                };

                jQuery.post(window.ajaxurl, data, function (response) {
                    (response.deleted == true)
                        ? jQuery('#security_action_result .result_message').text('Successfully subscribed from transactional email communications.')
                        : jQuery('#security_action_result .result_message').text('Successfully unsubscribed to transactional email communications.');

                    jQuery.magnificPopup.open({
                        items: { src: '#security_action_result' },
                        type: 'inline',
                        callbacks: {
                            close: function () {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            });

            jQuery('.action_optout_in').click(function() {
                jQuery('#action_optout_in').is(':checked')
                    ? window.location = jQuery('#convert_optout').attr('href')
                    : window.location = jQuery('#convert_canceloptout').attr('href');
            });

            jQuery('#action_twilio_notifications').click(function () {
                jQuery(this).parent().find('label').css('pointer-events', 'none');
                var data = {
                    'action': 'lg_gdpr_twilio_notifications',
                    'action_type': jQuery(this).data('action_type'),
                    'user_id': <?php echo $current_user->ID;?>
                };

                jQuery.post(window.ajaxurl, data, function (response) {
                    (response.subscribed == 'unsubscribed')
                        ? jQuery('#security_action_result .result_message').text('Successfully unsubscribed from SMS marketing communications.')
                        : jQuery('#security_action_result .result_message').text('Successfully subscribed to SMS marketing communications.');

                    jQuery.magnificPopup.open({
                        items: {src: '#security_action_result'},
                        type: 'inline',
                        callbacks: {
                            close: function () {
                                location.reload();
                            }
                        }
                    });
                }, 'json');
            });

            jQuery('#action_personal_data').click(function () {
                var request_id = '',
                    security = '',
                    sendAsEmail = '',
                    exportersCount = '';
                var data = {
                    'action': 'lg_gdpr_create_request',
                    'action_type': 'export_personal_data'
                };
                jQuery.post(window.ajaxurl, data, function (response) {
                    // And now, let's begin
                    request_id = response.request_id;
                    security = response.nonce;
                    sendAsEmail = response.send_as_email;
                    exportersCount = response.data_count;
                    doNextExport(1, 1);
                    if (response.request_id != null || response.request_id != undefined) {
                        jQuery('#security_action_result .result_message').text('We just sent your data via email. Please check your email!');
                    }
                    jQuery.magnificPopup.open({
                        items: {src: '#security_action_result'},
                        type: 'inline',
                    });
                }, 'json');

                function doNextExport(exporterIndex, pageIndex) {

                    jQuery.ajax(
                    {
                        url: window.ajaxurl,
                        data: {
                        action: 'wp-privacy-export-personal-data',
                        exporter: exporterIndex,
                        id: request_id,
                        page: pageIndex,
                        security: security,
                        sendAsEmail: sendAsEmail
                        },
                        method: 'post'
                    }
                    ).done(function (response) {
                        var responseData = response.data;

                        if (!response.success) {
                            return;
                        }

                        if (!responseData.done) {
                            setTimeout(doNextExport(exporterIndex, pageIndex + 1));
                        } else {
                            if (exporterIndex < exportersCount) {
                                setTimeout(doNextExport(exporterIndex + 1, 1));
                            }
                        }
                    });
                }
            });

            jQuery('#action_erase_data').click(function () {
                var request_id = '',
                    security = '',
                    erasersCount = '';
                var data = {
                    'action': 'lg_gdpr_create_request',
                    'action_type': 'remove_personal_data'
                };
                jQuery.post(window.ajaxurl, data, function (response) {
                    // And now, let's begin
                    request_id = response.request_id;
                    security = response.nonce;
                    erasersCount = response.data_count;
                    if (response.request_id != null || response.request_id != undefined) {
                        jQuery('#security_action_result .result_message').text('Request successful! We have sent your request for data erasure to data protection officer. You will receive a reply soon.');
                    }
                    jQuery.magnificPopup.open({
                        items: {src: '#security_action_result'},
                        type: 'inline',
                    });
                }, 'json');
            });
        });
    </script>

<?php get_footer(); ?>