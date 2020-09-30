<?php
/*
Template Name: Career Page
*/
get_header();
global $post;
$pageName=get_the_title($post->ID);
?>
<section class="banner about-banner" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/contact_banner.png)">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">

          <h1 class="heading-line-before">Open Job Listings</h1>
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
               <?php 
                    global $wpdb;
                    
                    if (isset($_GET['page'])) {
                    $paged = $_GET['page'];
                    } else {
                    $paged = 1;
                    }

                    $post_per_page = 10;
                    $offset = ($paged - 1)*$post_per_page;
                   
                   $search_query = "SELECT ID, post_title, post_content from wp_posts where post_status='publish' AND post_type = 'jobpost' order by ID DESC";

                   $total_record = count($wpdb->get_results($search_query, ARRAY_A));

                    $max_num_pages  = ceil($total_record/ $post_per_page);
                    $wp_query->found_posts = $total_record;
                    $wp_query->max_num_pages = $max_num_pages;

                    $limit_query    =   " LIMIT ".$post_per_page." OFFSET ".$offset;

                    $pageposts =   $wpdb->get_results($search_query.$limit_query, ARRAY_A);

                    if ($pageposts):
                    ?>
  <section class="search-section">
    <div class="container">
      <div class="seatch-cnt">
        <input type="text" class="form-control job_title_search" placeholder="Search Job Listings by Title, Skills, Location or Keyword" name="s" autocomplete="off" />
      </div>
    </div>
  </section>
  <section class="job-listing">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <h4>Jobs</h4>
        </div>
        <div class="col-md-2">
          <h4>Location</h4>
        </div>
        <div class="col-md-auto">
          <h4>Type</h4>
        </div>
      </div>
      <div class="accordion job_searh_response" id="accordionExample">
   <?php 

   $number=1;
    global $post; 
    foreach ($pageposts as $post):

    $job_title=$post['post_title'];
    $job_description=$post['post_content'];

    $job_id=$post['ID'];
    
    $location=get_post_meta( $job_id, 'jobpost_location', true );
    $type=get_post_meta( $job_id, 'jobpost_type', true );
    $skills=get_post_meta( $job_id, 'jobpost_skills', true );
    $rate=get_post_meta( $job_id, 'rate', true );
    $company_name=get_post_meta( $job_id, 'company_name', true );

    ?>   
<div class="card">
<div class="card-header" id="heading<?php echo $job_id; ?>" currentTab="<?php echo $job_id; ?>">
<div class="btn btn-link btn-block text-left collapce-inner collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $job_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $job_id; ?>">
<div class="row align-items-center">
<div class="col-md-5">
<div class="item">
<h6 class="job-tittle"><?php echo $job_title; ?></h6>
<?php if(!empty($company_name)) {
  echo '<p class="job-s mb-0">'.$company_name.'</p>';
} 
?>
</div>
</div>
<div class="col-md-2">
<p><?php echo $location; ?></p>
</div>
<div class="col-md-5">
<div class="row justify-content-between">
<div class="col-auto">
<p><?php echo $type; ?></p>
</div>
<div class="col-auto">
<button type="submit" class="btn btn-outline-primary w-100">Apply Now</button>
</div>
</div>
</div>
</div>
</div>
<div id="collapse<?php echo $job_id; ?>" class="collapse" aria-labelledby="heading<?php echo $job_id; ?>" data-parent="#accordionExample">
<div class="card-body">
<div class="row mt-3">
<div class="col-md-6 pr-lg-5">
<h6>Project Description</h6>
<?php echo $job_description; ?>
<div class="row mt-5">
<div class="col-sm-3"><strong>Job ID:</strong></div>
<div class="col-sm-9">1000111</div>
</div>
<div class="row">
<div class="col-sm-3"><strong>Job ID:</strong></div>
<div class="col-sm-9">6 months with possible extension until Dec 2019</div>
</div>
<div class="row">
<div class="col-sm-3"><strong>Start Date:</strong></div>
<div class="col-sm-9">ASAP</div>
</div>
<?php
 if(!empty($rate)) {
echo '<div class="row">';
echo '<div class="col-sm-3"><strong>Rate:</strong></div>';
echo '<div class="col-sm-9">'.$rate.'</div>';
echo '</div>';
}
 if(!empty($skills)) {
echo '<div class="row">';
echo '<div class="col-sm-3"><strong>Key Skills:</strong></div>';
echo '<div class="col-sm-9">'.$skills.'</div>';
echo '</div>';
}
?>
</div>
<div class="col-md-6">
<div class="inner form-bg">
<div class="form-top">
<h6>Apply For Job</h6>
</div>
<div class="form-wrapper">
	<div class="job_hidden_info_<?php echo $job_id; ?> d-none">
    <div class="jobtitle"><?php echo $job_title; ?></div>
		<div class="joblocation"><?php echo $location; ?></div>
		<div class="jobtype"><?php echo $type; ?></div>
    <div class="jobskills"><?php echo $skills; ?></div>
    <div class="company"><?php echo $company_name; ?></div>
	</div>
<?php echo do_shortcode('[contact-form-7 id="151" title="Career"]'); ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
    <?php $number++; 
       setup_postdata($post);
       endforeach; 
      else : 
        echo '<p class="no-result">No job Found Please Try With an Alternate Word.</p>';
      endif;  ?>

        
      </div>

    </div>
  </section>
<script type="text/javascript">
jQuery(document).ready(function($) {
  $(document).on("click", "#accordionExample .card-header" , function() {
   var active_tab=$(this).attr('currentTab');
   
   var job_title  = $('.job_hidden_info_'+active_tab+' .jobtitle').text();
   var job_location  = $('.job_hidden_info_'+active_tab+' .joblocation').text();
   var job_type  = $('.job_hidden_info_'+active_tab+' .jobtype').text();
   var job_skills  = $('.job_hidden_info_'+active_tab+' .jobskills').text();
   var company_name  = $('.job_hidden_info_'+active_tab+' .company').text();
    $('input[name=jobtitle]').val(job_title);
    $('input[name=joblocation]').val(job_location);
    $('input[name=jobtype]').val(job_type);
    $('input[name=jobskils]').val(job_skills);
    $('input[name=jobcompany]').val(company_name);
  });

 $('.job_title_search').keyup(function(){ 
   var query=$(this).val();
   var str = '&query=' + query + '&action=search_ajax_request';

 $.ajax({
     url: ajaxurl,
     dataType: "json",
     type: 'POST',
     data: str,
        success:function(data) {
         $('div.job_searh_response').html(data.job_list);
         },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });
 });

});
</script>
<?php get_footer(); ?>