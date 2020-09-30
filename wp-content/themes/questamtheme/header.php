<?php
/**
* The header for our theme
*/
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="dns-prefetch" href="<?php echo home_url(); ?>" />
  <link rel="preload" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.min.css" as="style" />
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
   <!-- header -->
   <nav class="navbar navbar-expand-lg navbar-primary">
    <div class="container">
      <a class="navbar-brand" href="<?php echo home_url(); ?>">QUEST AMERICA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/menu-icon.svg" width="30" height="30" />
        </span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <?php
            $args = array();
            $args['menu'] = '2';
            $args['echo'] = FALSE;
            $args['menu_class'] = 'navbar-nav ml-auto';
            $args['menu_id'] = 'main';
            $args['container'] = FALSE;
            $headermenu = wp_nav_menu($args);
            echo $headermenu;
            ?>
      </div>
    </div>
  </nav>