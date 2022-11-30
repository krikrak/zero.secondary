<?php

$id = 'gutthumb-' . $block['id'];

$click = get_field('click');


$blockList = get_field("block_select");


$linked = get_field('link');

if (get_field("media_size")) { 
        $size = get_field("media_size"); 
    }
    


// echo get_the_title($post);

if ($linked) :
    echo '<a class="' . acf_classname($block) . '" href="' . esc_url(get_permalink()) . '" rel="bookmark">';
else :
    echo '<div class="' . acf_classname($block) . '">';
endif;
    
        $post = get_post();
        if (has_blocks($post->post_content)) :
            $blocks = parse_blocks($post->post_content);
            
    
    
            foreach ($blocks as $block) {

                
                    if ('core/video' === $block['blockName']) {
                        echo render_block($block);
                        break;
                    } else {
                        if (has_post_thumbnail()) :
                the_post_thumbnail($size);
                        endif;
                    }
                
            }
        
            
        endif;
        
        

    // if (in_array('audio', $blockList)) :
    //     $post = get_post();
    //     if (has_blocks($post->post_content)) :
    //         $blocks = parse_blocks($post->post_content);
    //         foreach ($blocks as $block) {
    //             if ('core/audio' === $block['blockName']) {
    //                 echo render_block($block);
    //                 break;
    //             }
    //         }
    //     endif;
    //     endif;

    // if (in_array('link', $blockList)) :
    //     $post = get_post();
    //     if (has_blocks($post->post_content)) :
    //         $blocks = parse_blocks($post->post_content);
    //         foreach ($blocks as $block) {
    //             if ('core/html' === $block['blockName']) {
    //                 echo render_block($block);
    //                 break;
    //             }
    //         }
    //     endif;
    //     endif;

    // if (in_array('quote', $blockList)) :
    //     $post = get_post();
    //     if (has_blocks($post->post_content)) :
    //         $blocks = parse_blocks($post->post_content);
    //         foreach ($blocks as $block) {
    //             if ('core/quote' === $block['blockName'] || 'core/pullquote' === $block['blockName']) {
    //                 echo render_block($block);
    //                 break;
    //             }
    //         }
    //     endif;
    //     endif;

    // if (in_array('any', $blockList)) :
    //     $post = get_post();
    //     if (has_blocks($post->post_content)) :
    //         $blocks = parse_blocks($post->post_content);
    //         if ($blocks[0]) :
    //             echo render_block($blocks[0]);
    //         endif;
    //     endif;
    //     endif;



        



if ($linked) :
    echo '</a>';
else :
    echo '</div>';
endif;
