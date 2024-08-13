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
        'posts_per_page' => -1, // Ajusta según sea necesario
    );
    $query = new WP_Query($args);

    // Verifica si hay posts
    if ($query->have_posts()) {
        echo '<div class="stock-table-container">';
        echo '<table class="stock-table">';
        echo '<tr>';
        echo '<th>Logo</th>';
        echo '<th>Symbol</th>';
        echo '<th>Last</th>';
        echo '<th>NetChng</th>';
        echo '<th>Bid</th>';
        echo '<th>Ask</th>';
        echo '</tr>';

        // Loop through the posts
        while ($query->have_posts()) {
            $query->the_post();

            // Get ACF fields
            $logo = get_field('logo');
            $symbol = get_field('symbol');
            $last = get_field('last');
            $netchng = get_field('netchng');
            $bid = get_field('bid');
            $ask = get_field('ask');

            // Output each post's data in a table row
            echo '<tr class="clickable-row" data-href="' . esc_url(get_permalink()) . '">';
            echo '<td><img src="' . esc_url($logo) . '" alt="' . esc_attr($symbol) . '" class="stock-logo" /></td>';
            echo '<td>' . esc_html($symbol) . '</td>';
            echo '<td>' . esc_html($last) . '</td>';
            echo '<td>' . esc_html($netchng) . '</td>';
            echo '<td>' . esc_html($bid) . '</td>';
            echo '<td>' . esc_html($ask) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';

        wp_reset_postdata();
    } else {
        echo '<p>No se encontraron posts.</p>';
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
            text-align: center;
        }
        .stock-table th, .stock-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .stock-table th {
            background-color: #f4f4f4;
        }
        .stock-logo {
            max-width: 50px!important;
            height: 50px!important;
             object-fit: contain;
        }
        .clickable-row {
            cursor: pointer;
        }
        .clickable-row:hover {
            background-color: #f9f9f9;
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
