<footer>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="address">
            <h6 class="h5">QUEST AMERICA</h6>
            <p><img src="<?php echo get_template_directory_uri(); ?>/assets/images/location_icon.svg" /><?php echo  get_theme_mod( 'text_setting'); ?></p>
            <p><img src="<?php echo get_template_directory_uri(); ?>/assets/images/phone.svg" />+1 <?php echo get_theme_mod( 'phone_text_block'); ?></p>
          </div>
          <ul class="social-icon">
            <li><a href="<?php echo LINKEDIN; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/linkedin.svg" /></a></li>
            <li><a href="<?php echo TWITTER; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/twitter.svg" /></a></li>
            <li><a href="<?php echo FACEBOOK; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/medium.svg" /></a></li>
          </ul>
          <p>Copyright © Quest America. All Rights Reserved</p>
        </div>
        <div class="col-md-2">
          <h6>Site Links</h6>
          <?php
            $args = array();
            $args['menu'] = '3';
            $args['echo'] = FALSE;
            $args['menu_class'] = 'footer-link';
            $args['menu_id'] = 'site-links';
            $args['container'] = FALSE;
            $site_links = wp_nav_menu($args);
            echo $site_links;
            ?>
        </div>
        <div class="col-md-2">
          <h6>Capabilities</h6>
          <?php
            $args = array();
            $args['menu'] = '4';
            $args['echo'] = FALSE;
            $args['menu_class'] = 'footer-link';
            $args['menu_id'] = 'capabilities';
            $args['container'] = FALSE;
            $capabilities = wp_nav_menu($args);
            echo $capabilities;
            ?>
        </div>
        <div class="col-md-3 offset-md-1">
          <h6>Get In Touch</h6>
         <?php echo do_shortcode('[contact-form-7 id="125" title="Get In Touch"]'); ?>
        </div>

      </div>
    </div>
  </footer>
   <?php wp_footer(); ?>
   </body>
</html>