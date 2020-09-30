<?php
/*
Template Name: About Page
*/
get_header();
global $post;
$pageName=get_the_title($post->ID);

$who_we_are = get_field( "who_we_are", $post->ID );
$markets_description = get_field( "markets_description", $post->ID );
$markets_image = get_field( "markets_image", $post->ID );
?>
<section class="banner about-banner" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/about_banner.png)">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
         <h1 class="heading-line-before"><?php echo $pageName; ?></h1>
          <?php
            if ( have_posts() ) : 
              while ( have_posts() ) : the_post();
              the_content();
            endwhile;
            endif;
         ?>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-who-we-are" role="tab" aria-controls="v-pills-who-we-are" aria-selected="true">Who we are?</a>
            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-leadership" role="tab" aria-controls="v-pills-leadership" aria-selected="false">Leadership</a>
            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-markets" role="tab" aria-controls="v-pills-markets" aria-selected="false">Markets</a>
            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-partners" role="tab" aria-controls="v-pills-partners" aria-selected="false">Partners</a>
            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-customers" role="tab" aria-controls="v-pills-customers" aria-selected="false">Customers</a>
          </div>
        </div>
        <div class="col-lg-8 offset-lg-1">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-who-we-are" role="tabpanel" aria-labelledby="v-pills-who-we-are-tab">
              <h2 class="section-heading mt-0">Who we are?</h2>
              <?php echo $who_we_are; ?>
            </div>
            <div class="tab-pane fade" id="v-pills-leadership" role="tabpanel" aria-labelledby="v-pills-leadership-tab">

              <h2 class="section-heading mt-0">Leadership</h2>
              <?php if(have_rows('leadership',$post->ID)) {  
                while(have_rows('leadership',$post->ID)) 
              { 
              the_row();
              $name = get_sub_field('name');
              $designation = get_sub_field('designation');
              $description = get_sub_field('description');
              $photo = get_sub_field('photo');
              
              echo '<div class="row leaaders">';
              if(!empty($photo))
              {
              echo '<div class="col-auto">';
              echo '<img src="'.$photo.'" class="img-fluid" alt="'.$name.'" />';
              echo '</div>';
              }
              echo '<div class="col-md-8">';
              echo '<div class="leaaders">';
              echo '<div class="top-box">';
              if(!empty($name)) {
              echo '<h6>'.$name.'</h6>';
              }
              if(!empty($designation)) {
                echo '<span class="job-title">'.$designation.'</span>';
              }
              echo '</div>';
              echo $description;
              echo '</div>';
              echo '</div>';
              echo '</div>';

             } 
            } ?>
              
            </div>
            <div class="tab-pane fade" id="v-pills-markets" role="tabpanel" aria-labelledby="v-pills-markets-tab">
              <?php echo $markets_description;
               if(!empty($markets_image)) {
                echo '<img src="'.$markets_image.'" class="img-fluid" alt="'.$pageName.'" />';
              }
               ?>
            </div>
            <div class="tab-pane fade" id="v-pills-partners" role="tabpanel" aria-labelledby="v-pills-partners-tab">
              <h2 class="section-heading mb-3">Partners</h2>
          <div class="row partners">
           <?php if(have_rows('partners_logo',5)) {
            while(have_rows('partners_logo',5)) 
                  { 
              the_row();
              $partners_image = get_sub_field('partners_image');
              echo '<div class="col-3">';
              echo '<div class="item border">';
              echo '<img src="'.$partners_image.'" class="img-fluid" alt="Partners" />';
              echo '</div>';
              echo '</div>';
              }
            }
            ?>
            
          </div>
            </div>
            <div class="tab-pane fade" id="v-pills-customers" role="tabpanel" aria-labelledby="v-pills-customers-tab">
              <h2 class="section-heading mb-3">Customers</h2>
          <div class="row partners">
           <?php if(have_rows('customers_logo',5)) { 
            while(have_rows('customers_logo',5)) 
                  { 
              the_row();
              $logo_image = get_sub_field('logo_image'); 
              echo '<div class="col-3">';
              echo '<div class="item border">';
              echo '<img src="'.$logo_image.'" class="img-fluid" alt="Customers Logo" />';
              echo '</div>';
              echo '</div>';
              }
             }
            ?>
            
          </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php get_footer(); ?>