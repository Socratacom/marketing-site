<?php

// Template Redirect
add_action('template_redirect','template_redirect');
function template_redirect() {
  if (is_home() || is_archive() || is_single() || is_search()) {
    global $wp_query;
    add_post_meta($wp_query->post->ID,'_wp_page_template','custom_template.php',TRUE);
    $wp_query->is_page = true;
  }
}

// Custom template
add_action('thesis_hook_custom_template', 'page_templates', 2);
function page_templates() {
  if(get_post_type() == '' && is_single()) require_once STYLESHEETPATH . '';
  elseif (get_post_type() == 'news' && is_single()) require_once STYLESHEETPATH . '/custom/news-single.php';
  elseif (get_post_type() == 'tribe_events' && is_single()) require_once STYLESHEETPATH . '/tribe-events/single-event.php';
  elseif (get_post_type() == 'guide' && is_single()) require_once STYLESHEETPATH . '/custom/opendata_guide/guide_template.php'; 
  elseif (get_post_type() == 'gpmp' && is_single()) require_once STYLESHEETPATH . '/custom/government_performance/gpmp_template.php'; 
  elseif (get_post_type() == 'book' && is_single()) require_once STYLESHEETPATH . '/custom/book/book_template.php';
  elseif (get_post_type() == 'case_study' && is_single()) require_once STYLESHEETPATH . '/custom/single-case-study.php';
  elseif (get_post_type() == 'stories' && is_single()) require_once STYLESHEETPATH . '/custom/single-stories.php';
  elseif (get_post_type() == 'stories' && is_archive()) require_once STYLESHEETPATH . '/custom/archive-stories.php';
  elseif (get_post_type() == 'employee_directory' && is_single()) require_once STYLESHEETPATH . '/custom/employee-directory.php';
  elseif (get_post_type() == 'tech_blog' && is_single()) require_once STYLESHEETPATH . '/custom/tech-blog.php';
  elseif (get_post_type() == 'oi_magazine' && is_single()) require_once STYLESHEETPATH . '/custom/single-magazine.php';
  elseif (is_single()) require_once STYLESHEETPATH . '/custom/blog-single.php';  
  elseif (get_post_type() == 'news' && is_archive()) require_once STYLESHEETPATH . '/custom/news-archive.php';
  elseif (is_archive()) require_once STYLESHEETPATH . '/custom/blog-archive.php';
  elseif (is_search()) require_once STYLESHEETPATH . '/custom/search.php'; 
}