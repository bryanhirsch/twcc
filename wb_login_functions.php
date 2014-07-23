<?php 
/*
*
* wb specific functions (for login screen)
*
*/
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/wb_logo_web.png);
            background-size: 318px 318px;
            height: 320px;
            width: 320px;  
            padding-bottom: 0px;
        }
        body.login {
        		background: #eef;
        }
    </style>
<?php }
 
add_action( 'login_enqueue_scripts', 'my_login_logo' );
       
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Will Brownsberger, STATE SENATOR';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );


function my_login_footer($content) {
    echo '<p><strong><em>Please note: You can now post and comment without logging in to WillBrownsberger.com.</em></strong></p><br>
    		<p>If you wish to login anyway, for example, so you can edit your posted comments, and you do not already have a user-id, <a href="/connect/contact">please contact our office.</a></p><br><br>';
    $contentdot = $content . 'xxxxxxxxx';
    return $contentdot;

}

add_filter('login_form','my_login_footer');
