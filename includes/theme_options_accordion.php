<?php
/*
* included in child theme settings within bbp_resp_child_theme_settings class definition
*
*/

class bbp_resp_accordions_tab {

   	public function print_notes()
    	{
    	print "Get the accordion plugin!";
	}

} // close class
class bbp_resp_accordion_tab{

	public function __construct()
	{	
    		add_action( 'admin_init', array( $this, 'accordion_tab_init' ) );

		global $bbp_resp_theme_options;
		$this->options = $bbp_resp_theme_options->theme_options;
     	}


    	public function accordion_tab_init()
    	{

	/*
	* register sections and fields
	*
	*/

        add_settings_section(
            'accordion_settings', // ID
            'Accordion settings', // Title
            array( $this, 'accordion_settings_info' ), // Callback
            'bbp_resp_accordion_options' // Page
        ); 

      add_settings_field(
            'accordion_posts', 
            'Posts list:', 
            array( $this, 'accordion_posts_callback' ), 
            'bbp_resp_accordion_options', 
            'accordion_settings'
        ); 


	
	} // accordion_tab_init()
 
 public function sanitize( $input )
{

        /* note -- have to reference this explicitly here b/c accessing through :: operator */
	global $bbp_resp_theme_options;
	$new_input = $bbp_resp_theme_options->theme_options;


      if( isset( $input['accordion_posts'] ) )
            $new_input['accordion_posts'] = wp_kses_data( $input['accordion_posts'] );
      if( isset( $input['accordion_event'] ) )
            $new_input['accordion_event'] = wp_kses_data( $input['accordion_event'] );                    
      if( isset( $input['mobile_only_folds'] ) )
            $new_input['mobile_only_folds'] = absint( $input['mobile_only_folds'] );        

return $new_input; 
        
}
 

public function accordion_settings_info()
{
print "This setting expects a list of posts, page or topics, referenced by ID number and separated by commas.  Don't put a comma after the final post.";
}

/*
* individual field callbacks
*
*/

public function accordion_posts_callback()
{
        printf(
            '<textarea type="text" cols="80" rows="3"  id="accordion_posts" name="bbp_resp_theme_options_array[accordion_posts]">%s </textarea>',
            isset( $this->options['accordion_posts'] ) ? esc_textarea( $this->options['accordion_posts']) : ''
        );
}



} // close class
if (is_admin())
$bbp_resp_accordion_tab = new bbp_resp_accordion_tab();