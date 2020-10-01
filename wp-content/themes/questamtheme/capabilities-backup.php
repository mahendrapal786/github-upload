<?php
/*
Template Name: Capabilities Page
*/
get_header();
global $post;
$pageName=get_the_title($post->ID);
?>
<section class="banner about-banner" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/about_banner.png)">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">

          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo home_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0);"><?php echo $pageName; ?></a></li>
          </ol>


          <h1 class="heading-line-before"><?php echo $pageName; ?></h1>

        </div>
      </div>
    </div>
</section>
 <?php  if(have_rows('capabilities_type',$post->ID)) { 
         
        $number=1;
        $inner_tabs='';
        $outer_tabs='';
        $outer_tabs_images='';
        $tab_pane='';
        $outer_tab_count = 1;

   while(have_rows('capabilities_type',$post->ID)) 
     {
    the_row();
    $heading = get_sub_field('heading');
    $description = get_sub_field('description');
    $tabs = get_sub_field('inner_tabs');

    $aria_selected = ($number==1) ? 'true' : 'false'; 
    $active = ($number==1) ? 'active' : '';
    $show = ($number==1) ? 'show active' : '';
    $home_tab = ($number==1) ? 'v-pills-home-tab' : '';

    $heading_slug=str_replace(' ', '-', strtolower($heading));

    $inner_tabs .= '<a class="nav-link '.$active.'" id="'.$home_tab.'" data-toggle="pill" href="#v-pill-'.$heading_slug.'" role="tab" aria-controls="v-pills-'.$heading_slug.'" aria-selected="'.$aria_selected.'">'.$heading.'</a>';

    
    foreach ((array) $tabs as $tab)  
    {
   
   $outer_tab_active = ($outer_tab_count==1) ? 'active' : '';
   $outer_tab_show = ($outer_tab_count==1) ? 'show active' : ''; 

   $outer_home_tab = ($outer_tab_count==1) ? 'v-pills-home-tab' : '';

   
   $outer_title_slug=str_replace(' ', '-', strtolower($tab['title']));

$outer_tabs .= '<a class="nav-link '.$outer_tab_active.'" id="'.$outer_home_tab.'" data-toggle="pill" href="#v-pill-in-'.$outer_title_slug.'" role="tab" aria-controls="v-pills-'.$heading_slug.'" aria-selected="'.$aria_selected.'">'.$tab['title'].'</a>';

$outer_tabs_images .= '<div class="tab-pane fade '.$outer_tab_show.'" id="v-pill-in-'.$outer_title_slug.'" role="tabpanel" aria-labelledby="v-pills-'.$heading.'-tab">';
$outer_tabs_images .= '<img src="'.$tab['image'].'" class="img-fluid">';
$outer_tabs_images .= '</div>';

$outer_tab_count++;
  
  }


$tab_pane .= '<div class="tab-pane fade '.$show.'" id="v-pill-'.$heading_slug.'" role="tabpanel" aria-labelledby="v-pills-'.$heading.'-tab">';
$tab_pane .= '<h2 class="section-heading mt-0">'.$heading.'</h2>';
$tab_pane .= $description;
$tab_pane .= '<div class="row">';
$tab_pane .= '<div class="col-lg-4">';
$tab_pane .= '<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">';

$tab_pane .= $outer_tabs;

$tab_pane .= '</div>';
$tab_pane .= '</div>';

$tab_pane .= '<div class="col-lg-8">';
$tab_pane .= '<div class="tab-content" id="v-pills-tabContent">';
$tab_pane .= $outer_tabs_images;

$tab_pane .= '</div>';
$tab_pane .= '</div>';
$tab_pane .= '</div>';
$tab_pane .= '</div>';

$number++;
    } 

     

  ?>

  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <?php echo $inner_tabs; ?>
          </div>
        </div>
        <div class="col-lg-8 offset-lg-1">
          <div class="tab-content" id="v-pills-tabContent">
            <?php echo $tab_pane; ?>
           </div>
          </div>
        </div>
      </div>
  </section>
<?php } ?>
<?php get_footer(); ?>