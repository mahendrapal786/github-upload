<?php
/*
Template Name: Home Page
*/
get_header();
global $post;
$pageName=get_the_title($post->ID);

$banner_tagline = get_field( "banner_tagline", $post->ID );
$banner_description = get_field( "banner_description", $post->ID );
$banner_image = get_field( "banner_image", $post->ID );
$about_description = get_field( "about_description", $post->ID );
?>
<?php if(!empty($banner_tagline) || !empty($banner_description)) { ?>
<section class="banner" style="background-image:url(<?php echo $banner_image; ?>)">
    <div class="container">
      <div class="row">
        <div class="col">
          <?php if(!empty($banner_tagline)) 
            {
           echo '<div class="transparent-bg">'.$banner_tagline.'</div>';
            }
           echo $banner_description; 
           ?>
          <a href="#" class="btn btn-secondary mt-3">Learn More</a>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
<?php if(!empty($about_description)) { ?>
  <section class="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <span class="h5 section-sub-heading">About Us</span>
          <h2 class="section-heading">Who we are?</h2>
        </div>
        <div class="col-lg-8">
          <?php echo $about_description; ?>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
<?php if(have_rows('our_capabilities',$post->ID)) { ?>
  <section class="capebility">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <span class="h5 section-sub-heading">Our Capabilities</span>
          <h2 class="section-heading"><?php echo get_field( "capabilities_heading", $post->ID ); ?></h2>
        </div>
      </div>
      <div class="section-body">
        <div class="row">
          <?php  
              while(have_rows('our_capabilities',$post->ID)) 
              { 
              the_row();
              $heading = get_sub_field('heading');
              $sub_heading = get_sub_field('sub_heading');
              $description = get_sub_field('description');
              $image = get_sub_field('image');
              $learn_more = get_sub_field('learn_more'); 

  echo '<div class="col-md-4">';
  echo '<div class="card">';
  echo '<div class="img-wrapper">';
  echo '<img src="'.get_template_directory_uri().'/assets/images/blank-16x9.png" class="img-full" alt="'.$heading.'" />';
  echo '<img class="card-img-top main-img" src="'.$image.'" alt="'.$heading.'">';
  echo '</div>';
  echo '<div class="card-body">';
  echo '<h5 class="card-title h6">'.$heading.'</h5>';
  echo '<p class="card-text">'.$sub_heading.'</p>';
  echo $description;
  if(!empty($learn_more)) {
  echo '<a href="'.$learn_more.'" class="btn btn-link-primary pl-0 mt-2 card-link arrow-link">Learn More</a>';
  }
  echo '</div>';
  echo '</div>';
  echo '</div>';
  }
?>
          
        </div>
      </div>
    </div>
  </section>
<?php } ?>
  <section class="we-are-catering">
    <div class="container">
      <div class="bg">
        <h5>We are catering to</h5>
        <h3>Silicon Valley Innovation</h3>
        <div class="icon-plus"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/plus_icon_circle.svg" /></div>
        <h3>Federal Govt Mission Quality</h3>
        <p>A bicoastal firm that combines silicon valley commercial<br /> innovation and speed with federal government mission quality</p>
        <a href="<?php echo get_permalink('17'); ?>" class="btn btn-secondary mt-2">Contact Us</a>

      </div>
    </div>
  </section>
  <section class="customer">
    <div class="container">
      <div class="row justify-content-around">
        <?php if(have_rows('customers_logo',$post->ID)) { ?>
        <div class="col-lg-5">
          <h2 class="section-heading mb-3">Customers</h2>
          <div class="row partners">
            <?php while(have_rows('customers_logo',$post->ID)) 
                  { 
              the_row();
              $logo_image = get_sub_field('logo_image'); 
              echo '<div class="col-4">';
              echo '<div class="item">';
              echo '<img src="'.$logo_image.'" class="img-fluid" alt="Customers Logo" />';
              echo '</div>';
              echo '</div>';
              }
            ?>
          </div>
        </div>
      <?php } 
      if(have_rows('partners_logo',$post->ID)) { ?>

        <div class="col-lg-5">
          <h2 class="section-heading mb-3">Partners</h2>
          <div class="row partners">
            <?php while(have_rows('partners_logo',$post->ID)) 
                  { 
              the_row();
              $partners_image = get_sub_field('partners_image'); 
              echo '<div class="col-4">';
              echo '<div class="item">';
              echo '<img src="'.$partners_image.'" class="img-fluid" alt="Partners Logo" />';
              echo '</div>';
              echo '</div>';
              }
            ?>
            
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </section>
  <?php
    $args = array( 'post_type' => 'post', 'posts_per_page' => 3, 'order' => 'DESC' );
    $posts = new WP_Query( $args );
    if ( $posts->have_posts() ) : 
    ?>
  <section class="letest-new">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <span class="h5 section-sub-heading">Our Talkings</span>
          <h2 class="section-heading">Latest News</h2>
        </div>
      </div>
      <div class="section-body">
        <div class="row">
        <?php  
          foreach($posts->posts as $blogposts) {
          $permalink = get_the_permalink( $blogposts->ID );
          $post_title=$blogposts->post_title;
          $postdate=$blogposts->post_date;
          $postdate = date("d M Y", strtotime($postdate));

          $src = wp_get_attachment_image_src( get_post_thumbnail_id($blogposts->ID), 'full', false, '' ); 
     
          echo '<div class="col-md-4">';
          echo '<div class="card">';
          echo '<div class="img-cnt">';
          echo '<div class="img-wrapper">';
          echo '<img src="'.get_template_directory_uri().'/assets/images/blank-21x9.png" class="img-full" />';
          echo '<img class="card-img-top main-img" src="'.$src[0].'" alt="'.$post_title.'">';
          echo '</div>';
          echo '<div class="content">';
          echo '<span>yourstory</span>';
          echo '</div>';
          echo '</div>';
          echo '<div class="card-body">';
          echo '<h6 class="card-title h6 date">'.$postdate.'</h5>';
          echo '<h5 class="card-text heading">'.$post_title.'</h5>';
          echo '<p>'.wp_trim_words( $blogposts->post_content, 20, '...' ).'</p>';
          echo '<a href="'.$permalink.'" class="btn btn-link-primary pl-0 mt-2 card-link arrow-link">Learn More</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          } ?> 
         </div>
      </div>
    </div>
  </section>
  <?php endif; ?>
<?php get_footer(); ?>