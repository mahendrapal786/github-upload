<?php
define("FACEBOOK", "https://facebook.com/");
define("TWITTER", "https://twitter.com/");
define("LINKEDIN", "https://linkedin.com/");
/* This is for all custom function here */
add_theme_support( 'post-thumbnails' );
// This theme uses wp_nav_menu() in one location.
register_nav_menus( array(
     'menu-1' => esc_html__( 'Primary' ),
 ) );
// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

function new_canonical( $canonical_url ) {
    $last = substr(trim($canonical_url), -1);
    if($last=='/') {
        $canonical_url = substr($canonical_url,0,-1);
    }
    return $canonical_url;
}

/* add css and js for theme */
function custom_enqueue_scripts() {
/*wp_deregister_script('jquery');*/
wp_enqueue_script('jquery');

wp_register_style( 'style.min', get_template_directory_uri() . '/assets/css/style.min.css');
wp_enqueue_style( 'style.min' );

wp_register_script('popper.min', get_template_directory_uri() . '/assets/js/popper.min.js'); 
wp_enqueue_script('popper.min');
wp_register_script('bootstrap-min', get_template_directory_uri() . '/assets/js/bootstrap.min.js'); 
wp_enqueue_script('bootstrap-min');

wp_localize_script( 'jquery', 'ajax_posts', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
));

}
add_action( 'wp_enqueue_scripts', 'custom_enqueue_scripts' );

function contact_widgets_init() {

register_sidebar(array(   
        'id'            => 'footer_social',
        'name'          => 'Footer Social Sidebar',
        'description'   => 'This is sidebar for Social icon footer.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="social-widget-title d-none">',
        'after_title'   => '</h3>',
));

}
add_action( 'widgets_init', 'contact_widgets_init' );

remove_filter('widget_text_content', 'wpautop');

add_action ('wp_head', 'global_js_variables');
function global_js_variables() 
{  global $post;
    ?>
    <script type="text/javascript">
    var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
    var themeurl = '<?php echo get_template_directory_uri(); ?>';
    var siteurl = '<?php echo site_url(); ?>';
    var homeurl = '<?php echo home_url(); ?>';
    var currentpageid = '<?php echo $post->ID; ?>';
    </script>
    <?php
}


function wpassist_remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_deregister_style( 'wc-block-style' );
} 
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );

/* Custom Option For Customizer (Phone & Email) */
add_action( 'customize_register', 'genesischild_register_theme_customizer' );

function genesischild_register_theme_customizer( $wp_customize ) {

$wp_customize->add_panel( 'text_blocks', array(
  'priority'       => 500,
  'theme_supports' => '',
  'title'          => __( 'Change Phone & Email', 'genesischild' ),
  'description'    => __( 'Set editable text for certain content.', 'genesischild' ),
 ) );
 
 $wp_customize->add_section( 'custom_email_text' , array(
  'title'    => __('Change Email Text','genesischild'),
  'panel'    => 'text_blocks',
  'priority' => 10
 ) );
 
 $wp_customize->add_setting( 'email_text_block', array(
   'default'           => __( 'default text', 'genesischild' ),
   'sanitize_callback' => 'sanitize_text'
 ) );

 $wp_customize->add_control( new WP_Customize_Control(
     $wp_customize,
  'custom_address_text',
      array(
          'label'    => __( 'Email Text', 'genesischild' ),
          'section'  => 'custom_email_text',
          'settings' => 'email_text_block',
          'type'     => 'text'
      )
     )
 );
 
 $wp_customize->add_section( 'custom_phone_text' , array(
  'title'    => __('Change Phone Text','genesischild'),
  'panel'    => 'text_blocks',
  'priority' => 10
 ) );
 
 $wp_customize->add_setting( 'phone_text_block', array(
   'default'           => __( 'default text', 'genesischild' ),
   'sanitize_callback' => 'sanitize_text'
 ) );

 $wp_customize->add_control( new WP_Customize_Control(
     $wp_customize,
  'custom_phone_text',
      array(
          'label'    => __( 'Phone Text', 'genesischild' ),
          'section'  => 'custom_phone_text',
          'settings' => 'phone_text_block',
          'type'     => 'text'
      )
     )
 );
 
function sanitize_text( $text ) {
     return sanitize_text_field( $text );
 }
}

/*Customizer Code HERE*/
add_action('customize_register', 'theme_footer_customizer');
function theme_footer_customizer($wp_customize){
$wp_customize->add_section('footer_settings_section', array(
  'title'          => 'Company Address'
 ));
$wp_customize->add_setting('text_setting', array(
 'default'        => 'Add Company Address',
 ));
$wp_customize->add_control('text_setting', array(
 'label'   => 'Address Here',
 'section' => 'footer_settings_section',
 'type'    => 'textarea',
));
}

