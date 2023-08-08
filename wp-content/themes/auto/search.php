<?php get_header(); ?>
    <!-- Search -->
    <section>
        <div class="container mb-[100px]">
            <div
                class="mt-[80px] pb-[10px] mb-[56px] flex after:content-[''] after:mb-[1px] items-end after:block after:w-[1102px] after:h-[1px] after:bg-[#C4C4C4] after:rounded-[3px]">
                <p
                    class="capitalize after:content-[''] after:mt-[9px] items-end after:block after:w-[184px] after:h-[3px] after:bg-primary after:rounded-[3px] text-base text-textUnderPosts leading-[150%] font-medium">
                    <?php printf(__('Search results for: %s', 'your-theme-domain'), '<span class="capitalize text-textTitles">' . get_search_query() . '</span>'); ?>
                </p>
            </div>
            <!-- Search Results -->
            <?php if (have_posts()): ?>
                <?php while (have_posts()):
                    the_post(); ?>
                    <!-- Post -->
                    <div
                        class="flex md:flex-wrap md:justify-center md:text-center rounded-[12px] bg-[white] w-[auto]  mb-[48px]">
                        <div class="mr-[34px] md:mr-[0px] w-[100%] max-w-[266px] md:w-[auto] md:max-w-[100%]">
                            <!--<img src="<?php the_field('image'); ?>" alt="<?php the_title(); ?> - img"-->
                            <!--    class="object-cover h-[180px] w-[266px] rounded-[5px] md:w-[auto] md:h-[auto]" />-->
                            <?php
                                if (has_post_thumbnail()) {
                                the_post_thumbnail('large', array('class' => 'object-cover h-[180px] w-[266px] rounded-[5px] md:w-[auto] md:h-[auto]'));
                                     }
                             ?>
                        </div>
                        <div class="mt-[4px] md:mt-[16px]">
                            <?php
                            $categories = get_the_category();
                            if ($categories) {
                                foreach ($categories as $category) {
                                    echo '<a class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                                }
                            }
                            ?>
                            <h3
                                class="md:flex line-clamp-1 capitalize text-[27px] text-textTitles font-semibold leading-[140%] mb-[16px] mt-[8px] hover:text-primary transition-all duration-250">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="flex gap-[8px] items-center mb-[16px] md:justify-center">
                                <div class="rounded-[18px] w-[18px] h-[18px]">
                                    <?php echo do_shortcode('[avatar]'); ?>
                                </div>
                                <p
                                    class="text-xs text-textUnderPosts md:after:hidden after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                    <?php the_author(); ?>
                                </p>
                                <p
                                    class="text-xs text-textUnderPosts md:after:hidden after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
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
                            <div class="text-textPosts line-clamp-2 w-[761px] md:w-[auto]">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>
                    </div>
                    <!-- Post End -->
                <?php endwhile; ?>
                <!-- Pagination -->
                <div class="flex gap-[8px] md:justify-center">
                    <?php
                    $paginate_links = paginate_links(
                        array(
                            'prev_text' => '<svg class="w-[20px] h-[10px] fill-textTags group-hover:fill-[white] "><use href="' . get_template_directory_uri() . '/assets/img/icons.svg#icon-Arrow-l"></use></svg> Prev.',
                            'next_text' => 'Next <svg class="w-[20px] h-[10px] fill-textTags group-hover:fill-[white] "><use href="' . get_template_directory_uri() . '/assets/img/icons.svg#icon-Arrow-r"></use></svg>',
                        )
                    );
                    $paginate_links = str_replace("<ul>", "<ul class='flex justify-center mb-[56px] gap-[16px] text-[15px] text-textTags transition-all duration-250'>", $paginate_links);
                    $paginate_links = str_replace("<li>", "<li class='transition-all duration-250'>", $paginate_links);
                    echo $paginate_links;
                    ?>
                </div>
            <?php else: ?>
                <p>
                    <?php _e('No results found.', 'your-theme-domain'); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>
    <div>
<?php get_footer(); ?>