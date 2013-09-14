<?php 

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level 
 * 'Adventure Theme' menu.
 */
function adventure_example_theme_menu() {

  add_theme_page(
    'Adventure Theme',          // The title to be displayed in the browser window for this page.
    'Adventure Theme',          // The text to be displayed for this menu item
    'administrator',          // Which type of users can see this menu item
    'adventure_theme_options',      // The unique ID - that is, the slug - for this menu item
    'adventure_theme_display'       // The name of the function to call when rendering this menu's page
  );

  add_menu_page(
    'Adventure Theme',          // The value used to populate the browser's title bar when the menu page is active
    'Adventure Theme',          // The text of the menu in the administrator's sidebar
    'administrator',          // What roles are able to access the menu
    'adventure_theme_menu',       // The ID used to bind submenu items to this menu 
    'adventure_theme_display'       // The callback function used to render this menu
  );

  add_submenu_page(
    'adventure_theme_menu',       // The ID of the top-level menu page to which this submenu item belongs
    __( 'General Options', 'adventure' ),     // The value used to populate the browser's title bar when the menu page is active
    __( 'General Options', 'adventure' ),         // The label of this submenu item displayed in the menu
    'administrator',          // What roles are able to access this submenu item
    'adventure_theme_general_options',  // The ID used to represent this submenu item
    'adventure_theme_display'       // The callback function used to render the options for this submenu item
  );

  add_submenu_page(
    'adventure_theme_menu',
    __( 'Social Options', 'adventure' ),
    __( 'Social Options', 'adventure' ),
    'administrator',
    'adventure_theme_social_options',
    create_function( null, 'adventure_theme_display( "social_options" );' )
  );

} // end adventure_example_theme_menu
add_action( 'admin_menu', 'adventure_example_theme_menu' );

/**
 * Renders a simple page to display for the theme menu defined above.
 */
function adventure_theme_display( $active_tab = '' ) {
?>
  <!-- Create a header in the default WordPress 'wrap' container -->
  <div class="wrap">
  
    <div id="icon-themes" class="icon32"></div>
    <h2><?php _e( 'Adventure Theme Options', 'adventure' ); ?></h2>
    <?php settings_errors(); ?>
    
    <?php if( isset( $_GET[ 'tab' ] ) ) {
      $active_tab = $_GET[ 'tab' ];
    } else if( $active_tab == 'social_options' ) {
      $active_tab = 'social_options';
    } else {
      $active_tab = 'general_options';
    } // end if/else ?>

    <h2 class="nav-tab-wrapper">
      <a href="?page=adventure_theme_options&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General Options', 'adventure' ); ?></a>
      <a href="?page=adventure_theme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'adventure' ); ?></a>
    </h2>
    
    <form method="post" action="options.php">
      <?php

        if( $active_tab == 'general_options' ) {

          settings_fields( 'adventure_theme_general_options' );
          do_settings_sections( 'adventure_theme_general_options' );

        } else {

          settings_fields( 'adventure_theme_social_options' );
          do_settings_sections( 'adventure_theme_social_options' );

        } // end if/else

        submit_button();

      ?>
    </form>
    
  </div><!-- /.wrap -->
<?php
} // end adventure_theme_display

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */ 


/**
 * Provides default values for the Social Options.
 */
function adventure_theme_default_social_options() {

  $defaults = array(
    'twitter'   =>  '',
    'facebook'    =>  '',
    'googleplus'  =>  '',
    'instagram' => '',
    'github' => '',
    'youtube' => '',
    'pinterest' => '',
    'linkedin' => '',
  );

  return apply_filters( 'adventure_theme_default_social_options', $defaults );

} // end adventure_theme_default_social_options

/**
 * Provides default values for the Display Options.
 */
function adventure_theme_default_general_options() {

  $defaults = array(
    'google_analytics'   =>  '',
    'show_footer_copyright'   =>  '',
  );

  return apply_filters( 'adventure_theme_default_general_options', $defaults );

} // end adventure_theme_default_general_options

/**
 * Provides default values for the Input Options.
 */
