<?php
$order = new WC_Order($_GET['order_id']);
if( $order !== false ) {
    $revenue = $order->get_total();
    $products_cnt = $order->get_item_count();

    if ($revenue > 0) { ?>
        <script type="text/javascript">
            var revenue = "<?php echo $revenue; ?>",
                products_cnt = "<?php echo $products_cnt; ?>";
            window._conv_q = window._conv_q || [];
            _conv_q.push(["pushRevenue", revenue, products_cnt, "100121082"]);
        </script>

                        <?php
    }
} ?>

<?php //wp_footer();
  if(isset($_COOKIE['cookie_payment_failed']))setcookie('cookie_payment_failed',null, time() - HOUR_IN_SECONDS, '/');
  if(isset($_COOKIE['cookie_payment_reactive']))setcookie('cookie_payment_reactive',null, time() - HOUR_IN_SECONDS, '/');
  if(isset($_COOKIE['rd_page_upgrade']))setcookie('rd_page_upgrade',null, time() - HOUR_IN_SECONDS, '/');
  if(isset($_COOKIE['rd_page_upgrade_to_annual']))setcookie('rd_page_upgrade_to_annual',null, time() - HOUR_IN_SECONDS, '/');
  if(isset($_COOKIE['liveglam_save_discount_referral']))setcookie('liveglam_save_discount_referral',null, time() - HOUR_IN_SECONDS, '/');

  //remove all cookie give free product after checkout
  if(isset($_COOKIE['_lgs_save_name_ref']))setcookie('_lgs_save_name_ref',null, time() - HOUR_IN_SECONDS, '/');

  if(isset($_COOKIE['cookie_givefp']))setcookie('cookie_givefp', null, time() - HOUR_IN_SECONDS, '/');
?>

</div><!--end div lgs_body_page-->

</body>
</html>