<?php
/**
 * Plugin Name: Stock Table Plugin
 * Description: Plugin para mostrar datos de acciones utilizando ACF.
 * Version: 1.0
 * Author: Daniel Diaz Tag Marketing
 */

if (!defined('ABSPATH')) exit;

// Shortcode function
function display_stock_table($atts) {
    ob_start();

    // Query to get posts
    $args = array(
        'post_type' => 'post', // O el tipo de post que estás usando
        'posts_per_page' => 5, // Puedes ajustar según sea necesario
    );
    $query = new WP_Query($args);

    // Passing the post count to JavaScript
    $post_count = $query->post_count;
    echo "<script>console.log('Number of posts found: " . esc_js($post_count) . "');</script>";

    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();

            // Dump the entire post object
            $post = get_post(); // Obtenemos el objeto del post completo
            echo "<script>console.log(" . json_encode($post) . ");</script>";

            // Get ACF fields
            $logo = get_field('logo');
            $symbol = get_field('symbol');
            $last = get_field('last');
            $netchng = get_field('netchng');
            $bid = get_field('bid');
            $ask = get_field('ask');

            // Output the data in a table format
            ?>
            <div class="stock-table-container">
                <table class="stock-table">
                    <tr>
                        <th>Logo</th>
                        <th>Symbol</th>
                        <th>Last</th>
                        <th>NetChng</th>
                        <th>Bid</th>
                        <th>Ask</th>
                    </tr>
                    <tr class="clickable-row" data-href="<?php echo get_permalink(); ?>">
                        <td><img src="<?php echo esc_url($logo); ?>" alt="<?php echo esc_attr($symbol); ?>" class="stock-logo" /></td>
                        <td><?php echo esc_html($symbol); ?></td>
                        <td><?php echo esc_html($last); ?></td>
                        <td><?php echo esc_html($netchng); ?></td>
                        <td><?php echo esc_html($bid); ?></td>
                        <td><?php echo esc_html($ask); ?></td>
                    </tr>
                </table>
            </div>
            <?php
        endwhile;
        wp_reset_postdata();
    }

    return ob_get_clean();
}


// Register the shortcode
add_shortcode('stock_table', 'display_stock_table');

// Add styles
function stock_table_styles() {
    echo '
    <style>
        .stock-table-container {
            margin: 20px 0;
            font-family: Arial, sans-serif;
        }
        .stock-table {
            width: 100%;
            border-collapse: collapse;
        }
        .stock-table th, .stock-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .stock-table th {
            background-color: #f4f4f4;
        }
        .stock-logo {
            max-width: 50px!important;
            height: 50px!important;
        }
        .clickable-row {
            cursor: pointer;
        }
    </style>
    ';
}
add_action('wp_head', 'stock_table_styles');

// Add JavaScript
function stock_table_scripts() {
    echo '
    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
    ';
}
add_action('wp_footer', 'stock_table_scripts');

?>
