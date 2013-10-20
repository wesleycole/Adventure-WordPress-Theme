<?php 
register_sidebar(array(
  'name' => __( 'Home Bottom Sidebar', 'flyleaf' ),
  'id' => 'home-sidebar',
  'description' => __( 'Widgets in this area will be shown on the bottom of the home page.', 'flyleaf' ),
  'before_widget' => '<div class="home_widget">', 
  'after_widget' => '</div>',
  'before_title' => '<h1>',
  'after_title' => '</h1>'
));
?>