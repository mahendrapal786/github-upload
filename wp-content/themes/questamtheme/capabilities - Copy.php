<?php
/*
Template Name: Capabilities Page 2
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
  <section>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pill-strategy" role="tab" aria-controls="v-pills-strategy" aria-selected="true">Strategy</a>
            <a class="nav-link" data-toggle="pill" href="#v-pills-transform" role="tab" aria-controls="v-pills-transform" aria-selected="false">Transform</a>
            <a class="nav-link" data-toggle="pill" href="#v-pills-optimize" role="tab" aria-controls="v-pills-optimize" aria-selected="false">Optimize</a>
            <a class="nav-link" data-toggle="pill" href="#v-pills-innovate" role="tab" aria-controls="v-pills-innovate" aria-selected="false">Innovate</a>
            <a class="nav-link" data-toggle="pill" href="#v-pills-consulting" role="tab" aria-controls="v-pills-consulting" aria-selected="false">Consulting</a>
            <a class="nav-link" data-toggle="pill" href="#v-pills-outsourcing" role="tab" aria-controls="v-pills-outsourcing" aria-selected="false">Outsourcing</a>
          </div>
        </div>
        <div class="col-lg-8 offset-lg-1">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pill-strategy" role="tabpanel" aria-labelledby="v-pills-who-we-are-tab">
              <h2 class="section-heading mt-0">Strategy</h2>
              <p>Quest America Inc. is a global full service technology consulting firm established in 1995, headquartered in San Jose, CA with offices in Spain and India that provides innovative digital and engineering solutions.</p>

              <p>The Digital business unit offers a complete range of next generation transformation services with emphasis on packaged solution implementation, web and mobile application development, cloud, cyber, artificial intelligence and intelligent process automation for Government and Commercial Clients.
              </p>
              <p>
                The Engineering business unit offers ASIC/FPGA/SoC design, verification and validation semiconductor services and end to end embedded product engineering services.
              </p>
              <p>
                Our reputation is built on our past performance, dedication to quality, technical excellence and ability to deliver results on time, every time by innovative use of people, process and technology. The unique combination of our in-depth business understanding, technology expertise, and global knowledge makes QuestAm the superior choice for customers.
              </p>
              <div class="row">
                <div class="col-lg-4">
                  <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pill-in-strategy" role="tab" aria-controls="v-pills-strategy" aria-selected="true">Strategy</a>
                    <a class="nav-link" data-toggle="pill" href="#v-pills-in-transform" role="tab" aria-controls="v-pills-transform" aria-selected="false">Transform</a>
                    <a class="nav-link" data-toggle="pill" href="#v-pills-in-optimize" role="tab" aria-controls="v-pills-optimize" aria-selected="false">Optimize</a>
                    <a class="nav-link" data-toggle="pill" href="#v-pills-in-innovate" role="tab" aria-controls="v-pills-innovate" aria-selected="false">Innovate</a>
                    <a class="nav-link" data-toggle="pill" href="#v-pills-in-consulting" role="tab" aria-controls="v-pills-consulting" aria-selected="false">Consulting</a>

                  </div>
                </div>
                
                  <div class="col-lg-8">
                    <div class="tab-content" id="v-pills-tabContent">
                      <div class="tab-pane fade show active" id="v-pill-in-strategy" role="tabpanel" aria-labelledby="v-pills-who-we-are-tab">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/strategy.png" class="img-fluid">
                      </div>
                      <div class="tab-pane fade" id="v-pills-in-transform" role="tabpanel" aria-labelledby="v-pills-who-we-are-tab">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/strategy.png" class="img-fluid">
                      </div>
                      <div class="tab-pane fade" id="v-pills-in-optimize" role="tabpanel" aria-labelledby="v-pills-who-we-are-tab">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/strategy.png" class="img-fluid">
                      </div>
                      <div class="tab-pane fade" id="v-pills-in-innovate" role="tabpanel" aria-labelledby="v-pills-who-we-are-tab">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/strategy.png" class="img-fluid">
                      </div>
                      <div class="tab-pane fade" id="v-pills-in-consulting" role="tabpanel" aria-labelledby="v-pills-who-we-are-tab">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/strategy.png" class="img-fluid">
                      </div>

                    </div>
                  </div>
                </div>
            </div>
            
            </div>
          </div>
        </div>
      </div>
  </section>
<?php get_footer(); ?>