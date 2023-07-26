<?php get_header(); ?>

<section>
    <div class="container sm:px-4 mx-auto">
        <div class="flex md:flex-col">
            <div class="flex-initial flex-col justify-left w-[860px] md:w-[auto]">
                <div class="flex justify-left sm:justify-center">
                    <div class="mt-[80px] mb-[59px]">
                        <h2 class="text-xl font-semibold bg-primary text-[white] px-[3px] mr-[2px]">
                            <?php single_tag_title(); ?>
                        </h2>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-[30px] md:grid-cols-1">
                    <!-- Post -->
                    <?php
                    

                    $query_args = array(
                        'post_type' => 'post',
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'category_name' => single_tag_title('', false),
                        
                    );

                    $tag_query = new WP_Query($query_args);

                    if ($tag_query->have_posts()) {
                        while ($tag_query->have_posts()) {
                            $tag_query->the_post();
                            ?>
                            <div class="flex flex-col rounded-[12px] bg-[white] mb-[56px] sm:mb-[0px] mx-auto">
                                <div class="sm:mb-[24px]">
                                    <img src="<?php the_field('image'); ?>" alt="<?php the_title(); ?> - img"
                                        class="object-cover h-[262px] w-[413px] rounded-[12px] sm:h-[auto] sm:w-[auto]" />
                                </div>
                                <div
                                    class="mt-[24px] sm:flex sm:flex-col sm:items-center sm:mt-[4px] sm:pb-[24px] w-[350px] sm:w-[auto]">
                                    <?php
                                    $categories = get_the_category();
                                    if ($categories) {
                                        foreach ($categories as $category) {
                                            echo '<button type="button" class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px]">';
                                            echo '<a href="' . get_category_link($category->term_id) . '" class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px]">' . $category->name . '</a>';
                                            echo '</button>';
                                        }
                                    }
                                    ?>
                                    <h3
                                        class="text-[27px] text-textTitles font-semibold leading-[140%] mb-[23px] sm:text-center sm:w-[auto]">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div
                                        class="flex gap-[8px] items-center sm:w-[auto] sm:flex-wrap sm:justify-center sm:mb-[24px]">
                                        <div class="rounded-[18px] w-[18px] h-[18px]">
                                            <?php echo do_shortcode('[avatar]'); ?>
                                        </div>
                                        <p
                                            class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                            <?php the_author(); ?>
                                        </p>
                                        <p
                                            class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                            <svg class="inline-block h-[12px] w-[11px] pb-[2.5px] mr-[5px]" viewBox="0 0 32 32"
                                                id="iconCalendarEight">
                                                <symbol id="icon-calendar-eight" viewBox="0 0 32 32">
                                                    <path
                                                        d="M10 12h4v4h-4zM16 12h4v4h-4zM22 12h4v4h-4zM4 24h4v4h-4zM10 24h4v4h-4zM16 24h4v4h-4zM10 18h4v4h-4zM16 18h4v4h-4zM22 18h4v4h-4zM4 18h4v4h-4zM26 0v2h-4v-2h-14v2h-4v-2h-4v32h30v-32h-4zM28 30h-26v-22h26v22z">
                                                    </path>
                                                </symbol>
                                                <use xlink:href="#icon-calendar-eight"></use>
                                            </svg>
                                            <span class="text-xs"></span>
                                            <?php echo get_the_date('d F Y'); ?>
                                        </p>
                                        <p class="text-xs text-textUnderPosts">
                                            <svg class="inline-block h-[12px] w-[12px] pb-[3px] mr-[5px]" viewBox="0 0 32 32"
                                                id="iconClock-eight">
                                                <symbol id="icon-clock-eight" viewBox="0 0 32 32">
                                                    <path
                                                        d="M20.586 23.414l-6.586-6.586v-8.828h4v7.172l5.414 5.414zM16 0c-8.837 0-16 7.163-16 16s7.163 16 16 16 16 16 16-7.163 16-16-7.163-16-16-16zM16 28c-6.627 0-12-5.373-12-12s5.373-12 12-12c6.627 0 12 5.373 12 12s-5.373 12-12 12z">
                                                    </path>
                                                </symbol>
                                                <use xlink:href="#icon-clock-eight"></use>
                                            </svg>
                                            <span>
                                                <?php the_field('time_to_read') ?> min. to read
                                            </span>
                                        </p>
                                    </div>
                                    <div class="mt-[19px] text-textPosts sm:text-center sm:mt-[0px]">
                                        <p>
                                            <?php the_excerpt(); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    } else {
                        echo '<p>No posts found.</p>';
                    }
                    ?>
                    <!-- End post -->
                </div>
                <!-- Pagination -->
                <div class="flex justify-center mb-[56px] gap-[16px] text-[15px] text-textTags">
                    <?php
                    $paginate_links = paginate_links(
                        array(
                            'prev_text' => '<svg class="w-[20px] h-[10px] fill-textTags group-hover:fill-[white] "><use href="' . get_template_directory_uri() . '/assets/img/icons.svg#icon-Arrow-l"></use></svg> Prev.',
                            'next_text' => 'Next <svg class="w-[20px] h-[10px] fill-textTags group-hover:fill-[white] "><use href="' . get_template_directory_uri() . '/assets/img/icons.svg#icon-Arrow-r"></use></svg>',
                        )
                    );
                    $paginate_links = str_replace("<ul>", "<ul class='flex justify-center mb-[56px] gap-[16px] text-[15px] text-textTags'>", $paginate_links);
                    $paginate_links = str_replace("<li>", "<li class='pagination-button'>", $paginate_links);
                    echo $paginate_links;
                    ?>
                </div>
            </div>
            <!-- Top Authors -->
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>

<?php get_footer(); ?>