function adventure_theme_default_input_options() {

  $defaults = array(
    'input_example'   =>  '',
    'textarea_example'  =>  '',
    'checkbox_example'  =>  '',
    'radio_example'   =>  '',
    'time_options'    =>  'default' 
  );

  return apply_filters( 'adventure_theme_default_input_options', $defaults );

} // end adventure_theme_default_input_options

/**
 * Initializes the theme's display options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
function adventure_initialize_theme_options() {

  // If the theme options don't exist, create them.
  if( false == get_option( 'adventure_theme_general_options' ) ) {  
    add_option( 'adventure_theme_general_options', apply_filters( 'adventure_theme_default_general_options', adventure_theme_default_general_options() ) );
  } // end if

  // First, we register a section. This is necessary since all future options must belong to a 
  add_settings_section(
    'general_settings_section',     // ID used to identify this section and with which to register options
    __( 'General Options', 'adventure' ),   // Title to be displayed on the administration page
    'adventure_general_options_callback', // Callback used to render the description of the section
    'adventure_theme_general_options'   // Page on which to add this section of options
  );

  add_settings_field(
    'google_analytics',
    __( 'Google Analytics ID', 'adventure' ),
    'adventure_google_analytics_callback',
    'adventure_theme_general_options',
    'general_settings_section',
    array (
      __( 'Add your Google Analytics ID to start tracking visits to your site.', 'adventure' ),
    )
  );

  add_settings_field( 
    'show_footer_copyright',            
    __( 'Footer Copyright Information', 'adventure' ),        
    'adventure_footer_copyright_callback', 
    'adventure_theme_general_options',    
    'general_settings_section',     
    array(                
      __( 'Edit the text below to show your own copyright information on the site.', 'adventure' ),
    )
  );

  // Finally, we register the fields with WordPress
  register_setting(
    'adventure_theme_general_options',
    'adventure_theme_general_options',
    'adventure_theme_validate_input_examples'
  );

} // end adventure_initialize_theme_options
add_action( 'admin_init', 'adventure_initialize_theme_options' );

/**
 * Initializes the theme's social options by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
function adventure_theme_intialize_social_options() {

  if( false == get_option( 'adventure_theme_social_options' ) ) { 
    add_option( 'adventure_theme_social_options', apply_filters( 'adventure_theme_default_social_options', adventure_theme_default_social_options() ) );
  } // end if

  add_settings_section(
    'social_settings_section',      // ID used to identify this section and with which to register options
    __( 'Social Options', 'adventure' ),    // Title to be displayed on the administration page
    'adventure_social_options_callback',  // Callback used to render the description of the section
    'adventure_theme_social_options'    // Page on which to add this section of options
  );

  add_settings_field( 
    'twitter',            
    'Twitter',              
    'adventure_twitter_callback', 
    'adventure_theme_social_options', 
    'social_settings_section'     
  );

  add_settings_field( 
    'facebook',           
    'Facebook',             
    'adventure_facebook_callback',  
    'adventure_theme_social_options', 
    'social_settings_section'     
  );

  add_settings_field(
    'instagram',
    'Instagram', 
    'adventure_instagram_callback',
    'adventure_theme_social_options',
    'social_settings_section'
  );

  add_settings_field( 
    'googleplus',           
    'Google+',              
    'adventure_googleplus_callback',  
    'adventure_theme_social_options', 
    'social_settings_section'     
  );

  add_settings_field(
    'github',
    'GitHub',
    'adventure_github_callback',
    'adventure_theme_social_options', 
    'social_settings_section'
  );

  add_settings_field(
    'youtube',
    'YouTube',
    'adventure_youtube_callback',
    'adventure_theme_social_options',
    'social_settings_section'
  );

  add_settings_field(
    'pinterest', 
    'Pinterest', 
    'adventure_pinterest_callback',
    'adventure_theme_social_options',
    'social_settings_section'
  );

  add_settings_field(
    'linkedin',
    'LinkedIn',
    'adventure_linkedin_callback',
    'adventure_theme_social_options',
    'social_settings_section'
  );

  register_setting(
    'adventure_theme_social_options',
    'adventure_theme_social_options',
    'adventure_theme_sanitize_social_options'
  );

} // end adventure_theme_intialize_social_options
add_action( 'admin_init', 'adventure_theme_intialize_social_options' );

/**
 * Initializes the theme's input example by registering the Sections,
 * Fields, and Settings. This particular group of options is used to demonstration
 * validation and sanitization.
 *
 * This function is registered with the 'admin_init' hook.
 */ 
