<?php

if (! defined('ABSPATH'))
	die('Please do not directly access this file');

require_once('BFI_Thumb.php');
include_once(TEMPLATEPATH . '/functions.php');

class thesis_child_theme_example extends thesis_custom_loop {
		
	public function __construct() {
		parent::__construct();
		add_action('init', array($this, 'init'));
	}
	
	public function init() {
		// actions and filters that will run on init. you could put other things here if you need.
		$this->actions();
		$this->filters();
	}
	
	public function actions() {
		// add and remove actions here
		
		// this will force thesis to generate CSS when the user switches to the child
		add_action('after_switch_theme', 'thesis_generate_css');
		
		// modify the nav menu to exclude the div wrapper that WP defaults to
		remove_action('thesis_hook_before_header', 'thesis_nav_menu');
		add_action('thesis_hook_before_header', array($this, 'nav'));
	}
	
	public function filters() {
		// add and remove filters here
		
		/* 
		*	Filter out the standard thesis style.css. 
		*	Run this with a priority of 11 if you want to make sure the gravity forms css gets added.
		*/
		add_filter('thesis_css', array($this, 'css'), 11, 5);
	}
	
	public function css($contents, $thesis_css, $style, $multisite, $child) {
		
		// filter the Thesis generated css. in this example we're removing all the nav styles related to color
		$generated_css = $this->filter_css($thesis_css->css);
		
		/* 
		*	You can access the thesis_css object, which contains a variety of settings. 
		*	As an example, I'll show you how to access nav text color.
		*	Remember that you can always do this in style.css if you don't care about users having control over the colors 
		*/
		$my_css = "\n/*---:[ my nav menu styles ]:---*/\n" // it's always a good idea to add in comments as to what you're adding
				. ".menu li a { color: #{$thesis_css->nav['link']['color']} }\n"
				. ".menu li a:hover { color: #{$thesis_css->nav['link']['hover']} }\n\n";
		
		// put in everything except the main thesis style.css. also add an initial css reset
		$css = $thesis_css->fonts_to_import . $this->css_reset . $generated_css . $my_css . $child;
		
		// return it
		return $css;
	}
	
	public function filter_css($css) {
		if (! empty($css)) {
			
			// remove the nav colors
			if (preg_match('|/\*---:\[ nav colors \]:---\*/(\n.+){7}|i', $css))
				$css = preg_replace('|/\*---:\[ nav colors \]:---\*/(\n.+){7}|i', '', $css);
			
			// you could add more filtering here
		}		
		return $css;
	}
	
	public function nav() {
		global $thesis_site;
		if (function_exists('wp_nav_menu') && $thesis_site->nav['type'] == 'wp') { #wp
			$args = array(
				'theme_location' => 'primary',
				'container' => '',
				'fallback_cb' => 'thesis_nav_default'
			);
			wp_nav_menu($args); #wp
			echo "\n";
		}
		else
			thesis_nav_default();
	}
	
	public function home() {
		$post_count = 1;
		$teaser_count = 1;
		
		$args = array(
			'category__not_in' => array(1)
		);
		
		$home_query = new WP_Query($args);
		
		while ($home_query->have_posts()) {
			$home_query->the_post();
			
			if (apply_filters('thesis_is_teaser', thesis_is_teaser($post_count))) {
				if (($teaser_count % 2) == 1) {
					$top = ($post_count == 1) ? ' top' : '';
					$open_box = "\t\t\t<div class=\"teasers_box$top\">\n\n";
					$close_box = '';
					$right = false;
				}
				else {
					$open_box = '';
					$close_box = "\t\t\t</div>\n\n";
					$right = true;
				}

				if ($open_box != '') {
					echo $open_box;
					thesis_hook_before_teasers_box($post_count);
				}

				thesis_teaser($classes, $post_count, $right);

				if ($close_box != '') {
					echo $close_box;
					thesis_hook_after_teasers_box($post_count);
				}

				$teaser_count++;
			}
			else {
				$classes = 'post_box';

				if ($post_count == 1)
					$classes .= ' top';

				thesis_post_box($classes, $post_count);
			}

			$post_count++;
		}
		
		if ((($teaser_count - 1) % 2) == 1)
			echo "\t\t\t</div>\n\n";
	}
}

new thesis_child_theme_example;