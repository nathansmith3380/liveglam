</div><!--end pg-dashboard-->

<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery( '.list-content .item-content.'+jQuery('.dashboard-select-month option:selected').val() ).addClass('active');
        jQuery('body').on( 'change', 'select.dashboard-select-month', function () {
            jQuery('.list-content .item-content.active').removeClass('active');
            jQuery('.list-content .item-content.'+jQuery(this).val() ).addClass('active');
          reload_heigh_monthly_post();
            return false;
        });
      jQuery( window ).resize(function() {
        reload_heigh_monthly_post();
      });
      reload_heigh_monthly_post();
      function reload_heigh_monthly_post() {
        var tutor = jQuery('.item-content.active .tutor'),
          section_video = tutor.find('.section-video'),
          section_blogs = tutor.find('.section-blogs'),
          video_title = section_video.find('.tutor-video-title'),
          video_desc = section_video.find('.tutor-video-desc'),
          blogs_title = section_blogs.find('.tutor-blogs-title'),
          blogs_desc = section_blogs.find('.tutor-blogs-desc');

        video_title.css('min-height','');
        video_desc.css('min-height','');
        blogs_title.css('min-height','');
        blogs_desc.css('min-height','');

        var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        if( width < 767 ) {
          return false;
        }

        if(tutor.length > 0 && section_video.length > 0 && section_blogs.length > 0){
          var height_title = (video_title.height() > blogs_title.height())?video_title.height():blogs_title.height(),
            height_desc = (video_desc.height() > blogs_desc.height())?video_desc.height():blogs_desc.height();
          video_title.css('min-height',height_title);
          video_desc.css('min-height',height_desc);
          blogs_title.css('min-height',height_title);
          blogs_desc.css('min-height',height_desc);
        }
      }
    });
</script>

<!-- #1714 Add param to auto start playing the video on monthly_post page -->
<?php if( isset($_GET['play_monthly_video']) ) { ?>
  <script type="text/javascript">
    jQuery(document).ready(function ($) {
      $(window).load(function() {
        $('.list-content .item-content:visible .section-video .btn-play').click();
      });
    });
  </script>
<?php } ?>

<?php //wp_footer(); ?>

</div><!--end div lgs_body_page-->

</body>
</html>