function adventure_theme_initialize_input_examples() {

  if( false == get_option( 'adventure_theme_input_examples' ) ) { 
    add_option( 'adventure_theme_input_examples', apply_filters( 'adventure_theme_default_input_options', adventure_theme_default_input_options() ) );
  } // end if

  add_settings_section(
    'input_examples_section',
    __( 'Input Examples', 'adventure' ),
    'adventure_input_examples_callback',
    'adventure_theme_input_examples'
  );

  add_settings_field( 
    'Input Element',            
    __( 'Input Element', 'adventure' ),             
    'adventure_input_element_callback', 
    'adventure_theme_input_examples', 
    'input_examples_section'      
  );

  add_settings_field( 
    'Textarea Element',           
    __( 'Textarea Element', 'adventure' ),              
    'adventure_textarea_element_callback',  
    'adventure_theme_input_examples', 
    'input_examples_section'      
  );

  add_settings_field(
    'Checkbox Element',
    __( 'Checkbox Element', 'adventure' ),
    'adventure_checkbox_element_callback',
    'adventure_theme_input_examples',
    'input_examples_section'
  );

  add_settings_field(
    'Radio Button Elements',
    __( 'Radio Button Elements', 'adventure' ),
    'adventure_radio_element_callback',
    'adventure_theme_input_examples',
    'input_examples_section'
  );

  add_settings_field(
    'Select Element',
    __( 'Select Element', 'adventure' ),
    'adventure_select_element_callback',
    'adventure_theme_input_examples',
    'input_examples_section'
  );

  register_setting(
    'adventure_theme_input_examples',
    'adventure_theme_input_examples',
    'adventure_theme_validate_input_examples'
  );

} // end adventure_theme_initialize_input_examples
add_action( 'admin_init', 'adventure_theme_initialize_input_examples' );

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function provides a simple description for the General Options page. 
 *
 * It's called from the 'adventure_initialize_theme_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function adventure_general_options_callback() {
  echo '<p>' . __( 'Edit the following areas below to customize the general settings of this theme.', 'adventure' ) . '</p>';
} // end adventure_general_options_callback

/**
 * This function provides a simple description for the Social Options page. 
 *
 * It's called from the 'adventure_theme_intialize_social_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function adventure_social_options_callback() {
  echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display or leave it blank if you do not want to show a network.', 'adventure' ) . '</p>';
} // end adventure_general_options_callback

/**
 * This function provides a simple description for the Input Examples page.
 *
 * It's called from the 'adventure_theme_intialize_input_examples_options' function by being passed as a parameter
 * in the add_settings_section function.
 */
function adventure_input_examples_callback() {
  echo '<p>' . __( 'Provides examples of the five basic element types.', 'adventure' ) . '</p>';
} // end adventure_general_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 

/**
 * This function renders the interface elements for toggling the visibility of the header element.
 * 
 * It accepts an array or arguments and expects the first element in the array to be the description
 * to be displayed next to the checkbox.
 */


function adventure_google_analytics_callback() {

  $options = get_option( 'adventure_theme_general_options' );

  // Render the output
  echo '<input type="text" id="google_analytics" placeholder="UA-12345678-1" name="adventure_theme_general_options[google_analytics]" value="' . $options['google_analytics'] . '" />';

} // end adventure_google_analytics_callback

function adventure_toggle_header_callback($args) {

  // First, we read the options collection
  $options = get_option('adventure_theme_general_options');

  // Next, we update the name attribute to access this element's ID in the context of the display options array
  // We also access the show_header element of the options collection in the call to the checked() helper function
  $html = '<input type="checkbox" id="show_header" name="adventure_theme_general_options[show_header]" value="1" ' . checked( 1, isset( $options['show_header'] ) ? $options['show_header'] : 0, false ) . '/>'; 

  // Here, we'll take the first argument of the array and add it to a label next to the checkbox
  $html .= '<label for="show_header">&nbsp;'  . $args[0] . '</label>'; 

  echo $html;

} // end adventure_toggle_header_callback