function custom_excerpt_more( $more ) {
    return '';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

function custom_excerpt_length( $length ) {
        return 25;
    }
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function kriesi_pagination($pages = '', $range = 2)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<nav class='pagination-nav' data-aos='fade-in-up'>";
         echo "<ul class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li class='page-item'><a class='page-link' href='".new_canonical(get_pagenum_link(1))."'>&laquo;</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".new_canonical(get_pagenum_link($paged - 1))."'>&lsaquo;</a>";

  $left_arrow = (1 === $paged) ? 'disabled' : '';

echo "<li class='page-item ".$left_arrow."'><a href='".new_canonical(get_pagenum_link($paged - 1))."' class='page-link page-prev' tabindex='-1'>Previous</a></li>";

     for ($i=1; $i <= $pages; $i++)
         {
           if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
 
         echo ($paged == $i)? "<li class='page-item active'><a class='page-link'><span class='current'>".$i."</span></a></li>":"<li class='page-item'><a class='page-link' href='".new_canonical(get_pagenum_link($i))."' class='inactive' >".$i."</a></li>";

             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<li class='page-item'><a class='page-link' href='".new_canonical(get_pagenum_link($paged + 1))."'>&rsaquo;</a></li>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li class='page-item'><a class='page-link' href='".new_canonical(get_pagenum_link($pages))."'>&raquo;</a></li>";

 $right_arrow = ($paged == $pages) ? 'disabled' : '';

echo "<li class='page-item ".$right_arrow."'><a class='page-link page-next' href='".new_canonical(get_pagenum_link($paged + 1))."'>Next</a></li>";

         echo "</ul>";
         echo "</nav>\n";
     }
}

/* Post view count  */
function setPostViews($postID) {
    $countKey = 'post_views_count';
    $count = get_post_meta($postID, $countKey, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $countKey);
        add_post_meta($postID, $countKey, '0');
    }else{
        $count++;
        update_post_meta($postID, $countKey, $count);
    }
}

/* phone in brackets */
function RemovePhoneHyphen()
{
$phone=get_theme_mod( 'phone_text_block');
$phone2=str_replace(array( '(', ')', '-', ' ' ), '', $phone);
return $phone2;
}

/* Blog Layout  */
function createBlogLayout($post)
{
$return='';
$permalink = get_the_permalink( $post->ID );

$postdate=$post->post_date;
$postdate = date("d F Y", strtotime($postdate));

$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', false, '' );

if ( is_front_page() || is_tax('product_cat') ) {
$return .= '<div class="col-xl-4 col-lg-6 card card-thumbnail" data-aos="fade-in-up" data-aos-delay="100">';
}
else
{
  $return .= '<div class="col-xl-6 card card-thumbnail" data-aos="fade-in-up">';
}

if(!empty($src))
{
$return .= '<figure class="card-img">';
$return .= '<a class="block" href="'.$permalink.'">';
$return .= '<img src="'.get_template_directory_uri(). '/assets/img/blank-16x9.png" class="img-full" alt="'.$post->post_title.'">';
$return .= '<img src="'.$src[0].'" class="main-img" alt="'.$post->post_title.'">';
$return .= '</a>';
$return .= '</figure>';
}
$return .= '<div class="card-body card-relative">';
$return .= '<div class="card-content">';
$return .= '<div class="card-title h4"><a class="link-default" href="'.$permalink.'">'.$post->post_title.'</a></div>';
$return .= '<ul class="list-posted">';
$return .= '<li class="item">';
$return .= '<span class="icon"><svg class="svg-icons" width="14px" height="14px">';
$return .= '<use xlink:href="'.get_template_directory_uri(). '/assets/img/sprite.svg#calendarIcon"></use>';
$return .= '</svg></span>';
$return .= '<span class="text">'.$postdate.'</span>';
$return .= '</li>';
$return .= '<li class="item"><span class="text">Posted By Boss Buildings</span></li>';
$return .= '</ul>';
$return .=  '<p>'.wp_trim_words( $post->post_content, 40, '...' ).'</p>';

$return .= '<div class="btn-toolbar">';
$return .= '<a class="btn btn-link" href="'.$permalink.'">Read More</a>';
$return .= '</div>';
$return .= '</div>';
$return .= '</div>';
$return .= '</div>';

return $return;
}

/* shortcdoe for phone and email  */
function phone_shortcode( $atts ){
return '<a href="tel:'.RemovePhoneHyphen().'">'.get_theme_mod( 'phone_text_block').'</a>';
}
add_shortcode( 'phone', 'phone_shortcode' );

function email_shortcode( $atts ){
  return '<a href="mailto:'.get_theme_mod( 'email_text_block').'">'.get_theme_mod( 'email_text_block').'</a>';
}
add_shortcode( 'email', 'email_shortcode' );

function add_link_atts($atts) {
  $atts['class'] = "nav-link";
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_link_atts');