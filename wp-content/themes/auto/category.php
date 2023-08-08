<?php get_header(); ?>
<section>
    <div class="container sm:px-4 mx-auto">
        <div class="flex md:flex-col">
            <div class="flex-initial flex-col justify-left w-[860px] md:w-[auto]">
                <div class="flex justify-left md:justify-center">
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
                        'posts_per_page' => 8, // Display 8 posts per page
                        'paged' => $paged // Set the current page
                    );
                    $tag_query = new WP_Query($query_args);
                    if ($tag_query->have_posts()) {
                        while ($tag_query->have_posts()) {
                            $tag_query->the_post();
                            ?>
                            <div class="flex flex-col rounded-[12px] bg-[white] mb-[56px] sm:mb-[0px] mx-auto md:items-center md:text-center">
                                <div class="sm:mb-[24px]">
                                    <?php
                                        if (has_post_thumbnail()) {
                                        the_post_thumbnail('large', array('class' => 'object-cover h-[271px] w-[373px] rounded-[12px] sm:w-[auto] sm:h-[auto] md:w-[auto] md:h-[auto]'));
                                             }
                                    ?>
                                </div>
                                <div
                                    class="mt-[24px] sm:flex sm:flex-col sm:items-center sm:mt-[4px] sm:pb-[24px] w-[350px] md:w-[auto]">
                                    <?php
                                    $categories = get_the_category();
                                    if ($categories) {
                                        foreach ($categories as $category) {
                                            echo '<a class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                                        }
                                    }
                                    ?>
                                    <h3
                                        class="line-clamp-2 text-[27px] mt-[8px] text-textTitles font-semibold leading-[140%] mb-[23px] sm:text-center sm:w-[auto] hover:text-primary transition-all duration-250">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div
                                        class="flex gap-[8px] items-center md:w-[auto] md:flex-wrap md:justify-center md:mb-[24px]">
                                        <div class="rounded-[18px] w-[18px] h-[18px]">
                                            <?php echo do_shortcode('[avatar]'); ?>
                                        </div>
                                        <p
                                            class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                            <?php the_author(); ?>
                                        </p>
                                        <p
                                            class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                            <svg class="inline-block h-[12px] w-[11px] pb-[2.5px] mr-[5px]" viewBox="0 0 32 32">
                                                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-calendar"></use>
                                            </svg>
                                            <span class="text-xs"></span>
                                            <?php echo get_the_date('d F Y'); ?>
                                        </p>
                                        <p class="text-xs text-textUnderPosts">
                                            <svg class="inline-block h-[12px] w-[12px] pb-[3px] mr-[5px]" viewBox="0 0 32 32">
                                                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-clock"></use>
                                            </svg>
                                            <span>
                                                <?php the_field('time_to_read') ?> min. to read
                                            </span>
                                        </p>
                                    </div>
                                    <div class="mt-[19px] text-textPosts sm:text-center sm:mt-[0px] line-clamp-3">
                                        <?php the_excerpt(); ?>
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
            <?php if (!wp_is_mobile()) : ?>
        <!-- Top Authors -->
        <?php get_sidebar(); ?>
        <?php endif; ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>