function adventure_toggle_content_callback($args) {

  $options = get_option('adventure_theme_general_options');

  $html = '<input type="checkbox" id="show_content" name="adventure_theme_general_options[show_content]" value="1" ' . checked( 1, isset( $options['show_content'] ) ? $options['show_content'] : 0, false ) . '/>'; 
  $html .= '<label for="show_content">&nbsp;'  . $args[0] . '</label>'; 

  echo $html;

} // end adventure_toggle_content_callback


function adventure_footer_copyright_callback() {

  $options = get_option( 'adventure_theme_general_options' );

  // Render the output
  echo '<textarea id="textarea_example" placeholder="Enter your own copyright information here." name="adventure_theme_general_options[show_footer]" rows="5" cols="50">' . $options['show_footer'] . '</textarea>';

}

function adventure_twitter_callback() {

  // First, we read the social options collection
  $options = get_option( 'adventure_theme_social_options' );

  // Next, we need to make sure the element is defined in the options. If not, we'll set an empty string.
  $url = '';
  if( isset( $options['twitter'] ) ) {
    $url = esc_url( $options['twitter'] );
  } // end if

  // Render the output
  echo '<input type="text" id="twitter" name="adventure_theme_social_options[twitter]" value="' . $url . '" />';

} // end adventure_twitter_callback

function adventure_facebook_callback() {

  $options = get_option( 'adventure_theme_social_options' );

  $url = '';
  if( isset( $options['facebook'] ) ) {
    $url = esc_url( $options['facebook'] );
  } // end if

  // Render the output
  echo '<input type="text" id="facebook" name="adventure_theme_social_options[facebook]" value="' . $url . '" />';

} // end adventure_facebook_callback

function adventure_instagram_callback() {

  $options = get_option( 'adventure_theme_social_options' );

  $url = '';
  if( isset( $options['instagram'] ) ) {
    $url = esc_url( $options['instagram'] );
  } // end if

  // Render the output
  echo '<input type="text" id="instagram" name="adventure_theme_social_options[instagram]" value="' . $url . '" />';

} // end adventure_instagram_callback

function adventure_googleplus_callback() {

  $options = get_option( 'adventure_theme_social_options' );

  $url = '';
  if( isset( $options['googleplus'] ) ) {
    $url = esc_url( $options['googleplus'] );
  } // end if

  // Render the output
  echo '<input type="text" id="googleplus" name="adventure_theme_social_options[googleplus]" value="' . $url . '" />';

} // end adventure_github_callback

function adventure_github_callback() {

  $options = get_option( 'adventure_theme_social_options' );

  $url = '';
  if( isset( $options['github'] ) ) {
    $url = esc_url( $options['github'] );
  } // end if

  // Render the output
  echo '<input type="text" id="github" name="adventure_theme_social_options[github]" value="' . $url . '" />';

} // end adventure_github_callback

function adventure_youtube_callback() {

  $options = get_option( 'adventure_theme_social_options' );

  $url = '';
  if( isset( $options['youtube'] ) ) {
    $url = esc_url( $options['youtube'] );
  } // end if

  // Render the output
  echo '<input type="text" id="youtube" name="adventure_theme_social_options[youtube]" value="' . $url . '" />';

} // end adventure_youtube_callback

function adventure_pinterest_callback() {

  $options = get_option( 'adventure_theme_social_options' );

  $url = '';
  if( isset( $options['pinterest'] ) ) {
    $url = esc_url( $options['pinterest'] );
  } // end if

  // Render the output
  echo '<input type="text" id="pinterest" name="adventure_theme_social_options[pinterest]" value="' . $url . '" />';

} // end adventure_pinterest_callback

function adventure_linkedin_callback() {

  $options = get_option( 'adventure_theme_social_options' );

  $url = '';
  if( isset( $options['linkedin'] ) ) {
    $url = esc_url( $options['linkedin'] );
  } // end if

  // Render the output
  echo '<input type="text" id="linkedin" name="adventure_theme_social_options[linkedin]" value="' . $url . '" />';

} // end adventure_linkedin_callback

