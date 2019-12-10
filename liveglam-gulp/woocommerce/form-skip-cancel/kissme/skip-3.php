<?php
  /**
   * Form KM skip 3
   */

  if ( ! defined( 'ABSPATH' ) ) {
    exit;
  }

?>
<div class='mfp-hide form-skip-cancel form-skip form-km-skip-3' id="form-km-skip-3">
  <div class="form-skip-cancel-head text-center">
    <div class="form-content">
      <p class="title">We’ll See You Next Month!</p>
      <p class="description">Let us know why you’re skipping! We would love your feedback to know what we can do better!</p>
    </div>
  </div>
  <div class="form-skip-cancel-body">
    <div class="form-content">
      <div class="form-confirmation">
        <div class="form-confirmation-reason">
          <div class="form-reason">
            <p class="reason-title">Please select a reason for wanting to skip your next lippies<span class="form_required">*</span></p>
            <div class="reason-lists hide-mobile">
              <label for="km-skip-reason-list-1">
                <input type="radio" name="submit-reason" class="submit-reason" id="km-skip-reason-list-1" value="I don’t like this month’s lippies"/>I don’t like this month’s lippies
              </label>
              <label for="km-skip-reason-list-2">
                <input type="radio" name="submit-reason" class="submit-reason" id="km-skip-reason-list-2" value="I can’t afford it right now"/>I can’t afford it right now
              </label>
              <label for="km-skip-reason-list-3">
                <input type="radio" name="submit-reason" class="submit-reason" id="km-skip-reason-list-3" value="I don’t like the lippie variety"/>I don’t like the lippie variety
              </label>
              <label for="km-skip-reason-list-4">
                <input type="radio" name="submit-reason" class="submit-reason" id="km-skip-reason-list-4" value="I am unhappy with my experience"/>I am unhappy with my experience
              </label>
              <label for="km-skip-reason-list-5">
                <input type="radio" name="submit-reason" class="submit-reason" id="km-skip-reason-list-5" value="I have too many lippies"/>I have too many lippies
              </label>
              <label for="km-skip-reason-list-6">
                <input type="radio" name="submit-reason" class="submit-reason" id="km-skip-reason-list-6" value="I have personal reasons"/>I have personal reasons
              </label>
            </div>
            <div class="reason-selected show-mobile">
              <label class="d-none" for="km-submit-reason-skip">&nbsp;</label>
              <select class="submit-reason form-control selectpicker" id="km-submit-reason-skip">
                <option value="" selected="selected" disabled>I want to skip because ...</option>
                <option value="I don’t like this month’s lippies">I don’t like this month’s lippies</option>
                <option value="I can’t afford it right now">I can’t afford it right now</option>
                <option value="I don’t like the lippie variety">I don’t like the lippie variety</option>
                <option value="I am unhappy with my experience">I am unhappy with my experience</option>
                <option value="I have too many lippies">I have too many lippies</option>
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
      </div>
    </div>
  </div>
  <div class="form-skip-cancel-footer text-center">
    <div class="form-content">
      <div class="multi-action">
        <div class="multi-action-content multi-action-left">
          <a href="#" class="btn-action btn-primary condensed stop-skip-cancel btn-static">Never mind, I don’t wanna skip</a>
        </div>
        <div class="multi-action-content multi-action-right">
          <a href="#" class="btn-action btn-secondary btn-solid btn-gray continue-skip-cancel condensed btn-static" data-product-type="kissme">Finalize skip – See ya next month</a>
          <p class="multi-action-desc">FYI your next payments will automatically resume after your skipped payment. If we're in waitlist, you won't lose your place in the club.</p>
        </div>
      </div>
    </div>
  </div>
</div>

