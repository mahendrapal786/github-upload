<?php
/**
 * The main template file
 */

get_header(); ?>

<?php if ( have_posts() ) : 
			while ( have_posts() ) : the_post();
				
                the_title();

				the_excerpt();
				
			 endwhile;
 
     else : 
   ?>
     	
 <h1 class="entry-title"><?php _e( 'No posts to display', 'union' ); ?></h1>
				

		<?php	endif;  ?>

<?php get_footer(); ?>