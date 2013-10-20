<?php 

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level 
 * 'flyleaf Theme' menu.
 */
function flyleaf_theme_menu() {

  add_theme_page(
    'flyleaf Theme',          
    'flyleaf Theme',          
    'administrator',          
    'flyleaf_theme_menu',        
    'flyleaf_theme_display'       
  );

  add_theme_page(
    'flyleaf_theme_menu',       
    __( 'General Options', 'flyleaf' ),     
    __( 'General Options', 'flyleaf' ),         
    'administrator',          
    'flyleaf_theme_general_options',  
    'flyleaf_theme_display'       
  );

  add_theme_page(
    'flyleaf_theme_menu',
    __( 'Social Options', 'flyleaf' ),
    __( 'Social Options', 'flyleaf' ),
    'administrator',
    'flyleaf_theme_social_options',
    create_function( null, 'flyleaf_theme_display( "social_options" );' )
  );

} // end flyleaf_example_theme_menu
add_action( 'admin_menu', 'flyleaf_theme_menu' );

/**
 * Displays the menu page.
 */

function flyleaf_theme_display( $active_tab = '' ) {
?>
  <!-- Create a header in the default WordPress 'wrap' container -->
  <div class="wrap">
  
    <div id="icon-themes" class="icon32"></div>
    <h2><?php _e( 'flyleaf Theme Options', 'flyleaf' ); ?></h2>
    <?php settings_errors(); ?>
    
    <?php if( isset( $_GET[ 'tab' ] ) ) {
      $active_tab = $_GET[ 'tab' ];
    } else if( $active_tab == 'social_options' ) {
      $active_tab = 'social_options';
    } else {
      $active_tab = 'general_options';
    } // end if/else ?>

    <h2 class="nav-tab-wrapper">
      <a href="?page=flyleaf_theme_options&tab=general_options" class="nav-tab <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General Options', 'flyleaf' ); ?></a>
      <a href="?page=flyleaf_theme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Social Options', 'flyleaf' ); ?></a>
    </h2>
    
    <form method="post" action="options.php">
      <?php

        if( $active_tab == 'general_options' ) {

          settings_fields( 'flyleaf_theme_general_options' );
          do_settings_sections( 'flyleaf_theme_general_options' );

        } else {

          settings_fields( 'flyleaf_theme_social_options' );
          do_settings_sections( 'flyleaf_theme_social_options' );

        } // end if/else

        submit_button();

      ?>
    </form>
    
  </div><!-- /.wrap -->
<?php
} // end flyleaf_theme_display

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */ 


// Default Values 

function flyleaf_theme_default_social_options() {

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

  return apply_filters( 'flyleaf_theme_default_social_options', $defaults );

} // end flyleaf_theme_default_social_options


function flyleaf_theme_default_general_options() {

  $defaults = array(
    'google_analytics'   =>  '',
    'show_footer_copyright'   =>  '',
  );

  return apply_filters( 'flyleaf_theme_default_general_options', $defaults );

} // end flyleaf_theme_default_general_options


/**
 * Registering the general options. 
 */ 
function flyleaf_initialize_theme_options() {

  // If the theme options don't exist, create them.
  if( false == get_option( 'flyleaf_theme_general_options' ) ) {  
    add_option( 'flyleaf_theme_general_options', apply_filters( 'flyleaf_theme_default_general_options', flyleaf_theme_default_general_options() ) );
  } // end if

  add_settings_section(
    'general_settings_section',     
    __( 'General Options', 'flyleaf' ),   
    'flyleaf_general_options_callback', 
    'flyleaf_theme_general_options'   
  );

  add_settings_field(
    'google_analytics',
    __( 'Google Analytics ID', 'flyleaf' ),
    'flyleaf_google_analytics_callback',
    'flyleaf_theme_general_options',
    'general_settings_section',
    array (
      __( 'Add your Google Analytics ID to start tracking visits to your site.', 'flyleaf' ),
    )
  );

  add_settings_field( 
    'show_footer_copyright',            
    __( 'Footer Copyright Information', 'flyleaf' ),        
    'flyleaf_footer_copyright_callback', 
    'flyleaf_theme_general_options',    
    'general_settings_section',     
    array(                
      __( 'Edit the text below to show your own copyright information on the site.', 'flyleaf' ),
    )
  );

  register_setting(
    'flyleaf_theme_general_options',
    'flyleaf_theme_general_options',
    'flyleaf_theme_validate_general_options'
  );

} // end flyleaf_initialize_theme_options

