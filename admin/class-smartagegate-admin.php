<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://axelerant.com
 * @since      1.0.0
 *
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/admin
 * @author     Axelerant <ritesh.tailor@axelerant.com>
 */
class SmartAgeGate_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action('admin_menu', array($this, 'smartagegate_admin_menu'));
		add_action('admin_init', array($this, 'register_smartagegate_settings'));
	}
	/**
	 * Register the admin menu.
	 *
	 * @since    1.0.0
	 */
	public function smartagegate_admin_menu() {
		add_menu_page(
			__('Settings', 'smartagegate-settings'),
			__('Smart Age Gate', 'smartagegate-settings'),
			'manage_options',
			'smartagegate_settings',
			array($this, 'smartagegate_settings_html')
		);
	}
	public function smartagegate_settings_html() {
		// check user capabilities
		if (!current_user_can('manage_options')) {
			return;
		}

		// add error/update messages

		// check if the user have submitted the settings
		// WordPress will add the "settings-updated" $_GET parameter to the url
		if (isset($_GET['settings-updated'])) {
			// add settings saved message with the class of "updated"
			add_settings_error('smartagegate_settings_messages', 'smartagegate_settings_message', __('Settings Saved', 'smartagegate_settings'), 'updated');
		}

		// show error/update messages
		settings_errors('smartagegate_settings_messages');
		?>
		<div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wporg"
            settings_fields( 'smartagegate' );
            // output setting sections and their fields
            // (sections are registered for "wporg", each field is registered to a specific section)
            do_settings_sections( 'smartagegate' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
	<?php
	} 
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is used to load all the css needed in this plugin in wp-admin.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SmartAgeGate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SmartAgeGate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/smartagegate-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is used to load all the javascript needed in this plugin in wp-admin.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in SmartAgeGate_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The SmartAgeGate_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if ( ! wp_script_is( 'jquery', 'enqueued' )) {
			//Enqueue
			wp_enqueue_script( 'jquery' );
		}
		if ( ! wp_script_is( 'wp-color-picker', 'enqueued' )) {
			//Enqueue
			wp_enqueue_script( 'wp-color-picker' );
		}
		if ( ! wp_script_is( 'iris', 'enqueued' )) {			
			//Enqueue			
			wp_enqueue_script( 'iris', admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),$this->version, false, 1 );
		}
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}		
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/smartagegate-admin.js', array('jquery'), $this->version, false);
	}	
	/**
	 * Register the settings.
	 *
	 * @since    1.0.0
	 */
	public function register_smartagegate_settings()	{

		$smartagegate_settings_options = get_option( 'smartagegate_settings_options' );
		$hide_clr_class = '';$hide_img_class = '';		
		if(isset($smartagegate_settings_options['smartagegate_background_color_or_image']) && $smartagegate_settings_options['smartagegate_background_color_or_image']!=1){			
			$hide_img_class = 'smartagegate_hide';
			
		}
		else{			
			$hide_clr_class='smartagegate_hide';			
		}

		register_setting( 'smartagegate', 'smartagegate_settings_options' );

		add_settings_section(
			'smartagegate_settings', // section ID
			__( 'Smart Age Gate', 'smartagegate' ), // title
			array($this,'smartagegate_settings_callback_function'), // callback function
			'smartagegate' // page slug
		);
		/*
		 * Adding heading field
		*/
		add_settings_field(
			'smartagegate_birth_heading',
			__( 'Heading', 'smartagegate' ),
			array($this,'smartagegate_heading_field_html'), // function which prints the field
			'smartagegate', // page slug
			'smartagegate_settings', // section ID
			array( 
				'label_for' => 'smartagegate_birth_heading',
				'class' => 'smartagegate_birth_heading',
				'smartagegate_custom_data' => 'custom-heading',
				'value' => (isset($smartagegate_settings_options['smartagegate_birth_heading']) && $smartagegate_settings_options['smartagegate_birth_heading']!='') ? $smartagegate_settings_options['smartagegate_birth_heading'] : __( 'Please enter your year of birth', 'smartagegate' )
			)
		);
		/*
		 * Adding radio button field for choosing either image or color
		*/
		add_settings_field(
			'smartagegate_background_color_or_image',
			__( 'Background color / Image', 'smartagegate' ),
			array($this,'smartagegate_background_color_or_image_field_html'), // function which prints the field
			'smartagegate', // page slug
			'smartagegate_settings', // section ID
			array( 
				'label_for' => 'smartagegate_background_color_or_image',
				'class' => 'smartagegate_background_color_or_image',
				'smartagegate_custom_data' => 'custom-background-color',
				'value' => (isset($smartagegate_settings_options['smartagegate_background_color_or_image']) && $smartagegate_settings_options['smartagegate_background_color_or_image']!='') ? $smartagegate_settings_options['smartagegate_background_color_or_image'] : 1
			)
		);	
		/*
		 * Adding color chooser field
		*/
		add_settings_field(
			'smartagegate_background_color',
			__('Background color'),
			array($this,'smartagegate_background_color_field_html'), // function which prints the field
			'smartagegate', // page slug
			'smartagegate_settings', // section ID
			array( 
				'label_for' => 'smartagegate_background_color',
				'class' => 'smartagegate_background_color smartagegate-color-picker '.$hide_clr_class,
				'smartagegate_custom_data' => 'custom-smartagegate_background_color_or_image',
				'value' => (isset($smartagegate_settings_options['smartagegate_background_color']) && $smartagegate_settings_options['smartagegate_background_color']!='') ? $smartagegate_settings_options['smartagegate_background_color'] : '#000000'
			)
		);
		/*
		 * Adding wp media uploader field for background image
		*/
		add_settings_field(
			'smartagegate_background_image',
			__('Background Image'),
			array($this,'smartagegate_background_image_media_field_html'), // function which prints the field
			'smartagegate', // page slug
			'smartagegate_settings', // section ID
			array( 
				'label_for' => 'smartagegate_background_image',
				'class' => 'custom-media-uploader '.$hide_img_class,
				'smartagegate_custom_data' => 'custom-smartagegate_background_image',
				'value' => (isset($smartagegate_settings_options['smartagegate_background_image']) && $smartagegate_settings_options['smartagegate_background_image']!='') ? $smartagegate_settings_options['smartagegate_background_image'] : ''
			)
		);		
		/*
		 * Adding free text field
		*/
		add_settings_field(
			'smartagegate_free_text',
			__('Free Text'),
			array($this,'smartagegate_free_text_field_html'), // function which prints the field
			'smartagegate', // page slug
			'smartagegate_settings', // section ID
			array( 
				'label_for' => 'smartagegate_free_text',
				'class' => 'smartagegate_free_text',
				'smartagegate_custom_data' => 'custom-smartagegate_free_text',
				'value' => (isset($smartagegate_settings_options['smartagegate_free_text']) && $smartagegate_settings_options['smartagegate_free_text']!='') ? $smartagegate_settings_options['smartagegate_free_text'] : '<p style="text-align: center;">You confirm you are aged 18 years or over. By selecting the “Remember Me” option, you consent to us using cookies to remember the validation of your year of birth.</p>'
			)
		);		
		/*
		 * Adding cookie time text field
		*/
		add_settings_field(
			'smartagegate_cookie_time',
			__('Cookie Time(in days)'),
			array($this,'smartagegate_cookie_time_text_field_html'), // function which prints the field
			'smartagegate', // page slug
			'smartagegate_settings', // section ID
			array( 
				'label_for' => 'smartagegate_cookie_time',
				'class' => 'smartagegate_cookie_time',
				'smartagegate_custom_data' => 'custom-smartagegate_cookie_time',
				'value' => (isset($smartagegate_settings_options['smartagegate_cookie_time']) && $smartagegate_settings_options['smartagegate_cookie_time']!='') ? $smartagegate_settings_options['smartagegate_cookie_time'] : 7
			)
		);	
		/*
		 * Adding minimum age text field
		*/
		add_settings_field(
			'smartagegate_minimum_age',
			__('Cookie Time(in days)'),
			array($this,'smartagegate_minimum_age_text_field_html'), // function which prints the field
			'smartagegate', // page slug
			'smartagegate_settings', // section ID
			array( 
				'label_for' => 'smartagegate_minimum_age',
				'class' => 'smartagegate_minimum_age',
				'smartagegate_custom_data' => 'custom-smartagegate_minimum_age',
				'value' => (isset($smartagegate_settings_options['smartagegate_minimum_age']) && $smartagegate_settings_options['smartagegate_minimum_age']!='') ? $smartagegate_settings_options['smartagegate_minimum_age'] : 18
			)
		);	
	}
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_settings_callback_function($args) {
		
	}
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_heading_field_html($args) {		
		?>
		<input type="text" 
			id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['smartagegate_custom_data'] ); ?>"
			name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]" 
			value="<?php echo $args['value'];?>" 
		/>		
	<?php	
	}
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_background_color_or_image_field_html($args) { 
		
		if(isset($args['value']) && $args['value']!=1){
			$smartagegate_checked_color  = 'checked="checked"';
			$hide_img_class = 'smartagegate_hide';
			
		}
		else{
			$smartagegate_checked_img  = 'checked="checked"';	
			$hide_clr_class='smartagegate_hide';			
		}
		?>
		<div class="bgdiv">
			<span>Background Image</span>
			<input type="radio" 
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				data-custom="<?php echo esc_attr( $args['smartagegate_custom_data'] ); ?>"
				name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]" 
				value="1" <?php echo $smartagegate_checked_img;?>
			/>
		</div>
		<div class="bgdiv">
			<span>Background Color</span>
			<input type="radio" 
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				data-custom="<?php echo esc_attr( $args['smartagegate_custom_data'] ); ?>"
				name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]"  
				value="0" <?php echo $smartagegate_checked_color;?>
			/>
		</div>
	<?php }
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_background_color_field_html($args) {		
		?>
		<input type="text" 
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				data-custom="<?php echo esc_attr( $args['smartagegate_custom_data'] ); ?>"
				name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]"
				class="<?php echo esc_attr( $args['class'] ); ?>" 
				value="<?php echo $args['value'];?>" 
		/>
	<?php
	}
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_free_text_field_html($args) {		
		wp_editor($args['value'], esc_attr( $args['label_for'] ), array(
			'wpautop'       => true,
			'media_buttons' => false,
			'textarea_name' => 'smartagegate_settings_options['.esc_attr( $args['label_for'] ).']',
			'editor_class'  => esc_attr( $args['class'] ),
			'textarea_rows' => 10
		));
	}
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_cookie_time_text_field_html($args) {		
		?>
		<input type="number" 
				pattern="[0-9]+"
				oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				data-custom="<?php echo esc_attr( $args['smartagegate_custom_data'] ); ?>"
				name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]"
				class="<?php echo esc_attr( $args['class'] ); ?>" 
				value="<?php echo $args['value'];?>" 
		<?php
	}
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_minimum_age_text_field_html($args) {		
		?>
		<input type="number" 
				pattern="[0-9]+"
				oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
				id="<?php echo esc_attr( $args['label_for'] ); ?>"
				data-custom="<?php echo esc_attr( $args['smartagegate_custom_data'] ); ?>"
				name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]"
				class="<?php echo esc_attr( $args['class'] ); ?>" 
				value="<?php echo $args['value'];?>" 
		<?php
	}
	/**
	 * Function used to render the registered field in settings.
	 *
	 * @since    1.0.0
	 */	
	public function smartagegate_background_image_media_field_html($args) {		
		if($args['value']!='') {
			?>
				<a href="#" class="custom-upload-button button button-primary"><img src="<?php echo $args['value']; ?>" width="20%"/></a>
				<a href="#" class="custom-upload-remove">Remove image</a>
				<input  type="hidden" 
						name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]"
						value="" 
				/>
			<?php
		} else {
			?>
				<a href="#" class="custom-upload-button button">Upload image</a>
				<a href="#" class="custom-upload-remove" style="display:none;">Remove image</a>
				<input  type="hidden" 
						name="smartagegate_settings_options[<?php echo esc_attr($args['label_for']);?>]"
						value="" 
				/>
			<?php
		}
	}
}
