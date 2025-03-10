<div class="flormar-test-slider-block">
    <div class="container">

        <h2><?php echo __('Best selling products', 'flormar-test-slider'); ?></h2>


        <?php
        $max_price = (int) $atts['max-price'];
        $min_price = (int) $atts['min-price'];

        // if ($min_price == $defaults['min-price'] && $max_price == $defaults['max-price']) { }
        if ($max_price > 0 && $max_price >= $min_price) {

            $args = [
                'post_type'     => 'product',
                'post_status'   => 'publish',
                'order' => 'DESC',
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => '_price',
                        'value' => array($min_price,  $max_price),
                        'type' => 'numeric',
                        'compare' => 'BETWEEN'
                    )
                )

            ];
        } else {
            $args = [
                'post_type'     => 'product',
                'post_status'   => 'publish',
                'order' => 'DESC',
                'posts_per_page' => -1,
            ];
        }


        $query = new WP_Query($args);
        if ($query->have_posts()) {
        ?>
            <div class="woocommerce">
                <ul class="products flormar-test-slider">
                    <?php

                    while ($query->have_posts()) : $query->the_post();

                        wc_get_template_part('content', 'product');

                    endwhile;
                    ?>
                </ul>
            </div>

        <?php
        } else {
            echo  '<p class="no-products">' . __("No Products found in such price range.", 'flormar-test-slider') . '</p>';
        }
        wp_reset_postdata();
        ?>

    </div>
</div>