function adventure_input_element_callback() {

  $options = get_option( 'adventure_theme_input_examples' );

  // Render the output
  echo '<input type="text" id="input_example" name="adventure_theme_input_examples[input_example]" value="' . $options['input_example'] . '" />';

} // end adventure_input_element_callback

function adventure_textarea_element_callback() {

  $options = get_option( 'adventure_theme_input_examples' );

  // Render the output
  echo '<textarea id="textarea_example" name="adventure_theme_input_examples[textarea_example]" rows="5" cols="50">' . $options['textarea_example'] . '</textarea>';

} // end adventure_textarea_element_callback

function adventure_checkbox_element_callback() {

  $options = get_option( 'adventure_theme_input_examples' );

  $html = '<input type="checkbox" id="checkbox_example" name="adventure_theme_input_examples[checkbox_example]" value="1"' . checked( 1, $options['checkbox_example'], false ) . '/>';
  $html .= '&nbsp;';
  $html .= '<label for="checkbox_example">This is an example of a checkbox</label>';

  echo $html;

} // end adventure_checkbox_element_callback

function adventure_radio_element_callback() {

  $options = get_option( 'adventure_theme_input_examples' );

  $html = '<input type="radio" id="radio_example_one" name="adventure_theme_input_examples[radio_example]" value="1"' . checked( 1, $options['radio_example'], false ) . '/>';
  $html .= '&nbsp;';
  $html .= '<label for="radio_example_one">Option One</label>';
  $html .= '&nbsp;';
  $html .= '<input type="radio" id="radio_example_two" name="adventure_theme_input_examples[radio_example]" value="2"' . checked( 2, $options['radio_example'], false ) . '/>';
  $html .= '&nbsp;';
  $html .= '<label for="radio_example_two">Option Two</label>';

  echo $html;

} // end adventure_radio_element_callback

function adventure_select_element_callback() {

  $options = get_option( 'adventure_theme_input_examples' );

  $html = '<select id="time_options" name="adventure_theme_input_examples[time_options]">';
    $html .= '<option value="default">' . __( 'Select a time option...', 'adventure' ) . '</option>';
    $html .= '<option value="never"' . selected( $options['time_options'], 'never', false) . '>' . __( 'Never', 'adventure' ) . '</option>';
    $html .= '<option value="sometimes"' . selected( $options['time_options'], 'sometimes', false) . '>' . __( 'Sometimes', 'adventure' ) . '</option>';
    $html .= '<option value="always"' . selected( $options['time_options'], 'always', false) . '>' . __( 'Always', 'adventure' ) . '</option>'; $html .= '</select>';

  echo $html;

} // end adventure_radio_element_callback

/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */ 
 
/**
 * Sanitization callback for the social options. Since each of the social options are text inputs,
 * this function loops through the incoming option and strips all tags and slashes from the value
 * before serializing it.
 *  
 * @params  $input  The unsanitized collection of options.
 *
 * @returns     The collection of sanitized values.
 */

function adventure_theme_sanitize_social_options( $input ) {

  // Define the array for the updated options
  $output = array();

  // Loop through each of the options sanitizing the data
  foreach( $input as $key => $val ) {

    if( isset ( $input[$key] ) ) {
      $output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
    } // end if 

  } // end foreach

  // Return the new collection
  return apply_filters( 'adventure_theme_sanitize_social_options', $output, $input );

} // end adventure_theme_sanitize_social_options

function adventure_theme_validate_input_examples( $input ) {

  // Create our array for storing the validated options
  $output = array();

  // Loop through each of the incoming options
  foreach( $input as $key => $value ) {

    // Check to see if the current option has a value. If so, process it.
    if( isset( $input[$key] ) ) {

      // Strip all HTML and PHP tags and properly handle quoted strings
      $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

    } // end if

  } // end foreach

  // Return the array processing any additional functions filtered by this action
  return apply_filters( 'adventure_theme_validate_input_examples', $output, $input );

} // end adventure_theme_validate_input_examples

?>