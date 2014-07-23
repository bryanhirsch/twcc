<?php
/*
* included in child theme settings within bbp_resp_child_theme_settings class definition
*
*/

class bbp_resp_publications_tab {

	public function __construct()
	{	
    		add_action( 'admin_init', array( $this, 'publications_tab_init' ) );

		global $bbp_resp_theme_options;
		$this->options = $bbp_resp_theme_options->theme_options;
     	}


    	public function publications_tab_init()
    	{

/*
	* register sections and fields
	*
	*/

        add_settings_section(
            'publications_settings', // ID
            'publications Settings', // Title
            array( $this, 'publications_settings_info' ), // Callback
            'bbp_resp_publications_options' // Page
        ); 
        
        add_settings_field(
            'show_publications', 
            'Show publications?', 
            array( $this, 'show_publications_callback' ), 
            'bbp_resp_publications_options', 
            'publications_settings'
        );     
        add_settings_field(
            'publications_list_count', 
            'Number of publications to show on a page', 
            array( $this, 'publications_list_count_callback' ), 
            'bbp_resp_publications_options', 
            'publications_settings'
        );
        
       add_settings_field(
            'publications_home', 
            'Tab serving as top of publication hierarchy:', 
            array( $this, 'publications_home_callback' ), 
            'bbp_resp_publications_options', 
            'publications_settings'
        );
       
	
	} // publications_tab_init()
 
 public function sanitize( $input )
{

       /* note -- have to reference this explicitly here b/c accessing through :: operator */
       global $bbp_resp_theme_options;
       $new_input = $bbp_resp_theme_options->theme_options;

		$new_input['show_publications'] = absint( $input['show_publications'] ); 
       if( isset( $input['publications_list_count'] ) )
            $new_input['publications_list_count'] = absint( $input['publications_list_count'] );       
   	 if( isset( $input['publications_home'] ) )
            $new_input['publications_home'] = absint( $input['publications_home'] );       

return $new_input; 
        
}
 

   	
  	public function publications_settings_info()
    	{
    	print "publications settings info!";
	}
	
	/*
	* individual field callbacks
	*
	*/
		public function show_publications_callback()
	{  

				printf(
            '<input type="checkbox" id="show_publications" name="bbp_resp_theme_options_array[show_publications]" value="%s" %s />',
            1, checked( '1',  $this->options['show_publications'], false )
        		);
	        
	}


	public function publications_list_count_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="publications_list_count" name="bbp_resp_theme_options_array[publications_list_count]">%s </textarea>',
	            isset( $this->options['publications_list_count'] ) ? esc_textarea( $this->options['publications_list_count']) : ''

	        );
	}

	public function publications_home_callback()
	{  
	        printf(
	            '<textarea type="text" cols="1" rows="1"  id="publications_home" name="bbp_resp_theme_options_array[publications_home]">%s </textarea>',
	            isset( $this->options['publications_home'] ) ? esc_textarea( $this->options['publications_home']) : ''

	        );
	}

	

} // close class
if (is_admin())
$bbp_resp_publications_tab = new bbp_resp_publications_tab();