<?php
  /**
   * Template Name: General Search Page
   *
   * @package Liveglam
   */
  if(!defined('ABSPATH')){
    exit; // Exit if accessed directly
  }

  get_header(); ?>

<div id="lg-search-page"><?php show_general_search_content(false); ?></div>

<?php get_footer(); ?>

