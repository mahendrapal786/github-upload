<?php
/*
Template Name: Career Page
*/
get_header();
global $post;
$pageName=get_the_title($post->ID);
?>

<?php 
/*$job_args = array( 'post_type' => 'jobpost', 'post_status' => 'publish', 'posts_per_page' => -1, 'order' => 'DESC' );
$jobs = new WP_Query( $job_args ); 

if ( $jobs->have_posts() ) :
foreach($jobs->posts as $job) {

	
    $job_id=$job->ID;
	$job_title=$job->post_title;
	$job_description=$job->post_content;

	$jobpost_category = get_the_terms( $job_id, 'jobpost_category' );
	$categories ='';
	foreach($jobpost_category as $category_single) {
	     $categories .= ucfirst($category_single->slug).', ';
	}
	$category = rtrim($categories, ', ');
	echo '<div class="job_category">Job Category: '.$category.'</div>';
	echo '<br>';

	$jobpost_job_type = get_the_terms( $job_id, 'jobpost_job_type' );
	$types ='';
	foreach($jobpost_job_type as $jobtype_single) {
	     $types .= ucfirst($jobtype_single->slug).', ';
	}
	$type = rtrim($types, ', ');
	echo '<div class="job_type">Job Type: '.$type.'</div>';
	echo '<br>';

	$jobpost_location = get_the_terms( $job_id, 'jobpost_location' );
	$locations ='';
	foreach($jobpost_location as $joblocation_single) {
	     $locations .= ucfirst($joblocation_single->slug).', ';
	}
	$location = rtrim($locations, ', ');
	echo '<div class="job_location">Job Location: '.$location.'</div>';
	echo '<br>';
    
    

    echo '<h6 class="job_title">'.$job_title.'</h6>';

    echo $job_description;

    echo '<hr>';

}

	endif;*/

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

                   /* $search_query = "SELECT p.post_title, p.post_excerpt, p.ID FROM wp_posts p JOIN wp_postmeta m1 ON p.ID = m1.post_id WHERE (p.post_title LIKE '%{$s}%' OR m1.meta_key = 'jobpost_location' and m1.meta_value = LIKE '%{$s}%' OR m1.meta_key = 'jobpost_type' and m1.meta_value = LIKE '%{$s}%' OR m1.meta_key = 'jobpost_skills' and m1.meta_value = LIKE '%{$s}%') AND  p.post_status = 'publish' AND p.post_type = 'jobpost' GROUP BY p.ID";*/
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
        <input type="text" class="form-control" placeholder="Search Job Listings by Title, Skills, Location or Keyword" />
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
      <div class="accordion" id="accordionExample">
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

    ?>   
<div class="card">
<div class="card-header" id="heading<?php echo $job_id; ?>">
<div class="btn btn-link btn-block text-left collapce-inner collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo $job_id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $job_id; ?>">
<div class="row align-items-center">
<div class="col-md-5">
<div class="item">
<h6 class="job-tittle"><?php echo $job_title; ?></h6>
<p class="job-s mb-0">Harmonic Inc.</p>
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
<button type="submit" class="btn btn-outline-primary w-100" onclick="request_job(<?php echo $job_id; ?>);">Apply Now</button>
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
   
  	function request_job(job_id)
	{    /* alert(job_id);
    var job_title  = $('#job_hidden_info_'+job_id+' .jobtitle').text();
     alert(job_title);*/
     /*var job_title  = $('#job_hidden_info_'+job_id+' .jobtitle').text();
     alert(job_title);
     var job_location  = $('#job_hidden_info_'+job_id+' .joblocation').text();
     var job_type  = $('#job_hidden_info_'+job_id+' .jobtype').text();

    
    
      $('#jobtitle').val(job_title);
      $('#joblocation').val(job_location);
      $('#jobtype').val(job_type);*/
	
	}

  </script>
<?php get_footer(); ?>