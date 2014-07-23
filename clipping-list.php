<?php
// multiple clipping list handler 
// The Loop

if ( $clippings_query->have_posts() ) {

echo '<ul class="post-list">' . 
	  '<li class = "pl-odd"><ul class = "pl-headers"><li class="pl-post-title">Headline</li><li class = "pl-post-author">Publication</li><li class = "pl-post-date-time">Date</li></ul></li>';
	
$count = 1; 
	while ( $clippings_query->have_posts() ) {
		$clippings_query->the_post();
	$count = $count+1;
	if($count % 2 == 0){$row_class = "pl-even";} else {$row_class = "pl-odd";} 	
	 
			echo '<li class ="' . $row_class . '"><ul class="pl-post-item">' . 			
			'<li class="pl-post-title"><a href="'. get_post_meta($clippings_query->post->ID, '_clipping_link',true) .'" rel="bookmark" title="View this story"  target = "_blank">' . get_the_title() . '</a></li>' .
			'<li class="pl-post-author">'. get_the_term_list($clippings_query->post->ID, 'publications', '',',')   .'</li>' .
			'<li class="pl-post-date-time">'. get_the_date() .'</li>'.
         '</ul>' .
			'<div class="pl-post-excerpt">' . get_the_content() . ' <br /> <a href="' . get_post_meta($clippings_query->post->ID, '_clipping_link',true)  .'" rel="bookmark" title="Read the rest of this post" target = "_blank">Read More &raquo; </a></div>'.         
         '</li>';

 	} 

	echo '</ul>'; // post-list

	// show multipost pagination links

	?> 
	<div id = "next-previous-links">
	<div id="previous-posts-link"> <?php
	previous_posts_link('<strong>&laquo; Newer Clippings </strong>');
	?> </div> <?php
	
	?> <div id="next-posts-link">  <?php
	next_posts_link('<strong>Older Clippings &raquo; </strong>', $clippings_query->max_num_pages);
	?> </div>
	</div> <?php
	}	
	// handle not found conditions		
	else{   
			?>
	<div id="not-found">
	<h3>No clippings found matching your search.</h3>
	</div>
	<?php
	}
