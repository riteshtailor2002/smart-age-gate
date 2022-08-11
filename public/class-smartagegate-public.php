<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://axelerant.com
 * @since      1.0.0
 *
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/public
 * @author     Axelerant <ritesh.tailor@axelerant.com>
 */
class SmartAgeGate_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SmartAgeGate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SmartAgeGate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartagegate-public.css', array(), time(), 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SmartAgeGate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SmartAgeGate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/vue@2.1.js', array(), $this->version, false);




		wp_enqueue_script($this->plugin_name . 'smartagegate-public');
	}
	public function loadHTMLInFooter()
	{
?>
		<div id="age-app">
			<div class="overlay" v-if="isActive==false" :style="cssVars()">
				<div class="mainContainer">
					<div class="general_message">{{ birth_heading }}</div>
					<div class="error_message">{{ message }}</div>
					<div class="age-container">
						<div class="parent">
							<div class="child-1" v-if="child_1"></div>
							<input class="numberInput" v-model="year_1" ref="field_1" @input="checkYear_1" @focus="blink1" @blur="child_1=false" type="text">
						</div>
						<div class="parent">
							<div class="child-2" v-if="child_2"></div>
							<input class="numberInput" v-model="year_2" ref="field_2" @input="checkYear_2" @focus="blink2" @blur="child_2=false" type="text">
						</div>
						<div class="parent">
							<div class="child-3" v-if="child_3"></div>
							<input class="numberInput" v-model="year_3" ref="field_3" @input="checkYear_3" @focus="blink3" @blur="child_3=false" type="text">
						</div>
						<div class="parent">
							<div class="child-4" v-if="child_4"></div>
							<input class="numberInput" v-model="year_4" ref="field_4" @input="checkYear_4" @focus="blink4" @blur="child_4=false" type="text">
						</div>
					</div>
					<div class="remember-text">
						<div class="remember-container">
							<input type="checkbox" v-model="remember_me" value="1" />
							<span>Remember Me</span>
						</div>
						<div class="confirm-message" v-html="free_text">{{ free_text }}</div>
					</div>
				</div>
			</div>
		</div>
		<!-- age-app end-->
<?php
		$cookie_time = 30;
		$minimum_age = 18;
		$smartagegate_free_text = '';
		$smartagegate_birth_heading = '';
		$smartagegate_background_image = '';
		$smartagegate_background_color = '';
		$smartagegate_background_color_or_image = '';
		$smartagegate_settings_options = get_option('smartagegate_settings_options');
		if (isset($smartagegate_settings_options['smartagegate_cookie_time']) &&  $smartagegate_settings_options['smartagegate_cookie_time'] != '') {
			$cookie_time = $smartagegate_settings_options['smartagegate_cookie_time'];
		}
		if (isset($smartagegate_settings_options['smartagegate_minimum_age']) &&  $smartagegate_settings_options['smartagegate_minimum_age'] != '') {
			$minimum_age = $smartagegate_settings_options['smartagegate_minimum_age'];
		}
		if (isset($smartagegate_settings_options['smartagegate_free_text']) && $smartagegate_settings_options['smartagegate_free_text'] != '') {
			$smartagegate_free_text =  $smartagegate_settings_options['smartagegate_free_text'];
		}
		if (isset($smartagegate_settings_options['smartagegate_birth_heading']) && $smartagegate_settings_options['smartagegate_birth_heading'] != '') {
			$smartagegate_birth_heading =  $smartagegate_settings_options['smartagegate_birth_heading'];
		}
		if (isset($smartagegate_settings_options['smartagegate_background_image']) && $smartagegate_settings_options['smartagegate_background_image'] != '') {
			$smartagegate_background_image =  $smartagegate_settings_options['smartagegate_background_image'];
		}
		if (isset($smartagegate_settings_options['smartagegate_background_color']) && $smartagegate_settings_options['smartagegate_background_color'] != '') {
			$smartagegate_background_color =  $smartagegate_settings_options['smartagegate_background_color'];
		}
		if (isset($smartagegate_settings_options['smartagegate_background_color_or_image']) && $smartagegate_settings_options['smartagegate_background_color_or_image'] != 1) {
			$smartagegate_background_color_or_image =  0;
		}
		else {
			$smartagegate_background_color_or_image =  1;
		}

		wp_register_script($this->plugin_name . 'smartagegate-public', plugin_dir_url(__FILE__) . 'js/smartagegate-public.js');

		$script_array = array(
			'smartagegate_cookie_time' => $cookie_time,
			'smartagegate_minimum_age' => $minimum_age,
			'smartagegate_free_text' => $smartagegate_free_text,
			'smartagegate_birth_heading' => $smartagegate_birth_heading,
			'smartagegate_background_image' => $smartagegate_background_image,
			'smartagegate_background_color' => $smartagegate_background_color,
			'smartagegate_background_color_or_image' => $smartagegate_background_color_or_image,
		);
		wp_localize_script($this->plugin_name . 'smartagegate-public', 'smartagegate_object', $script_array);
	}
}
