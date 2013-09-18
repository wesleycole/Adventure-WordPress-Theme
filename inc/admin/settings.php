<?php 

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level 
 * 'Adventure Theme' menu.
 */
function adventure_theme_menu() {

  add_theme_page(
    'Adventure Theme',          
    'Adventure Theme',          
    'administrator',          
    'adventure_theme_options',      
    'adventure_theme_display'       
  );

  add_menu_page(
    'Adventure Theme',          
    'Adventure Theme',          
    'administrator',          
    'adventure_theme_menu',        
    'adventure_theme_display'       
  );

  add_submenu_page(
    'adventure_theme_menu',       
    __( 'General Options', 'adventure' ),     
    __( 'General Options', 'adventure' ),         
    'administrator',          
    'adventure_theme_general_options',  
    'adventure_theme_display'       
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
add_action( 'admin_menu', 'adventure_theme_menu' );

/**
 * Displays the menu page.
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


// Default Values 

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


function adventure_theme_default_general_options() {

  $defaults = array(
    'google_analytics'   =>  '',
    'show_footer_copyright'   =>  '',
  );

  return apply_filters( 'adventure_theme_default_general_options', $defaults );

} // end adventure_theme_default_general_options


/**
 * Registering the general options. 
 */ 
function adventure_initialize_theme_options() {

  // If the theme options don't exist, create them.
  if( false == get_option( 'adventure_theme_general_options' ) ) {  
    add_option( 'adventure_theme_general_options', apply_filters( 'adventure_theme_default_general_options', adventure_theme_default_general_options() ) );
  } // end if

  add_settings_section(
    'general_settings_section',     
    __( 'General Options', 'adventure' ),   
    'adventure_general_options_callback', 
    'adventure_theme_general_options'   
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

  register_setting(
    'adventure_theme_general_options',
    'adventure_theme_general_options',
    'adventure_theme_validate_general_options'
  );

} // end adventure_initialize_theme_options

add_action( 'admin_init', 'adventure_initialize_theme_options' );

/**
 * Registering the social options for the theme. 
 */ 

function adventure_theme_intialize_social_options() {

  if( false == get_option( 'adventure_theme_social_options' ) ) { 
    add_option( 'adventure_theme_social_options', apply_filters( 'adventure_theme_default_social_options', adventure_theme_default_social_options() ) );
  } // end if

  add_settings_section(
    'social_settings_section',      
    __( 'Social Options', 'adventure' ),    
    'adventure_social_options_callback',  
    'adventure_theme_social_options'    
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


/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 

function adventure_general_options_callback() {
  echo '<p>' . __( 'Edit the following areas below to customize the general settings of this theme.', 'adventure' ) . '</p>';
} // end adventure_general_options_callback

function adventure_social_options_callback() {
  echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display or leave it blank if you do not want to show a network.', 'adventure' ) . '</p>';
} // end adventure_general_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 


function adventure_google_analytics_callback() {

  $options = get_option( 'adventure_theme_general_options' );

  // Render the output
  echo '<input type="text" id="google_analytics" placeholder="UA-12345678-1" name="adventure_theme_general_options[google_analytics]" value="' . $options['google_analytics'] . '" />';

} // end adventure_google_analytics_callback


function adventure_footer_copyright_callback() {

  $options = get_option( 'adventure_theme_general_options' );

  // Render the output
  echo '<textarea id="textarea_example" placeholder="Enter your own copyright information here." name="adventure_theme_general_options[show_footer]" rows="5" cols="50">' . $options['show_footer'] . '</textarea>';

}

function adventure_twitter_callback() {

  $options = get_option( 'adventure_theme_social_options' );

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

/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */ 
 

function adventure_theme_sanitize_social_options( $input ) {

  $output = array();

  foreach( $input as $key => $val ) {

    if( isset ( $input[$key] ) ) {
      $output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
    } // end if 

  } // end foreach

  // Return the new collection
  return apply_filters( 'adventure_theme_sanitize_social_options', $output, $input );

} // end adventure_theme_sanitize_social_options

function adventure_theme_validate_general_options( $input ) {

  $output = array();

  foreach( $input as $key => $value ) {

    if( isset( $input[$key] ) ) {

      $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

    } // end if

  } // end foreach

  return apply_filters( 'adventure_theme_validate_general_options', $output, $input );

} // end adventure_theme_validate_input_examples

?>