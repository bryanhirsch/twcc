<?php
/*
* twcc_clippings.php
*
*/


// Register Custom Post Type
function twcc_add_clippings_post_type() {

	$labels = array(
		'name'                => _x( 'News Clips', 'Post Type General Name', 'twcc_text_domain' ),
		'singular_name'       => _x( 'News Clip', 'Post Type Singular Name', 'twcc_text_domain' ),
		'menu_name'           => __( 'News Clips', 'twcc_text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'twcc_text_domain' ),
		'all_items'           => __( 'All Clips', 'twcc_text_domain' ),
		'view_item'           => __( 'View Clip', 'twcc_text_domain' ),
		'add_new_item'        => __( 'Add News Clip', 'twcc_text_domain' ),
		'add_new'             => __( 'Add New', 'twcc_text_domain' ),
		'edit_item'           => __( 'Edit news clip', 'twcc_text_domain' ),
		'update_item'         => __( 'Update news clip', 'twcc_text_domain' ),
		'search_items'        => __( 'Search news clip', 'twcc_text_domain' ),
		'not_found'           => __( 'Clip not found', 'twcc_text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'twcc_text_domain' ),
	);
	$args = array(
		'label'               => __( 'twcc_clippings', 'twcc_text_domain' ),
		'description'         => __( 'Clippings -- links to stories and media', 'twcc_text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor',  'thumbnail', ),
		'taxonomies'          => array( 'publications' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => get_template_directory_uri() . '/images/newspaper.png',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false, // http://stackoverflow.com/questions/8269713/custom-post-type-and-taxonomy-pagination-404-error
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'twcc_clipping', $args );

}

// Hook into the 'init' action
add_action( 'init', 'twcc_add_clippings_post_type', 0 );

// Register Custom Taxonomy
function twcc_publications() {

	$labels = array(
		'name'                       => _x( 'Publications', 'Taxonomy General Name', 'twcc_text_domain' ),
		'singular_name'              => _x( 'Publication', 'Taxonomy Singular Name', 'twcc_text_domain' ),
		'menu_name'                  => __( 'Publications', 'twcc_text_domain' ),
		'all_items'                  => __( 'All Publications', 'twcc_text_domain' ),
		'parent_item'                => __( 'Parent Publication Category', 'twcc_text_domain' ),
		'parent_item_colon'          => __( 'Parent Publication Category', 'twcc_text_domain' ),
		'new_item_name'              => __( 'New Publication', 'twcc_text_domain' ),
		'add_new_item'               => __( 'Add Publication', 'twcc_text_domain' ),
		'edit_item'                  => __( 'Edit Publication', 'twcc_text_domain' ),
		'update_item'                => __( 'Update Publication', 'twcc_text_domain' ),
		'separate_items_with_commas' => __( 'Separate publications with commas', 'twcc_text_domain' ),
		'search_items'               => __( 'Search publications', 'twcc_text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove publications', 'twcc_text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used publications', 'twcc_text_domain' ),
		'not_found'                  => __( 'Not Found', 'twcc_text_domain' ),
	);
	

	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'publications', array( 'twcc_clipping' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'twcc_publications', 0 );


/*
* add metabox for post width, following 
*  http://www.wproots.com/complex-meta-boxes-in-wordpress/
*
*/

function twcc_call_clippings_meta_box($post_type, $post)
{
   add_meta_box(
       'twcc_clippings_box',
       'News Clip Link',
       'twcc_clippings_meta_box',
       'twcc_clipping',
       'normal',
       'high'
   );
}
add_action('add_meta_boxes', 'twcc_call_clippings_meta_box', 10, 2);

function twcc_clippings_meta_box($post, $args)
{
   wp_nonce_field(site_url(__FILE__), 'twcc_clipping_metabox_noncename');

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_clipping_link', true );

	echo '<label for="_clipping_link">';
	_e( 'Enter full URL to clipping (copy and paste from browser)', 'twcc_text_domain' );
	echo '</label> ';
	echo '<input type="text" id="_clipping_link" name="_clipping_link" value="' . esc_attr( $value ) . '" size="80" />';


}

add_action('save_post', 'twcc_save_clippings_meta_box',10,2);
function twcc_save_clippings_meta_box($post_id, $post)
{
   if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
       return;

   if('page' == $_POST['post_type'])
   {
       if(!current_user_can('edit_page', $post_id))
           return;
   }
   else
       if(!current_user_can('edit_post', $post_id))
           return;

   if(isset($_POST['twcc_clipping_metabox_noncename']) && wp_verify_nonce($_POST['twcc_clipping_metabox_noncename'], site_url(__FILE__)) && check_admin_referer(site_url(__FILE__), 'twcc_clipping_metabox_noncename'))
   {
           update_post_meta($post_id, '_clipping_link', wp_kses_data(strip_tags($_POST['_clipping_link'])));
   }
   return;
}

function show_latest_news_clips()
{
$bbp_resp_theme_options_array = get_option( 'bbp_resp_theme_options_array' );		
// disregard http://wordpress.org/support/topic/custom-taxonomies-with-pagination-getting-404-page-not-found
$page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
$publication = get_query_var( 'term');

// WP_Query arguments
$args = array (
	'post_type'              => 'twcc_clipping',
	'post_status'            => 'publish',
	'pagination'             => true,
 //  'posts_per_page'         => $bbp_resp_theme_options_array['publications_list_count'], seemed necessary to eliminate to solve 404 problem
	'paged'                  => $page,
	'ignore_sticky_posts'    => false,
	'order'                  => 'DESC',
	'orderby'                => 'date',
);

$publication = get_query_var( 'term');
if($publication > ''){

$args['tax_query']= array(
		array(
			'taxonomy' => 'publications',
			'field' => 'slug',
			'terms' => $publication
		)
		);
		}

// The Query
$clippings_query = new WP_Query( $args );
	
include(locate_template('clipping-list.php'));
// get_template_part('clipping','list');

// Restore original Post Data
wp_reset_postdata();


}
