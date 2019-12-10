<?php
  /**
   * Template Name: Contact US page
   *
   * @package Liveglam
   */

  get_header(); ?>
  <style type="text/css">
    input.wpcf7-form-control.wpcf7-submit.btn.btn-submit {
      margin-top: 0px;
    }

    span.wpcf7-not-valid-tip {
      margin: 20px 0px;
    }
  </style>
  <!-- contact us page -->
  <section class="contact-us text-center">
    <div class="vertical-center">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-contact-bg-left.png" class="left-image">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-contact-bg-right.png" class="right-image">
      <div class="col-md-6 offset-md-3">
        <div class="skew-bg"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/contact-us2.png" class="skew-image"></div>
        <p class="nd19-section-subtitle">If you have questions, feedback, or wanna chat, our Customer Happiness team is here to help!</p>
        <?php /*echo do_shortcode('[contact-form-7 id="10000484653" title="Contact Us"]');*/ ?>
        <form class="form-contact-us" method="post" action="">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group has-feedback has-feedback-left">
                <input type="text" class="form-control"
                       placeholder="Name" name="your_name" id="your_name"/>
<!--                <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/assets/img/icon-user.png" class="form-control-feedback icon-user">-->
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group has-feedback has-feedback-left">
                <input type="text" class="form-control"
                       placeholder="Email address" name="your_address" id="your_address"/>
<!--                <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/assets/img/icon-mail.png" class="form-control-feedback icon-email">-->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group has-feedback has-feedback-left">
                <select class="form-control selectpicker" name="your_subject" id="your_subject">
                  <option value="" disabled selected style="display: none;">Subject</option>
                  <option value="General">General</option>
                  <option value="Sales, Promos & Waitlist">Sales, Promos & Waitlist</option>
                  <option value="Account related">Account Related</option>
                  <option value="Shipping related">Shipping Related</option>
                  <option value="Billing related">Billing Related</option>
                  <option value="Product related">Product Related</option>
                  <option value="Follow up">Follow up</option>
                  <option value="Other">Other</option>
                </select>
<!--                <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/assets/img/icon-mark.png" class="form-control-feedback icon-mark">-->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group has-feedback has-feedback-left">
                <textarea class="form-control" rows="5" placeholder="Message" name="your_feedback" id="your_feedback"></textarea>
