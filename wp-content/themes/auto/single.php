<?php get_header(); ?>
<?php the_post(); ?>
<section>
    <div class="container relative">
        <div class="back-to-top group hover:bg-primary transition-all duration-250 bottom-[56px] right-[1rem] sm:top-[100%] md:top-[100%]" id="backToTopBtn">
            <a href="#top-title">
                <svg class="inline-block w-[35px] h-[35px]  fill-textAuthor pb-[5px] group-hover:fill-[white]">
                    <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-arrow-up"></use>
                </svg>
            </a>
        </div>
        <div class="flex sm:flex-col">
            <div class="flex-initial justify-left w-[860px] sm:w-[auto]">
                <div class="flex justify-left sm:justify-center">
                    <div class="mt-[73px] sm:mt-[40px] mb-[59px] sm:flex sm:flex-col sm:items-center sm:text-center sm:px-[10px] ">
                        <div class="">
                            <div class="bread flex rounded-[20px] line-clamp-1 bg-secondary justify-center py-[8px] mb-[50px] md:mb-[10px]">
                                <?php get_breadcrumb(); ?>
                            </div>
                        </div>
                        <h1  id="top-title" class="flex justify-center text-[27px] text-textTitles text-center font-semibold leading-[140%] mb-[16px] mt-[16px]" >
                            <?php the_title(); ?>
                        </h1>
                        <div class="flex gap-[8px] items-center justify-center w-[auto] mb-[32px] sm:w-[auto]">
                            <div class="rounded-[18px] w-[40px] h-[40px] flex items-center">
                                <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                            </div> 
                            <div class="flex text-sm ml-[5px] text-textTitles relative">
                                <a class="text-primary px-[6px] py-[3px] rounded-lg hover:bg-primary hover:text-[white] transition-all duration 250" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                     <?php the_author(); ?>
                                </a>
                           </div>
                           <p class="relative text-sm text-textTitles px-[10px] md:after:hidden md:before:hidden after:absolute after:top-[18.1%] after:left-[98.3%] after:content-[''] after:inline-block after:w-[0.5px] after:h-[14px] after:bg-[#999999] after:ml-[6px] before:absolute before:top-[18.1%] before:left-[0%] before:content-[''] before:inline-block before:w-[0.5px] before:h-[14px] before:bg-[#999999] before:mr-[6px]">
                                    <?php
                                        $author_id = get_the_author_meta('ID');
                                        $bio = get_field('bio', 'user_' . $author_id);
                                        echo $bio;
                                    ?> 
                           </p>
                            <p class="text-xs text-textUnderPosts flex items-center ml-[5px]">
                                <svg class="inline-block h-[16px] w-[16px] mr-[5px] md:hidden" viewBox="0 0 32 32">
                                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-calendar"></use>
                                </svg>
                                <span class="text-sm">
                                    <?php echo get_the_date('d F Y'); ?>
                                </span>
                            </p>
                        </div>
                        <div class="prose">
                            <?php the_content(); ?>
                        </div>
                        <!-- Social Media Share -->
                        <div class="container ">
                            <div
                                class="flex md:mb-[50px] items-center justify-between flex-wrap md:justify-center list-none  sm:gap-[50px] after:content-[''] after:block after:w-[303px]  md:after:w-[100%] md:before:w-[100%] after:h-[1px] after:bg-[#D1E7E5] after:rounded-[3px] before:content-[''] before:block before:w-[303px] before:h-[1px] before:bg-[#D1E7E5] before:rounded-[3px]">
                                <?php echo do_shortcode('[Sassy_Social_Share]'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-[56px] sm:items-center  sm:flex sm:flex-col">
                    <h2 class="text-xl font-semibold">
                        <span class="bg-primary text-[white] px-[3px] mr-[2px]">Recently</span>Posted
                    </h2>
                </div>
                <div
                    class="grid grid-cols-2 gap-[30px] md:grid-cols-1 md:items-center md:justify-center md:text-center">
                    <!-- Post -->
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 2,
                        'offset' => 3, // Skip the last three posts
                    );
                    $query = new WP_Query($args);
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            ?>
                            <div class="flex flex-col rounded-[12px] bg-[white] mb-[56px] md:mb-[0px]">
                                <div class="md:py-[24px] md:px-[24px]">
                                    
                                    <?php
                                        if (has_post_thumbnail()) {
                                        the_post_thumbnail('large', array('class' => ' rounded-[12px] object-cover h-[262px] w-[413px] md:h-[auto] md:w-[auto]'));
                                          }
                                    ?>
                                </div>
                                <div
                                    class="mt-[24px] md:flex md:flex-col md:items-center md:mt-[4px] md:pb-[24px] w-[350px] md:w-[auto]">
                                    <?php
                                        $categories = get_the_category();
                                        if ($categories) {
                                            foreach ($categories as $category) {
                                                echo '<a class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                                            }
                                        }
                                        ?>
                                    <h3
                                        class="line-clamp-2 text-[27px] mt-[8px] text-textTitles font-semibold leading-[140%] mb-[23px] md:text-center md:w-[auto] hover:text-primary transition-all duration-250">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="flex gap-[8px] items-center md:w-[auto] md:flex-wrap md:justify-center md:mb-[8px]">
                                        <div class="rounded-[18px] w-[18px] h-[18px]">
                                            <?php echo do_shortcode('[avatar]'); ?>
                                        </div>
                                        <a class="hover:text-primary transition-all duration-250" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                            <p class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                                <?php the_author(); ?>
                                            </p>
                                        </a>
                                        <p
                                            class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                            <svg class="inline-block h-[12px] w-[11px] pb-[2.5px] mr-[5px]" viewBox="0 0 32 32">
                                                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-calendar"></use>
                                            </svg>
                                            <span class="text-xs"></span>
                                            <?php echo get_the_date(); ?>
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
                                    <div class="mt-[19px] text-textPosts sm:text-center sm:mt-[0px] line-clamp-2">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    wp_reset_postdata();
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