<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.x.fr
 * @since      1.0.0
 *
 * @package    Posts_Reading_Time
 * @subpackage Posts_Reading_Time/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Posts_Reading_Time
 * @subpackage Posts_Reading_Time/includes
 * @author     Stéphane Deluce <boluge@gmail.com>
 */
class Posts_Reading_Time_Calc {

	private $options;
	private $wpm;
	private $position;
	private $page;
	private $display;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$default = array(
			'prtime_wpm' => '200',
			'prtime_position' => '1',
			'prtime_page' => array(
				'is_category()',
				'is_archive()'
			),
			'prtime_display' => '1'
		);

		$this->options = get_option('prtime_options', $default);

		$this->wpm = $this->options['prtime_wpm'];
		$this->position = $this->options['prtime_position'];
		$this->page = implode(" || ", $this->options['prtime_page']);
		$this->display = $this->options['prtime_display'];

		var_dump($this->page);

	}

	public static function display_readingtime( $content ) {

		$nb_words = str_word_count(strip_tags( $content ));
		$wpm = $this->wpm;

		$minutes = floor( $nb_words / $wpm );
		$seconds = floor( $nb_words % $wpm / ($wpm / 60) );

		if( $this->display == 1 ){
			if( $seconds > 30 ){
				$minutes++;
			}
			$time = $minutes.' min';
		} else {
			if ( $seconds < 10){
				$seconds = '0'.$seconds;
			}
			$time = $minutes.':'.$seconds.' sec';
		}
		return '<div class="reading_time">'.$time.'</div>';
	}

	public static function display( $content ){
		//if( $this->page ){

			if( $this->position == 1 ){

				$display_content = self::display_readingtime($content);
				$display_content .= $content;

			} else {

				$display_content = $content;
				$display_content .= self::display_readingtime($content);

			}
			return $display_content;
		//}
	}
}


	

	// function before_the_content( $content ) {

	// 	//$rtime = new Posts_Reading_Time_Calc();
		
	// 	$before_content = $rtime->display_time( $content );
	// 	$before_content .= $content;

	// 	return $before_content;

	// }
	// add_filter( 'the_content', 'before_the_content' );

	/*function after_the_content( $content ) {
			$after_content = $content;
			$after_content .= '<div class="read">YOUR CONTENT GOES HERE</div>';
			return $after_content;
		}
		add_filter( 'the_content', 'after_the_content' );

		function before_the_excerpt( $excerpt ) {
			$before_excerpt = '<p class="read">YOUR CONTENT GOES HERE</p>';
			$before_excerpt .= $excerpt;
			return $before_excerpt;
		}
		add_filter( 'the_excerpt', 'before_the_excerpt' );

		function after_the_excerpt( $excerpt ) {
			$after_excerpt = $excerpt;
			$after_excerpt .= '<p class="read">YOUR CONTENT GOES HERE</p>';
			return $after_excerpt;
		}
		add_filter( 'the_excerpt', 'after_the_excerpt' );*/
	/*public function post_read_time() {
	
		$post_id = get_the_ID();

		var_dump($post_id);
		
		$content = apply_filters('the_content', get_post_field('post_content', $post_id));
		$num_words = str_word_count(strip_tags($content));
		$minutes = floor($num_words / $words_per_second_option);
		$seconds = floor($num_words % $words_per_second_option / ($words_per_second_option / 60));
		$estimated_time = $prefix;
		if($time == "1") {
			if($seconds >= 30) {
				$minutes = $minutes + 1;
			}
			$estimated_time = $estimated_time.' '.$minutes . ' minute'. ($minutes == 1 ? '' : 's');
		}
		else {
			$estimated_time = $estimated_time.' '.$minutes . ' minute'. ($minutes == 1 ? '' : 's') . ', ' . $seconds . ' second' . ($seconds == 1 ? '' : 's');		
		}
		if($minutes < 1) {
			$estimated_time = $estimated_time." Less than a minute";
		}

		$estimated_time = $estimated_time.$suffix;
		
		echo $estimated_time;

	}*/