<!--                <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/assets/img/icon-chat.png" class="form-control-feedback icon-chat">-->
              </div>
            </div>
          </div>
          <div class="submit-countdown" style="display: none;">
            <input type="hidden" id="submit-countdown-time" value="0">
            <p>Please wait for <span class="time-left"></span> before you can submit another ticket.</p>
            <input type='hidden' id='form-submit-your_name' value=''>
            <input type='hidden' id='form-submit-your_address' value=''>
            <input type='hidden' id='form-submit-your_subject' value=''>
            <input type='hidden' id='form-submit-your_feedback' value=''>
          </div>

          <?php $fields = array(
              'build_id' => 'comment-form-csrf-' . base64_encode(random_bytes(32)),
              'wp_nonce' => wp_create_nonce('comment_form_csrf'),
            );
          $fields['csrf_token'] = \base64_encode(\hash_hmac('sha256', $fields['build_id'] . $fields['wp_nonce'],
            \SECURE_AUTH_KEY, true));

            foreach ($fields as $name => $value) {
              echo "<input type='hidden' name='{$name}' value='{$value}' />";
            } ?>

          <button type="submit" class="btn-primary btn-submit">Submit</button>
        </form>
        <script>
          jQuery(document).ready(function () {

            jQuery('body').on('change', 'select#your_subject', function () {
              if (jQuery('select#your_subject option:selected').val() != '') {
                jQuery('label#your_subject-error').hide();
              }
            });

            function checkemail(email) {
              email = jQuery.trim(email);
              var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              return regex.test(email);
            }

            jQuery.validator.addMethod("checkEmail", function (value, element) {
              return checkemail(value);
            }, "Please enter a valid email address.");

            jQuery('form.form-contact-us').on('submit', function () {

              jQuery('form.form-contact-us').validate({
                rules: {
                  your_name: {required: true},
                  your_address: {required: true, checkEmail: true},
                  your_subject: {required: true},
                  your_feedback: {required: true}
                },
                messages: {
                  your_name: {
                    required: "Please enter your name."
                  },
                  your_address: {
                    required: "Please enter your email.",
                    checkEmail: "Please enter a valid email address."
                  },
                  your_subject: {
                    required: "Please select subject"
                  },
                  your_feedback: {
                    required: "Please enter feedback"
                  }
                }
              });

              var your_name = jQuery('form.form-contact-us input#your_name').val(),
                your_address = jQuery('form.form-contact-us input#your_address').val(),
                your_subject = jQuery('form.form-contact-us select#your_subject option:selected').val(),
                your_feedback = jQuery('form.form-contact-us textarea#your_feedback').val(),
                build_id = jQuery('form.form-contact-us input[name="build_id"]').val(),
                wp_nonce = jQuery('form.form-contact-us input[name="wp_nonce"').val(),
                csrf_token = jQuery('form.form-contact-us input[name="csrf_token"').val();

              if (your_name && your_address && checkemail(your_address) && your_subject && your_feedback) {
                jQuery('form.form-contact-us input#form-submit-your_name').val(your_name);
                jQuery('form.form-contact-us input#form-submit-your_address').val(your_address);
                jQuery('form.form-contact-us input#form-submit-your_subject').val(your_subject);
                jQuery('form.form-contact-us input#form-submit-your_feedback').val(your_feedback);
                jQuery('button.btn-submit').prop('disabled', true);
                var data = {
                  'action': 'ajax_send_mail_contact',
                  'build_id' : build_id,
                  'wp_nonce' : wp_nonce,
                  'csrf_token' : csrf_token,
                  'your_name': your_name,
                  'your_address': your_address,
                  'your_subject': your_subject,
                  'your_feedback': your_feedback,
                  'ignore_check': 0
                };
                jQuery.post(ajaxurl, data, function (response) {
                  if (response == 'success') {
                    jQuery.magnificPopup.open({items: {src: '#contact-us-success'}, type: 'inline'});
                  } else if (response == 'spam') {
                    jQuery.magnificPopup.open({items: {src: '#contact-us-failed'}, type: 'inline'});
                  } else {
                    jQuery.magnificPopup.open({items: {src: '#contact-us-failed-send-mail'}, type: 'inline'});
                  }
                  jQuery(".mfp-content").addClass("send-email-invites-popup popup-email-invite");
                  jQuery('form.form-contact-us input#your_name').val('');
                  jQuery('form.form-contact-us input#your_address').val('');
                  jQuery('form.form-contact-us select#your_subject').val('').selectpicker('refresh');
                  jQuery('form.form-contact-us textarea#your_feedback').val('');
                  jQuery('form.form-contact-us label#your_address-error, form.form-contact-us label#your_name-error, form.form-contact-us label#your_subject-error, form.form-contact-us label#your_feedback-error').remove();
                  jQuery('input#submit-countdown-time').val(0);
                  countdown_submit_contact();
                });
              }

              return false;
            });
            jQuery('body').on('click', '.open_new_message', function () {
              jQuery.magnificPopup.close();
              jQuery.magnificPopup.open({items: {src: '#contact-us-failed2'}, type: 'inline'});
              jQuery(".mfp-content").addClass("send-email-invites-popup popup-email-invite");
            });

            jQuery('body').on('click', '.btn_submit_new_email', function () {

              /*var your_name = jQuery('form.form-contact-us input#form-submit-your_name').val(),
                your_address = jQuery('form.form-contact-us input#form-submit-your_address').val(),
                your_subject = jQuery('form.form-contact-us input#form-submit-your_subject').val(),
                your_feedback = jQuery('form.form-contact-us input#form-submit-your_feedback').val();

              var data = {
                'action': 'ajax_send_mail_contact',
                'your_name': your_name,
                'your_address': your_address,
                'your_subject': your_subject,
                'your_feedback': your_feedback,
                'ignore_check': 1
              };
              jQuery.post(ajaxurl, data, function (response) {});*/
              jQuery.magnificPopup.close();
            });

            function countdown_submit_contact() {
              var x = setInterval(function () {
                var distance = parseInt(jQuery('input#submit-countdown-time').val()),
                  total_time = distance * 1000,
                  day = Math.floor(total_time / (1000 * 60 * 60 * 24)),
                  hrs = Math.floor((total_time % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                  min = Math.floor((total_time % (1000 * 60 * 60)) / (1000 * 60)),
                  sec = Math.floor((total_time % (1000 * 60)) / 1000);

                var show_day = ( (day > 1) ? day + ' days ' : ((day == 1) ? day + ' day ' : '') );
                var show_hrs = ( (hrs > 1) ? hrs + ' hours ' : ((hrs == 1) ? hrs + ' hour ' : '') );
                var show_min = ( (min > 1) ? min + ' minutes ' : ((min == 1) ? min + ' minute ' : '') );
                var show_sec = ( (sec > 1) ? sec + ' seconds ' : ((sec == 1) ? sec + ' second ' : '') );

                if (distance < 1) {
                  clearInterval(x);
                  jQuery('.submit-countdown').hide();
                  jQuery('button.btn-submit').prop('disabled', false);
                } else {
                  var show_timer = show_day + show_hrs + show_min + show_sec;
                  jQuery(".submit-countdown .time-left").html(show_timer);
                  jQuery('input#submit-countdown-time').val(distance - 1);
                  jQuery('.submit-countdown').show();
                  jQuery('button.btn-submit').prop('disabled', true);
                }
              }, 1000);
            }
          });
        </script>
        <hr>
      </div>
    </div>

  <div class="support">
<!--    <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/assets/img/left-hand-brush.png" class="left-image">-->
<!--    <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/assets/img/IMG_contact-page_KM-hand-product-support.png" class="right-image">-->
    <div class="vertical-center">
      <h3 class="nd19-block-title">Got a question about any <br>LiveGlam products?</h3>
      <!--<h4>We might have you covered</h4>-->
      <a href="<?php echo home_url('/faq'); ?>" class="btn-secondary">Checkout our FAQ</a>
    </div>
  </div>
  </section>
  <section class="contact-options">
    <div class="vertical-center">
      <div class="container">
        <h3 class="nd19-section-title">Contact options</h3>
        <div class="row">
          <div class="col-md-4">
            <div class="ad-block">
              <hr style="display: none;">
              <p class="avg">Average</p>
              <h4>Customer Rating</h4>
              <p class="rating txt-pink customer-rating"><span class="sm">+</span>98<span class="sm percent">%</span>
              </p>
              <p class="comment">based on reviews from over 100,000 email/chat conversations</p>
            </div>
            <hr/>
            <div class="ad-block">
              <hr style="display: none;">
              <p class="avg">Average</p>
              <h4>Response Time</h4>
              <p class="rating txt-pink response-time"><span class="sm">under</span>&nbsp;30&nbsp;<span class="sm hour">min</span></p>
              <p class="comment">during our business operating hours</p>
            </div>
          </div>
          <div class="col-md-8">
            <ul class="options">
              <li>
                <div class="option-part option-type text-left">
                  <div class="social-icon">
                    <a href="mailto:support@liveglam.com" target="_blank" rel="noopener" class="email_us"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-mail.png"></a>
                  </div>
                  <p class="type">
                    <a href="mailto:support@liveglam.com" target="_blank" rel="noopener" class="email_us">Send us an
                      <span>Email</span></a></p>
                </div>
                <div class="option-part">
                  <div class="period">
                    <p>Mon-Fri<span>24 Hours</span></p>
                    <p class="timezone">PST</p>
                    <p>Sat & Sun<span>8am - 2am</span></p>
                  </div>
                </div>
                <div class="option-part">
                  <p class="response-time">Weekday response time<span>Under <strong>30 minutes</strong></span><a href="mailto:support@liveglam.com" target="_blank" rel="noopener"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-chevron-right-pink.svg" class="right-arrow"></a></p>
                </div>
              </li>
              <li>
                <div class="option-part option-type text-left">
                  <div class="social-icon">
                    <a href="javascript:$zopim.livechat.window.show()" class="chat_us"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-chat.png"></a>
                  </div>
                  <p class="type"><a href="javascript:$zopim.livechat.window.show()" class="chat_us">Live Chat
                      <span>With Us</span></a></p>
                </div>
                <div class="option-part period">
                  <div class="period">
                    <p>Mon-Fri<span>24 Hours</span></p>
                    <p class="timezone">PST</p>
                    <p>Sat & Sun<span>8am - 2am</span></p>
                  </div>
                </div>
                <div class="option-part">
                  <p class="response-time">Weekday response time<span>Under <strong>30 seconds</strong></span><a href="javascript:$zopim.livechat.window.show()"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-chevron-right-pink.svg" class="right-arrow"></a></p>
                </div>
              </li>
              <li class="">
                <div class="option-part option-type text-left">
                  <div class="social-icon">
                    <a href="sms:+1 224 877-7107" class="text_us">
                      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-phone-ctp.png" class="icon-phone">
                    </a>
                  </div>
                  <p class="type"><a href="sms:+1 224 877-7107" class="text_us">+1 224 877-7107<span class="show-mobile"> - </span><span>Text Us</span></a>
                  </p>
                </div>
                <div class="option-part period">
                  <div class="period">
                    <p>Mon-Fri<span>24 Hours</span></p>
                    <p class="timezone">PST</p>
                    <p>Sat & Sun<span>8am - 2am</span></p>
                  </div>
                </div>
                <div class="option-part">
                  <p class="response-time">Weekday response time<span>Under <strong>30 minutes</strong></span><a href="sms:+1 224 877-7107"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-chevron-right-pink.svg" class="right-arrow"></a></p>
                </div>
              </li>
              <li>
                <div class="option-part option-type text-left">
                  <div class="social-icon">
                    <a href="https://m.me/LiveGlamPro" target="_blank" rel="noopener" class="message_us"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-facebook.png" class="icon-facebook"></a>
                  </div>
                  <p class="type"><a href="https://m.me/LiveGlamCo" target="_blank" rel="noopener" class="message_us">Message us on
                      <span>Facebook</span></a></p>
                </div>
                <div class="option-part period">
                  <div class="period">
                    <p>Mon-Fri<span>8am - 1am</span></p>
                    <p class="timezone">PST</p>
                    <p>Sat & Sun<span>10am - 9pm</span></p>
                  </div>
                </div>
                <div class="option-part">
                  <p class="response-time">Weekday response time<span><strong> 1 hour</strong></span><a href="https://m.me/LiveGlamPro" target="_blank" rel="noopener"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-chevron-right-pink.svg" class="right-arrow"></a></p>
                </div>
              </li>
              <li>
                <div class="option-part option-type text-left">
                  <div class="social-icon">
                    <a href="https://twitter.com/liveglamcare" target="_blank" rel="noopener" class="tweet_us"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-twitter.png"></a>
                  </div>
                  <p class="type">
                    <a href="https://twitter.com/liveglamcare" target="_blank" rel="noopener" class="tweet_us">DM us on
                      <span>Twitter</span></a></p>
                </div>
                <div class="option-part period">
                  <div class="period">
                    <p>Mon-Fri<span>8am - 1am</span></p>
                    <p class="timezone">PST</p>
                    <p>Sat & Sun<span>10am - 9pm</span></p>
                  </div>
                </div>
                <div class="option-part">
                  <p class="response-time">Weekday response time<span>Under <strong>30 minutes</strong></span><a href="https://twitter.com/liveglamcare" target="_blank" rel="noopener"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-chevron-right-pink.svg" class="right-arrow"></a></p>
                </div>
              </li>
              <li>
                <div class="option-part option-type text-left">
                  <div class="social-icon">
                    <a href="https://www.instagram.com/liveglam.co" target="_blank" rel="noopener" class="direct_us"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon-instagram.png"></a>
                  </div>
                  <p class="type">
                    <a href="https://www.instagram.com/liveglam.co" target="_blank" rel="noopener" class="direct_us">Direct message on
                      <span>Instagram</span></a></p>
                </div>
                <div class="option-part period">
                  <div class="period">
                    <p>Mon-Fri<span>8am - 1am</span></p>
                    <p class="timezone">PST</p>
                    <p>Sat & Sun<span>10am - 9pm</span></p>
                  </div>
                </div>
                <div class="option-part">
                  <p class="response-time">Weekday response time<span>Under <strong>1 hour</strong></span><a href="https://www.instagram.com/liveglam.co" target="_blank" rel="noopener"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/newdesign-icon-chevron-right-pink.svg" class="right-arrow"></a></p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end contact us page -->

  <div class="contact-us-popup mfp-hide" id="contact-us-success">
    <div class='email_invites_header success'>
      <img class="img-check" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-check-black.svg" />
      <h2>Yasss!</h2>
    </div>
    <div class='email_invites_footer'>
      <p>We love hearing from you!<br/>We'll get back to you shortly.</p>
      <button class='btn btn-close-mfp btn-primary btn-static'>OK, GOT IT</button>
    </div>
  </div>

  <div class="contact-us-popup mfp-hide" id="contact-us-failed-send-mail">
    <div class='email_invites_header failed'>
      <img class="img-check" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg" />
      <h2>Oops.</h2>
    </div>
    <div class='email_invites_footer'>
      <p>There was an error trying to send your message. Please try again later.</p>
      <button class='btn btn-close-mfp btn-primary btn-static'>OK, GOT IT</button>
    </div>
  </div>


  <div class="contact-us-popup mfp-hide" id="contact-us-failed">
    <div class='email_invites_header failed'>
      <img class="img-check" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg" />
      <h2>FYI</h2>
    </div>
    <div class='email_invites_footer'>
      <p>Hey glammer, just a heads up, you already submitted 1 email to us today. We'll get back to you shortly, don't worry!</p>
    </div>
    <div class="email_CTA_fields">
      <button class='btn btn-close-mfp btn-primary btn-static'>OK, GOT IT</button>
      <button class='btn open_new_message btn-primary btn-static'>I HAVE MORE TO SAY!</button>
    </div>
  </div>

  <div class="contact-us-popup mfp-hide" id="contact-us-failed2">
    <div class='email_invites_header failed'>
      <img class="img-check" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/popup-cancel-black.svg" />
      <h2>WE GOT YOUR BACK.</h2>
    </div>
    <div class='email_invites_footer'>
      <p>For every new email you submit, you lose your place in line!<br/><br/>Instead, you can reply directly to the confirmation email you got after submitting your first email. That way, we'll be able to help you with everything much sooner!</p>
      <button class='btn btn_submit_new_email btn-primary btn-static'>OK, GOT IT</button>
    </div>
  </div>


<?php get_footer(); ?>