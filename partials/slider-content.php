<div class="flormar-test-slider-block">
    <div class="container">

        <h2>המוצרים הנמכרים ביותר </h2>


        <?php
        $args = [
            'post_type'     => 'product',
            'post_status'   => 'publish',
            'order' => 'DESC',
            'posts_per_page' => -1,
        ];
        $query = new WP_Query($args);
        if ($query->have_posts()) :
        ?>
            <div class="flormar-test-slider">
                <?php

                while ($query->have_posts()) : $query->the_post();

                    wc_get_template_part('content', 'product');

                endwhile;
                ?>
            </div>

        <?php
        endif;
        wp_reset_postdata();
        ?>

    </div>
</div>