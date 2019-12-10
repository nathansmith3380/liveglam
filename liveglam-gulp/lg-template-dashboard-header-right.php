<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
} ?>


<div class="header-right">
  <ul>
      <?php if (get_field('enable_search', 'option')): ?>
      <li>
          <a class="btn-search">
            <img alt="Search Logo" class="logo-search active" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header-search.png">
            <img alt="Search Logo" class="logo-search inactive" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header-search-inactive.png">
          </a>
      </li>
      <?php endif; ?>

      <li class="dropdown-cart-bag">
          <a href="#" class="dropbtn">
            <img alt="Shop bag" class="active" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header-shop-bag.png" />
            <img alt="Shop bag" class="inactive" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header-shop-bag-inactive.png" />
              <span class="cart_bag count_items">0</span>
          </a>
          <div class="dropdown-content cart_bag cart_bag_desktop cart_content d-none"></div>
      </li>
  </ul>
</div>