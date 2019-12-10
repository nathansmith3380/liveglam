<?php
  /**
   * Form SM cancel 4
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-cancel form-sm-cancel-4' id="form-sm-cancel-4">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">We Hope To See You Back Someday!</p>
      <p class="description">Help us brush up our skills- what’s one thing we could’ve done better?</p>
    </div>
  </div>
  <div class="form-skip-cancel-body">
    <div class="form-content">
      <div class="form-confirmation">
        <div class="form-confirmation-reason">
          <div class="form-reason">
            <p class="reason-title">Please select a reason for canceling your membership<span class="form_required">*</span></p>
            <div class="reason-lists hide-mobile">
              <label for="sm-cancel-reason-list-1">
                <input type="radio" name="submit-reason" class="submit-reason" id="sm-cancel-reason-list-1" value="I don’t like this month’s palette"/>I don’t like this month’s palette
              </label>
              <label for="sm-cancel-reason-list-2">
                <input type="radio" name="submit-reason" class="submit-reason" id="sm-cancel-reason-list-2" value="I can’t afford it right now"/>I can’t afford it right now
              </label>
              <label for="sm-cancel-reason-list-3">
                <input type="radio" name="submit-reason" class="submit-reason" id="sm-cancel-reason-list-3" value="I don’t like the shades variety"/>I don’t like the shades variety
              </label>
              <label for="sm-cancel-reason-list-4">
                <input type="radio" name="submit-reason" class="submit-reason" id="sm-cancel-reason-list-4" value="I am unhappy with my experience"/>I am unhappy with my experience
              </label>
              <label for="sm-cancel-reason-list-5">
                <input type="radio" name="submit-reason" class="submit-reason" id="sm-cancel-reason-list-5" value="I have too many eyeshadows"/>I have too many eyeshadows
              </label>
              <label for="sm-cancel-reason-list-6">
                <input type="radio" name="submit-reason" class="submit-reason" id="sm-cancel-reason-list-6" value="I have personal reasons"/>I have personal reasons
              </label>
            </div>
            <div class="reason-selected show-mobile">
              <label class="d-none" for="sm-submit-reason-cancel">&nbsp;</label>
              <select class="submit-reason form-control selectpicker" id="sm-submit-reason-cancel">
                <option value="" selected="selected" disabled>I want to cancel because ...</option>
                <option value="I don’t like this month’s palette">I don’t like this month’s palette</option>
                <option value="I can’t afford it right now">I can’t afford it right now</option>
                <option value="I don’t like the shades variety">I don’t like the shades variety</option>
                <option value="I am unhappy with my experience">I am unhappy with my experience</option>
                <option value="I have too many eyeshadows">I have too many eyeshadows</option>
                <option value="I have personal reasons">I have personal reasons</option>
              </select>
            </div>
            <p class="notice-error-validate">This is field required. Please select a reason ... </p>
          </div>
        </div>
        <div class="form-confirmation-comment">
          <div class="form-comment">
            <textarea class="submit-comment" placeholder="Enter your comments or suggestion here…"></textarea>
            <p class="notice-error-validate">This is field required. Please enter the comments ... </p>
          </div>
        </div>

        <?php if($active_type_sm == 'monthly'){ ?>
          <p class="form-confirmation-notice sm-form-confirmation-notice">FYI! If you cancel your membership and want to reactivate within 30 days, you will not have the option for a free product at checkout!</p>
        <?php } ?>
        <p class="form-confirmation-contact">Have an issue? We’re here to help. Our customer happiness team is standing by to help you. <a href="<?php echo home_url('contact-us'); ?>" class="email_us">Contact support</a></p>
      </div>
    </div>
  </div>
  <div class="form-skip-cancel-footer text-center">
    <div class="form-content">
      <div class="multi-action">
        <div class="multi-action-content multi-action-left">
          <a href="#" class="btn-action btn-primary condensed stop-skip-cancel btn-static">Never mind, I don’t wanna cancel</a>
        </div>
        <div class="multi-action-content multi-action-right">
          <a href="#" class="btn-action btn-secondary btn-solid btn-gray continue-skip-cancel condensed btn-static" data-product-type="kissme">Finalize cancelation – TTYL</a>
          <p class="multi-action-desc">FYI you will lose your place in the club by canceling and you could be subject to waitlist if you decide to rejoin.</p>
        </div>
      </div>
    </div>
  </div>
</div>

