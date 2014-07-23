<?php
/*
 * Template Name: Retina Full Width Page
 * Description: A Page Template that uses full width of view frame -- no sidebar or menu
 *
 * page.php -- note, all calls to bbpress are intercepted first by forum.php
 * 
 * http://codex.wordpress.org/Page_Templates
 *
 */
get_header('retina');

echo '<!--retina-full-width-page.php -->';

?><div id="content-header"><?php



get_template_part('breadcrumbs');

if ( have_posts() ) : while (have_posts()) : the_post();	

	// display title as plain text for single as link for all links	

		the_title(' <h1 class="post-title"> ', ' </h1> ');
		// division wraps the non-sidebar, non-footer content
?></div> <div id="retina-full-width-content-wrapper"> <?php
	
		?> <div class = "post-info">Posted on <?php the_time('F jS, Y'); ?> by <?php the_author_posts_link();?> </div> <?php

		global $more;
		$more = 1;  // http://codex.wordpress.org/Template_Tags/the_content (override the more logic to display whole post/topic in this view)
		the_content();
		edit_post_link('Edit Page', '<p>', '</p>'); 		
	
	// close the main loop		
	endwhile; 
	
		
	// handle not found conditions		
	else:   
			?>
	<h1>No posts found matching your search.<h1>
	<?php
	
endif;

?> </div><?php // note start immediately to create space in inline-block series

 // empty bar to clear formatting -->
?><div class="horbar_clear_fix"></div><?php 
 
get_footer();