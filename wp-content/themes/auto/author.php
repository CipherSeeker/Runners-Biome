<?php get_header(); ?>
<main>
    <section class="bg-tertiary">
        <div class="container">
            <div class="flex  mb-[60px] justify-center">
                <?php
                $current_author = get_queried_object();
                if ($current_author instanceof WP_User) {
                    $author_id = $current_author->ID;
                    $author_name = $current_author->display_name;
                    $author_description = get_user_meta($author_id, 'description', true);
                    $author_avatar = get_avatar_url($author_id, 150);
                ?>  
                <div class="mt-[100px] mb-[100px] flex md:flex-col">
                    <div class="mr-4 md:mr-[0px] md:mb-[40px] ">
                        <img src="<?php echo $author_avatar; ?>" alt="<?php echo $author_name; ?>" class="object-cover w-[auto] h-[auto]">
                    </div>
                    <div class="flex flex-col ml-[20px] justify-center md:text-center">
                        <h1 class="text-[27px] text-textTitles font-semibold mb-[20px]"><?php echo $author_name; ?></h1>
                        <p class="w-[1000px] md:w-[auto] text-textPosts"><?php echo $author_description; ?></p>
                    </div>
                </div>
                <?php
                } else {
                ?>
                    <p>Author not found.</p>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="mb-[60px]">
                <h2 class="text-2xl font-semibold text-textTitles"><spab class="bg-primary text-[white] px-[3px] mr-[2px]">Articles</spab>by <?php echo $author_name; ?></h2>
            </div>
            <div class="grid grid-cols-3 gap-[30px] sm:grid-cols-1 md:grid-cols-1">
                        <?php
                        // Display all posts by the current author
                        $args = array(
                            'author' => $author_id,
                            'post_type' => 'post',
                            'posts_per_page' => 9,
                            'paged' => get_query_var('paged') ? get_query_var('paged') : 1, // Use the 'paged' query parameter for pagination
                            'orderby' => 'date',
                            'order' => 'DESC',
                            // 'no_found_rows' => true, 
                        );
                        $author_posts = new WP_Query($args);
                        if ($author_posts->have_posts()) {
                            while ($author_posts->have_posts()) {
                                $author_posts->the_post();
                        ?>
                        <div class="flex flex-col rounded-[12px] bg-[white] mb-[56px] sm:mb-[0px] mx-auto md:items-center md:text-center">
                            <div class="sm:mb-[24px]">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('large', array('class' => 'object-cover h-[262px] w-[413px] rounded-[12px] sm:h-[auto] sm:w-[auto] md:h-[auto] md:w-[auto]'));
                                }
                                ?>
                            </div>
                            <div class="mt-[24px] sm:flex sm:flex-col sm:items-center sm:mt-[4px] sm:pb-[24px] w-[350px] sm:w-[auto] md:w-[auto] md:flex md:flex-col md:items-center">
                                <?php
                                $categories = get_the_category();
                                if ($categories) {
                                    foreach ($categories as $category) {
                                        echo '<a class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                                    }
                                }
                                ?>
                                <h3 class="line-clamp-2 md:line-clamp-3 text-[27px] text-textTitles font-semibold leading-[140%] mb-[23px] mt-[8px] sm:text-center sm:w-[auto] hover:text-primary transition-all duration-250">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <div class="flex gap-[8px] items-center sm:w-[auto] sm:flex-wrap sm:justify-center sm:mb-[24px] md:text-center">
                                    <div class="rounded-[18px] w-[18px] h-[18px]">
                                        <?php echo do_shortcode('[avatar]'); ?>
                                    </div>
                                    <p class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                        <?php the_author(); ?>
                                    </p>
                                    <p class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                        <svg class="inline-block h-[12px] w-[11px] pb-[2.5px] mr-[5px]" viewBox="0 0 32 32">
                                            <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-calendar"></use>
                                        </svg>
                                        <span class="text-xs"></span>
                                        <?php echo get_the_date('d F Y'); ?>
                                    </p>
                                    <p class="text-xs text-textUnderPosts">
                                        <svg class="inline-block h-[12px] w-[12px] pb-[3px] mr-[5px]" viewBox="0 0 32 32">
                                            <usehref="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-clock"></use>
                                        </svg>
                                        <span>
                                            <?php the_field('time_to_read') ?> min. to read
                                        </span>
                                    </p>
                                </div>
                                <div class="mt-[19px] text-textPosts sm:text-center sm:mt-[0px]">
                                    <p class="line-clamp-3 md:line-clamp-4">
                                        <?php echo get_the_excerpt(); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                            wp_reset_postdata();
                        } else {
                        ?>
                        <p>No posts found.</p>
                        <?php
                        }
                        ?>
                    </div>
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
        </div>
    </section>
</main>
<?php get_footer(); ?>