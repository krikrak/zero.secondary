<?php 

?>
<form id="misha_filters" action="#" class="<? echo acf_classname($block) ?>">
<?

foreach (get_field('taxonomies') as $taxonomy) {
	// print_r( $taxonomy);
	// echo $taxonomy->label;
	if( $terms = get_terms( array( 'taxonomy' => $taxonomy->name, 'orderby' => 'name' ) ) ) : 
		
		echo '<ul>';
		// echo '<legend>' . $taxonomy->label . '</legend>';
		foreach ( $terms as $term ) :
			echo '<li>';
			echo '<input name="' . $taxonomy->name . '[]" type="checkbox" value="' . $term->term_id . '" id="' . $term->term_id . '"/>';
			echo '<label for="' . $term->term_id . '">' . $term->name . '<span class="count">' . $term->count . '</span></label>';
			echo '</li>';
		endforeach;
		echo '</ul>';
	endif;
}
?>

    
	
    
	<input type="hidden" name="action" value="mishafilter" />
	<!-- <button>Apply filter</button> -->
</form>
