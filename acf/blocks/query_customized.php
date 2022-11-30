<?php


/* POST TYPE */
if (get_field('post_type')) :
    $post_type = get_field("post_type");
else : $post_type = ['post'];
endif;

/* AJOUT DU POST TYPE DANS LA LISTE DES CLASSES */
foreach ($post_type as $key=>$item){
    $className .= ' ' . $item . ' ';
}

if (get_field("posts_per_page")) :
    $posts_per_page = get_field("posts_per_page");
else : $posts_per_page = get_option('posts_per_page');
endif;

if (get_field("order")) :
    $order = get_field("order");
else : $order = 'DESC';
endif;

if (get_field("orderby")) :
    $orderby = get_field("orderby");
else : $orderby = 'date';
endif;

if (get_field("offset")) :
    $offset = get_field("offset");
else : $offset = 0;
endif;

if (get_field("post_parent")) :
    $post_parent = get_queried_object_id();
else : $post_parent = ''; endif;

if (get_field("author__in")) :
    $author__in = get_field("author__in");
else : $author__in = ''; endif;


// $post_type = get_field('post_type');
// print_r($post_type);
// if ($post_type) :
//     foreach ($post_type as $value) :
//         echo $value;
//     endforeach;
// endif;

if (get_field('post_status')) :
    $post_status = get_field("post_status");
else : $post_status = 'publish';
endif;


if (get_field('meta_key')) :
    $meta_key = get_field("meta_key");
else : $meta_key = '';
endif;

if (get_field('post_in')) :
    $post_in = get_user_favorites();
else : $post_in = '';
endif;


if (have_rows('taxo_filter_array')) :
    $tax_OR_tax = ['relation' => 'OR'];
    while (have_rows('taxo_filter_array')) : the_row();
        $taxonomy_terms = get_sub_field('taxonomy_terms');

        if ($taxonomy_terms) :
            $tax_AND_tax = ['relation' => 'AND'];

            foreach ($taxonomy_terms as $value) :
                $list = [
                    'taxonomy'      => $value->taxonomy,
                    'field'         => 'term_id',
                    'terms'         => $value->term_id,
                ];
                array_push($tax_AND_tax, $list);
            endforeach;
        endif;
        array_push($tax_OR_tax, $tax_AND_tax);
    endwhile;
else :

endif;


$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;



$args = array(
    'post_type'             => $post_type,
    'post__not_in'          => array(get_queried_object_id()), // Current ID
    'post__in'              => $post_in,
    'posts_per_page'        => $posts_per_page,
    // 'ignore_sticky_posts'   => 1,
    'order'                 => $order,
    'orderby'               => $orderby,
    'post_parent'           => $post_parent,
    // 'post_parent'    => $post->ID,
    'post_status'           => $post_status,
    'offset'                => $offset,
    'meta_key'              => $meta_key,
    'tax_query'             => $tax_OR_tax,
    'author__in'            => $author__in,
    'paged'                 => $paged, 
    'meta_query'            => ''
    
);

if (get_field('carousel_mod')) : 
    $itemClass .= 'carousel__slide';    
    // if (get_field('grid_columns')) : 
    //     $className .= 'slides-' . get_field('grid_columns');  
    // endif;
endif;
// if (get_field('ingrid_mod')) :
//     if (get_field('grid_columns')) : 
//         $className .= 'columns-' . get_field('grid_columns');  
//     endif;
// endif;

if (get_field("template_choice")): 
    $template_part = 'template-parts/' . get_field("template_choice") . '';
else : 
    $template_part = 'template-parts/item';
endif;

$wp_query = new WP_Query($args);

if ($wp_query->have_posts()) :

    echo '<div class="' . acf_classname($block) . '' . $className . ' ">';
    
    while ($wp_query->have_posts()) : $wp_query->the_post();
    // https://stackoverflow.com/questions/51569217/wordpress-get-template-part-pass-variable
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
    // print_r( $wp_query->query_vars);
    
    echo '</div>';

    // $option_ajax = get_field("enable_ajax", "option");
    // if ($option_ajax):
    //     if ( $wp_query->max_num_pages > 1 ) :
    //         echo '<div class="loadmore"><span id="misha_loadmore">Afficher plus</span></div>'; // you can use <a> as well
    //     endif;
    //     endif;

    
else :
    echo '<div class="' . acf_classname($block) . '">';
    get_template_part('template-parts/empty', get_post_type());
    echo '</div>';

endif;

// 4. On réinitialise à la requête principale (important)
wp_reset_postdata();