add_action( 'admin_init', 'flyleaf_initialize_theme_options' );

/**
 * Registering the social options for the theme. 
 */ 

function flyleaf_theme_intialize_social_options() {

  if( false == get_option( 'flyleaf_theme_social_options' ) ) { 
    add_option( 'flyleaf_theme_social_options', apply_filters( 'flyleaf_theme_default_social_options', flyleaf_theme_default_social_options() ) );
  } // end if

  add_settings_section(
    'social_settings_section',      
    __( 'Social Options', 'flyleaf' ),    
    'flyleaf_social_options_callback',  
    'flyleaf_theme_social_options'    
  );

  add_settings_field( 
    'twitter',            
    'Twitter',              
    'flyleaf_twitter_callback', 
    'flyleaf_theme_social_options', 
    'social_settings_section'     
  );

  add_settings_field( 
    'facebook',           
    'Facebook',             
    'flyleaf_facebook_callback',  
    'flyleaf_theme_social_options', 
    'social_settings_section'     
  );

  add_settings_field(
    'instagram',
    'Instagram', 
    'flyleaf_instagram_callback',
    'flyleaf_theme_social_options',
    'social_settings_section'
  );

  add_settings_field( 
    'googleplus',           
    'Google+',              
    'flyleaf_googleplus_callback',  
    'flyleaf_theme_social_options', 
    'social_settings_section'     
  );

  add_settings_field(
    'github',
    'GitHub',
    'flyleaf_github_callback',
    'flyleaf_theme_social_options', 
    'social_settings_section'
  );

  add_settings_field(
    'youtube',
    'YouTube',
    'flyleaf_youtube_callback',
    'flyleaf_theme_social_options',
    'social_settings_section'
  );

  add_settings_field(
    'pinterest', 
    'Pinterest', 
    'flyleaf_pinterest_callback',
    'flyleaf_theme_social_options',
    'social_settings_section'
  );

  add_settings_field(
    'linkedin',
    'LinkedIn',
    'flyleaf_linkedin_callback',
    'flyleaf_theme_social_options',
    'social_settings_section'
  );

  register_setting(
    'flyleaf_theme_social_options',
    'flyleaf_theme_social_options',
    'flyleaf_theme_sanitize_social_options'
  );

} // end flyleaf_theme_intialize_social_options
add_action( 'admin_init', 'flyleaf_theme_intialize_social_options' );


/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */ 

function flyleaf_general_options_callback() {
  echo '<p>' . __( 'Edit the following areas below to customize the general settings of this theme.', 'flyleaf' ) . '</p>';
} // end flyleaf_general_options_callback

function flyleaf_social_options_callback() {
  echo '<p>' . __( 'Provide the URL to the social networks you\'d like to display or leave it blank if you do not want to show a network.', 'flyleaf' ) . '</p>';
} // end flyleaf_general_options_callback

/* ------------------------------------------------------------------------ *
 * Field Callbacks
 * ------------------------------------------------------------------------ */ 


function flyleaf_google_analytics_callback() {

  $options = get_option( 'flyleaf_theme_general_options' );

  // Render the output
  echo '<input type="text" id="google_analytics" placeholder="UA-12345678-1" name="flyleaf_theme_general_options[google_analytics]" value="' . $options['google_analytics'] . '" />';

} // end flyleaf_google_analytics_callback


