<?php
// Enqueue parent and child theme stylesheets
function frost_child_enqueue_styles() {
    $parent_style = 'frost-style'; // Parent theme stylesheet handle

    // Enqueue jQuery
    wp_enqueue_script( 'jquery' );

    // Enqueue parent and child theme stylesheets
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'frost-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

    // Enqueue child theme custom CSS
    wp_enqueue_style( 'frost-child-custom',
        get_stylesheet_directory_uri() . '/custom.css',
        array( $parent_style, 'frost-child-style' ),
        filemtime( get_stylesheet_directory() . '/custom.css' ) // Use file modification time as version
    );

    // Enqueue child theme custom JavaScript
        wp_enqueue_script( 'frost-child-custom-js',
        get_stylesheet_directory_uri() . '/custom.js',
        array( 'jquery' ), // Dependencies (jQuery)
        filemtime( get_stylesheet_directory() . '/custom.js' ), // Use file modification time as version
        true // Enqueue the script in the footer
        );

}
add_action( 'wp_enqueue_scripts', 'frost_child_enqueue_styles' );


function remove_pagination_page_text() {
    wp_enqueue_script( 'custom-pagination', get_stylesheet_directory_uri() . '/custom.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'remove_pagination_page_text' );

function get_related_articles_by_category($atts) {
    $atts = shortcode_atts(array(), $atts);

    $current_post_id = get_the_ID();
    $categories = get_the_category($current_post_id);

    if ($categories) {
        $category_ids = array();
        foreach ($categories as $category) {
            $category_ids[] = $category->term_id;
        }

        $args = array(
            'posts_per_page' => 4,
            'category__in' => $category_ids,
            'post__not_in' => array($current_post_id),
            'orderby' => 'date',
            'order' => 'DESC' // Sort in descending order (newest first)
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $output .= '<h2 class="wp-block-heading has-text-align-left has-contrast-color has-text-color has-max-48-font-size">See other articles</h2>';
            $output .= '<ul class="wp-block-latest-posts__list has-link-color has-text-color has-contrast-color wp-block-latest-posts">';

            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<li><a class="wp-block-latest-posts__post-title" href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }

            $output .= '</ul>';

            // Get the first category of the current post
            $first_category = reset($categories);
            $category_link = get_category_link($first_category);

            $output .= '<p class="more-articles has-contrast-color has-text-color has-link-color"><a href="' . $category_link . '">See all articles</a></p>';

            wp_reset_postdata();

            return $output;
        }
    }

    return 'No related articles found.';
}
add_shortcode('related_articles', 'get_related_articles_by_category');

function get_category_posts_with_pagination($atts) {
    $atts = shortcode_atts(array(), $atts);

    $output = ''; // Initialize the output variable

    if (is_category()) {
        $current_category = get_queried_object();
        $category_id = $current_category->term_id;

        $posts_per_page = 12;
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'posts_per_page' => $posts_per_page,
            'category__in' => $category_id,
            'orderby' => 'date',
            'order' => 'DESC',
            'paged' => $paged
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            $output .= '<ul class="wp-block-latest-posts__list category-posts has-link-color has-text-color has-contrast-color wp-block-latest-posts">';

            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<li><a class="wp-block-latest-posts__post-title" href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }

            $output .= '</ul>';

            if ($query->max_num_pages > 1) {

            // Add pagination links
            $output .= '<div class="pagination-links">';
            
            
                $output .= paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => 'page/%#%/',
                    'current' => $paged,
                    'total' => $query->max_num_pages,
                    'prev_text' => 'Previous',
                    'next_text' => 'Next',
                    'prev_next' => true,
                    'prev_link' => is_first_page() ? '<span class="hide-button">Previous</span>' : '%',
                    'next_link' => is_last_page($query) ? '<span class="hide-button">Next</span>' : '%',
                ));
            
            
            $output .= '</div>';
        }

            wp_reset_postdata();

            return $output;
        }
    }

    return 'No posts found in the category.';
}

// Helper functions for checking if it's the first or last page
function is_first_page() {
    global $paged;
    return ($paged == 1);
}

function is_last_page($query) {
    global $paged;
    return ($paged == $query->max_num_pages);
}

add_shortcode('category_posts_with_pagination', 'get_category_posts_with_pagination');


function add_favicon() {
    echo '<link rel="icon" type="image/png" href="/wp-content/themes/frost-child/images/favicon.png" />';
}
add_action('wp_head', 'add_favicon');


function add_favicon_to_posts() {
    echo '<link rel="icon" href="' . get_site_icon_url() . '" sizes="32x32" />';
}
add_action('wp_head', 'add_favicon_to_posts');

//filter Media & Text block output to add image caption
function media_block_caption( $block_content, $block ) {
    if ( $block['blockName'] === 'core/media-text' ) {
        $mediaId = $block['attrs']['mediaId'];
        if($mediaId){
            $image = get_post($mediaId);
            $image_caption = $image->post_excerpt;
            if($image_caption){
                $content = str_replace('</figure>', '<figcaption>' . $image_caption . '</figcaption></figure>', $block_content);
                return $content;
            }
        }
    }
    return $block_content;
}
 
add_filter( 'render_block', 'media_block_caption', 10, 2 );