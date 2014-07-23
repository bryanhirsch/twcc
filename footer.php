<?php 
/*
* footer 
*
*/
?>


<?php
$bbp_resp_theme_options_array = get_option( 'bbp_resp_theme_options_array' ); 
/*
* accordion footer area
*
*/
if ((is_front_page() && $bbp_resp_theme_options_array['accordion_posts'] > '')) 
{
 	
	$accordion_posts_array = explode(',',$bbp_resp_theme_options_array['accordion_posts']); 
 	
        echo ' <div id = "accordion-wrapper">';
        foreach ($accordion_posts_array as $fold_content) {
	        $post_f = get_post($fold_content);
	        $post_content = apply_filters( 'the_content', $post_f->post_content );
			{
        		echo '<div class="accordionItem"><h2 class=accordion-header>' . $post_f->post_title . 
        		'</h2> <div class="accordion-content">';
 	                echo $post_content . '</div></div>';
        		}
	        };
	echo '</div>';
}

?>

<div class = "horbar_clear_fix"></div>

<div id = "bottom_widget_area">
	<?php if ( dynamic_sidebar('bottom_sidebar') ) : else : endif; ?>
</div>
</div><!-- view-frame -->
</div> <!-- wrapper -->

<?php wp_footer(); ?>
<div id="calctest"></div>
</body>
</html>