function flyleaf_footer_copyright_callback() {

  $options = get_option( 'flyleaf_theme_general_options' );

  // Render the output
  echo '<textarea id="textarea_example" placeholder="Enter your own copyright information here." name="flyleaf_theme_general_options[show_footer]" rows="5" cols="50">' . $options['show_footer'] . '</textarea>';

}

function flyleaf_twitter_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['twitter'] ) ) {
    $url = esc_url( $options['twitter'] );
  } // end if

  // Render the output
  echo '<input type="text" id="twitter" name="flyleaf_theme_social_options[twitter]" value="' . $url . '" />';

} // end flyleaf_twitter_callback

function flyleaf_facebook_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['facebook'] ) ) {
    $url = esc_url( $options['facebook'] );
  } // end if

  // Render the output
  echo '<input type="text" id="facebook" name="flyleaf_theme_social_options[facebook]" value="' . $url . '" />';

} // end flyleaf_facebook_callback

function flyleaf_instagram_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['instagram'] ) ) {
    $url = esc_url( $options['instagram'] );
  } // end if

  // Render the output
  echo '<input type="text" id="instagram" name="flyleaf_theme_social_options[instagram]" value="' . $url . '" />';

} // end flyleaf_instagram_callback

function flyleaf_googleplus_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['googleplus'] ) ) {
    $url = esc_url( $options['googleplus'] );
  } // end if

  // Render the output
  echo '<input type="text" id="googleplus" name="flyleaf_theme_social_options[googleplus]" value="' . $url . '" />';

} // end flyleaf_github_callback

function flyleaf_github_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['github'] ) ) {
    $url = esc_url( $options['github'] );
  } // end if

  // Render the output
  echo '<input type="text" id="github" name="flyleaf_theme_social_options[github]" value="' . $url . '" />';

} // end flyleaf_github_callback

function flyleaf_youtube_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['youtube'] ) ) {
    $url = esc_url( $options['youtube'] );
  } // end if

  // Render the output
  echo '<input type="text" id="youtube" name="flyleaf_theme_social_options[youtube]" value="' . $url . '" />';

} // end flyleaf_youtube_callback

function flyleaf_pinterest_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['pinterest'] ) ) {
    $url = esc_url( $options['pinterest'] );
  } // end if

  // Render the output
  echo '<input type="text" id="pinterest" name="flyleaf_theme_social_options[pinterest]" value="' . $url . '" />';

} // end flyleaf_pinterest_callback

function flyleaf_linkedin_callback() {

  $options = get_option( 'flyleaf_theme_social_options' );

  $url = '';
  if( isset( $options['linkedin'] ) ) {
    $url = esc_url( $options['linkedin'] );
  } // end if

  // Render the output
  echo '<input type="text" id="linkedin" name="flyleaf_theme_social_options[linkedin]" value="' . $url . '" />';

} // end flyleaf_linkedin_callback

/* ------------------------------------------------------------------------ *
 * Setting Callbacks
 * ------------------------------------------------------------------------ */ 
 

function flyleaf_theme_sanitize_social_options( $input ) {

  $output = array();

  foreach( $input as $key => $val ) {

    if( isset ( $input[$key] ) ) {
      $output[$key] = esc_url_raw( strip_tags( stripslashes( $input[$key] ) ) );
    } // end if 

  } // end foreach

  // Return the new collection
  return apply_filters( 'flyleaf_theme_sanitize_social_options', $output, $input );

} // end flyleaf_theme_sanitize_social_options

function flyleaf_theme_validate_general_options( $input ) {

  $output = array();

  foreach( $input as $key => $value ) {

    if( isset( $input[$key] ) ) {

      $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

    } // end if

  } // end foreach

  return apply_filters( 'flyleaf_theme_validate_general_options', $output, $input );

} // end flyleaf_theme_validate_input_examples

?>