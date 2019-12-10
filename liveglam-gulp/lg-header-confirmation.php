
<body <?php body_class('no-subscribe'); ?>>

<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right <?php echo is_user_logged_in()?'login':'logout'; ?>">
    <?php echo liveglam_sidebar_menu(); ?>
</nav>
<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left">
    <?php echo liveglam_sidebar_menu_left(); ?>
</nav>

<div class="lgs_body_page">

<?php do_action('after_body_open_tag'); ?>

<!-- Navigation Menu -->
<nav class="nav-bar fixed-top no-subscribe nav-confirmation">
    <div class="logo-grid float-left">
        <a href="<?php echo home_url('/my-account/'); ?>">
            <h1 class="logo"><img class="logo-img" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/liveglam.svg" alt="LiveGlam header logo"></h1>
        </a>
    </div>
</nav>

<div class="mobile-nav-bar">
    <?php echo liveglam_mobile_navbar(); ?>
</div>