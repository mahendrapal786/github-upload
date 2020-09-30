<?php
/*
Template Name: Contact Page
*/
get_header();
global $post;
$pageName=get_the_title($post->ID);
?>
<section class="banner about-banner" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/contact_banner.png)">
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
        <?php if(have_rows('contact_info',$post->ID)) { ?>
        <div class="col-lg-5 offices">
          <div class="item">
            <h2>Offices</h2>
            <?php 
            while(have_rows('contact_info',$post->ID)) 
              { 
              the_row();
              $address_country = get_sub_field('address_country');
              $address = get_sub_field('address');
              $contact_number = get_sub_field('contact_number');   
              echo '<div class="address">';
              if(!empty($address_country))
              {
              echo '<h5 class="title">'.$address_country.'</h5>';
              }
              if(!empty($address))
              {
              echo '<p><img src="'.get_template_directory_uri().'/assets/images/loacation_blue.svg" />'.$address.'</p>';
              }
              if(!empty($contact_number))
              {
              echo '<a href="tel:+1'.str_replace(array( '(', ')', '-', ' ' ), '', $contact_number).'"><img src="'.get_template_directory_uri().'/assets/images/phone_blue.svg" />+1 '.$contact_number.'</a>';
              }
              echo '</div>';
              }
              ?>
            
          </div>
          </div>
        <?php } ?>

          <div class="col-lg-6 offset-lg-1">

            <div class="form-wrapper mt-5">
              <h2>Get in touch</h2>
              <?php echo do_shortcode('[contact-form-7 id="115" title="Contact Us"]'); ?>
            </div>

          </div>
        </div>
  </section>
<?php get_footer(); ?>