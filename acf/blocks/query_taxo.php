<?php 
if (get_field('meta_key')) :
    $meta_key = get_field("meta_key");
else : $meta_key = '';
endif;

if (get_field('carousel_mod')) : 
    $itemClass = 'carousel__slide';    
    if (get_field('grid_columns')) : 
        $className = 'slides-' . get_field('grid_columns');  
    endif;
elseif (get_field('ingrid_mod')) :
    if (get_field('grid_columns')) : 
        $className = 'columns-' . get_field('grid_columns');  
    endif;
endif;

if (get_field("template_choice")): 
    $template_part = 'template-parts/' . get_field("template_choice") . '';
else : 
    $template_part = 'template-parts/vignette';
endif;





foreach (get_field('taxonomies') as $taxonomy) {

    // print_r($taxonomy);

//     echo 'coucou';
//     // if( $terms = get_terms( array( 'taxonomy' => $taxonomy->name, 'orderby' => 'name' ) ) ) : 
//     //     echo '<ul>';
// 	// 	// echo '<legend>' . $taxonomy->label . '</legend>';
// 	// 	foreach ( $terms as $term ) :
// 	// 		echo '<li>';
// 	// 		echo '<input name="' . $taxonomy->name . '[]" type="checkbox" value="' . $term->term_id . '" id="' . $term->term_id . '"/>';
// 	// 		echo '<label for="' . $term->term_id . '">' . $term->name . '<span class="count">' . $term->count . '</span></label>';
// 	// 		echo '</li>';
// 	// 	endforeach;
// 	// 	echo '</ul>';
// 	// endif;


$terms = get_terms( array(
    'taxonomy' => $taxonomy->name, //empty string(''), false, 0 don't work, and return empty array
    // 'orderby' => 'count',
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => true, //can be 1, '1' too
    // 'include' => 'all', //empty string(''), false, 0 don't work, and return empty array
    // 'exclude' => 'all', //empty string(''), false, 0 don't work, and return empty array
    // 'exclude_tree' => 'all', //empty string(''), false, 0 don't work, and return empty array
    // 'number' => '0', //can be 0, '0', '' too
    // 'offset' => '0',
    // 'fields' => 'all',
    // 'name' => '',
    // 'slug' => '',
    // 'hierarchical' => true, //can be 1, '1' too
    // 'search' => '',
    // 'name__like' => '',
    // 'description__like' => '',
    // 'pad_counts' => false, //can be 0, '0', '' too
    // 'get' => '',
    // 'child_of' => false, //can be 0, '0', '' too
    // 'childless' => false,
    // 'cache_domain' => 'core',
    // 'update_term_meta_cache' => true, //can be 1, '1' too
    // 'meta_query' => '',
    // 'meta_key' => array(),
    // 'meta_value'=> '',
    // 'parent'   => 0,
) );



$exclude = array("unknow");

if( $terms = get_terms( array( 'taxonomy' => $taxonomy->name, 'orderby' => 'name' ) ) ) : 
    
    echo '<div class="' . acf_classname($block) . '">';
	
	foreach ( $terms as $term ) :
        if (!in_array($term->slug, $exclude)) :
            echo '<section class="' . $taxonomy->name . '">';
            echo '<header class="wp-block-group ">';
            echo '<div class="title">';
            echo '<a class="taxo_link" href="' . get_term_link( $term->slug, $taxonomy->name ) . '">';
            echo '<span class=""> ' . $term->name . '</span>';
            echo '<span class="count"> ' . $term->count . '</span>';
            echo '</div>';
            echo '</a>';
            echo '</header>';


            $args = array(
                'post_type'             => 'post',
                // 'post__not_in'          => array(get_queried_object_id()), // Current ID
                // 'posts_per_page'        => $posts_per_page,
                'posts_per_page'        => 2,
                'ignore_sticky_posts'   => 0,
                'order'                 => 'DESC',
                'orderby'               => 'post_views',
                // 'post_parent'           => $children_only,
                // 'post_status'           => $post_status,
                // 'offset'                => $offset,
                'meta_key'              => $meta_key,
                'tax_query'             => [
                    [
                        'taxonomy' => $taxonomy->name,
                        'field' => 'slug',
                        'terms' => $term->slug,
                    ],
                ],
            );


            $wp_query = new WP_Query($args);

            if ($wp_query->have_posts()) :
                echo '<div class="query_post">';
                while ($wp_query->have_posts()) : $wp_query->the_post();    
                    get_template_part( $template_part , get_post_type(), 
                        array( 
                            'class' => $itemClass,
                            // 'data'  => array(
                            //     'size' => 'large',
                            //     'is-active' => true,
                            // )
                        ) 
                    );
                endwhile;
                echo '</div>';
                wp_reset_postdata();
            endif;
            echo '</section>';

        endif;
	endforeach;
    echo '</div>';
endif;


// // if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){

//     echo '<div class="' . acf_classname($block) . '">';
//     foreach ( $terms as $term ) :
//         if (!in_array($term->slug, $exclude)) :
            
        
//         echo '<section class="">';
//         echo '<header class="wp-block-group">';
//         echo '<h2 class="title has-text-align-center has-large-font-size">';
//         echo '<a class="taxo_link" href="' . get_term_link( $term->slug, 'post_tag' ) . '">';
//         echo '<span class="title"> ' . $term->name . '</span>';
//         echo '<span class="count"> ' . $term->count . '</span>';
//         echo '</h2>';
//         echo '</a>';
//         echo '</header>';

//         // echo '<ul>';
//         // echo '<li>' . $term->term_id . '</li>';
//         // echo '<li>' . $term->slug . '</li>';
//         // echo '<li>' . $term->count . '</li>';
//         // echo '<li></li>';
//         // echo '<li>' . $term->description . '</li>';
//         // echo '</ul>';
        
        
//         $args = array(
//             'post_type'             => 'post',
//             // 'post__not_in'          => array(get_queried_object_id()), // Current ID
//             // 'posts_per_page'        => $posts_per_page,
//             'posts_per_page'        => 4,
//             'ignore_sticky_posts'   => 0,
//             // 'order'                 => $order,
//             // 'orderby'               => $orderby,
//             // 'post_parent'           => $children_only,
//             // 'post_status'           => $post_status,
//             // 'offset'                => $offset,
//             'meta_key'              => $meta_key,
//             'tax_query'             => [
//         [
//             'taxonomy' => 'post_tag',
//             'field' => 'slug',
//             'terms' => $term->slug,
//         ],
//     ],
//         );

        

//         $wp_query = new WP_Query($args);
        
//         if ($wp_query->have_posts()) :
//             echo '<div class="query_post">';
//             while ($wp_query->have_posts()) : $wp_query->the_post();    
//                 get_template_part( $template_part , get_post_type(), 
//             array( 
//                 'class' => $itemClass,
//                 // 'data'  => array(
//                 //     'size' => 'large',
//                 //     'is-active' => true,
//                 // )
//             ) 
//         );
//             endwhile;
//             echo '</div>';
            
//             wp_reset_postdata();
//         endif;

        
        
        
        
//         echo '</section>';
        
        
//         endif;
//     endforeach;
//     echo '</div>';
// // }

}

?>