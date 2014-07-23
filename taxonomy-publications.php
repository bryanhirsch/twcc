<?php
/*
*
* taxonomy-publications.php
*
*/
get_header();

echo '<!-- taxonomy-publications.php -->';

echo '<div id = "content-header">';  
 get_template_part('breadcrumbs'); 
 echo '<h1>'; 
		single_cat_title();
		echo '</h1>'; 
?> <h4> 		

<?php
$publications = get_terms('publications','orderby=name&hierarchival=1');

// var_dump($publications);
?><select name='pubs' id ='pubs' class='postform' >
   <option value="">select publication</option>
<?php
foreach($publications as $publication){
echo '   <option value ="'. $publication->slug .'">'.$publication->name . ' ('.$publication->count . ')</option>
';
} ?>
</select>


<script type="text/javascript"><!--
    var dropdown = document.getElementById("pubs");
    function onCatChange() {
	if ( dropdown.options[dropdown.selectedIndex].value > '' ) {
			location.href = "<?php echo get_option('home');
?>/publications/"+dropdown.options[dropdown.selectedIndex].value;
}
    }
    dropdown.onchange = onCatChange;
--></script>








		
		</h4></div>   
	  
<?php
echo 	'<div id = "post-list-wrapper">';

// multiple post handler 
show_latest_news_clips();
echo '</div>';
?> 

	
 <!-- empty bar to clear formatting -->
<div class="horbar_clear_fix"></div><?php 
 
get_footer();