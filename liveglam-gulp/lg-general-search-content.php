<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
} ?>

<div class="lg-search-layout">
    <div class="lg-search-layout-header">
        <div class="lg-search-layout-header__inner">
            <div class="lg-search-search-box-wrapper">
                <div class="container">
                    <form class="lg-search-search-box" method="get" class="search-form" action="<?php echo home_url(); ?>">
                        <input class="lg-search-search-box__text-input" name="s" type="text" placeholder="Search LiveGlam.com" value="">
                        <img class="icon" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header-search.png">
                        <div class="loading d-none spinner-border text-secondary" style="width: 2rem; height: 2rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </form>
                    <?php if ( $show_close_button ): ?><div class="lg-search-search-box__close">×</div><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="lg-search-layout-body">
        <div class="container">
            <!-- <div class="lg-search-paging-info d-none">11 results found</div> -->
            <div class="lg-search-layout-body__inner">
                <div class="lg-search-layout-sidebar"></div>
                
                <div class="lg-search-layout-main">
                    <div class="lg-search-layout-main-header">
                        <div class="lg-search-layout-main-header__inner"></div>
                    </div>
                    <div class="lg-search-layout-main-body">
                        <div class="results-container">
                            <div class="search-zero-state">Find anything about our clubs, products, blog posts and FAQs.</div>
                            <div class="empty-search-state d-none">Oops! There is nothing to search. Please type something to search for.<span></span></div>
                           
                            <div class="no-result no-result--no-sidebar d-none">
                                <div class="no-result-main">Oops! We couldn't find any result for: <span></span></div>
                                <hr>
                                <div class="no-result-suggestion">If you'd like, we have a dedicated team of Costomer Happiness reps that are ready to help you out!</div>
                                <a href="<?php echo home_url('contact-us'); ?>">Get in touch ></a>
                            </div>
                            
                            <div class="lg-search-results-container">
                            </div>

                            <div class="lg-search-pagination"></div>
                        </div>
                    </div>
                    <div class="lg-search-layout-main-footer"></div>
                </div>
            </div>
        </div>
    </div>
</div>

    
