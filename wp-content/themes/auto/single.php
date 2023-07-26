<?php get_header(); ?>
<?php the_post(); ?>

<section>
    <div class="container">
        <div class="flex sm:flex-col">
            <div class="flex-initial justify-left w-[860px] sm:w-[auto]">
                <div class="flex justify-left sm:justify-center">
                    <div
                        class="mt-[80px] sm:mt-[40px] mb-[59px] sm:flex sm:flex-col sm:items-center sm:text-center sm:px-[10px]">
                        <?php
                        $categories = get_the_category();
                        if ($categories) {
                            foreach ($categories as $category) {

                                echo '<a class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';

                            }
                        }
                        ?>
                        <h1 class="text-[27px] font-semibold leading-[140%] mb-[16px] mt-[16px]">
                            <?php the_title(); ?>
                        </h1>
                        <div class="flex gap-[8px] items-center w-[350px] mb-[32px] sm:w-[auto]">
                            <div class="rounded-[18px] w-[18px] h-[18px]">
                                <?php echo do_shortcode('[avatar]'); ?>
                            </div>
                            <p
                                class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                                <?php the_author(); ?>
                            </p>
                            <p class="text-xs text-textUnderPosts">
                                <svg class="inline-block h-[12px] w-[11px] pb-[2.5px] mr-[5px]" viewBox="0 0 32 32"
                                    id="iconCalendar">
                                    <symbol id="icon-calendar" viewBox="0 0 32 32">
                                        <path
                                            d="M10 12h4v4h-4zM16 12h4v4h-4zM22 12h4v4h-4zM4 24h4v4h-4zM10 24h4v4h-4zM16 24h4v4h-4zM10 18h4v4h-4zM16 18h4v4h-4zM22 18h4v4h-4zM4 18h4v4h-4zM26 0v2h-4v-2h-14v2h-4v-2h-4v32h30v-32h-4zM28 30h-26v-22h26v22z">
                                        </path>
                                    </symbol>
                                    <use xlink:href="#icon-calendar"></use>
                                </svg>
                                <span class="text-xs"></span>
                                <?php echo get_the_date('d F Y'); ?>
                            </p>
                        </div>
                        <div class="prose">
                            <img src="<?php the_field('image'); ?>" alt="<?php the_title(); ?> - img"
                                class="mb-[40px] object-cover h-[432px] w-[856px] rounded-[5px] sm:w-[300px] sm:h-[200px]" />
                            <?php the_content(); ?>
                        </div>

                        <!-- <div
                                class="italic flex justify-between relative items-center w-[853px] sm:w-[auto] rounded-[8px] bg-tertiary mb-[32px] mt-[32px]">
                                <svg class="w-[72px] h-[50px] fill-[#DFF1F0] absolute z-1 left-[15px] top-[12px]">
                                    <use href="./img/icons.svg#icon-Quotes"></use>
                                </svg>

                            </div> -->

                        <!-- Social Media Share -->

                        <div class="container ">
                            <ul
                                class="flex md:mb-[50px] items-center justify-between flex-wrap justify-center list-none gap-[18px] sm:gap-[50px]   after:content-[''] after:block after:w-[303px]  md:after:w-[100%] md:before:w-[100%] after:h-[1px] after:bg-[#D1E7E5] after:rounded-[3px] before:content-[''] before:block before:w-[303px] before:h-[1px] before:bg-[#D1E7E5] before:rounded-[3px]">
                                <li>
                                    <a href="#"
                                        class="flex group cursor-pointer bg-[#DFF1F0] hover:bg-primary w-[30px] h-[30px] items-center justify-center rounded-[50%] transition-all duration-250">
                                        <svg
                                            class="w-[16px] h-[16px] fill-[#777777] group-hover:fill-[white] transition-all duration-250">
                                            <use
                                                href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-facebook-1-1">
                                            </use>
                                        </svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex group cursor-pointer bg-[#DFF1F0] hover:bg-primary w-[30px] h-[30px] items-center justify-center rounded-[50%] transition-all duration-250">
                                        <svg class="w-[16px] h-[16px] fill-[#777777] group-hover:fill-[white]">
                                            <use
                                                href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-twitter-1-1">
                                            </use>
                                        </svg>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#"
                                        class="flex group cursor-pointer bg-[#DFF1F0] hover:bg-primary w-[30px] h-[30px] items-center justify-center rounded-[50%] transition-all duration-250">
                                        <svg class="w-[16px] h-[16px] fill-[#777777] group-hover:fill-[white]">
                                            <use
                                                href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-instagram-2-1">
                                            </use>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mb-[56px] sm:items-center  sm:flex sm:flex-col">
                    <h2 class="text-xl font-semibold">
                        <span class="bg-primary text-[white] px-[3px] mr-[2px]">Recently</span>Posted
                    </h2>
                </div>
                <div
                    class="grid grid-cols-2 gap-[30px] sm:grid-cols-1 sm:items-center sm:justify-center sm:text-center">
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
                            <div class="flex flex-col rounded-[12px] bg-[white] mb-[56px] sm:mb-[0px]">
                                <div class="sm:py-[24px] sm:px-[24px]">
                                    <img src="<?php the_field('image'); ?>" alt="<?php the_title(); ?> - img"
                                        class="object-cover h-[262px] w-[413px] rounded-[12px] md:h-[auto] md:w-[auto]"
                                        alt="">
                                </div>
                                <div
                                    class="mt-[24px] sm:flex sm:flex-col sm:items-center sm:mt-[4px] sm:pb-[24px] w-[350px] sm:w-[auto]">
                                    <?php
                                        $categories = get_the_category();
                                        if ($categories) {
                                            foreach ($categories as $category) {

                                                echo '<a class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] mb-[8px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';

                                            }
                                        }
                                        ?>
                                    <h3
                                        class="text-[27px] mt-[8px] text-textTitles font-semibold leading-[140%] mb-[23px] sm:text-center sm:w-[auto] hover:text-primary transition-all duration-250">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="flex gap-[8px] items-center sm:w-[auto] sm:flex-wrap sm:justify-center md:mb-[8px]">
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
                                            <?php echo get_the_date(); ?>
                                        </p>
                                        <p class="text-xs text-textUnderPosts">
                                            <svg class="inline-block h-[12px] w-[12px] pb-[3px] mr-[5px]" viewBox="0 0 32 32"
                                                id="iconClockEight">
                                                <symbol id="icon-clock-eight" viewBox="0 0 32 32">
                                                    <path
                                                        d="M20.586 23.414l-6.586-6.586v-8.828h4v7.172l5.414 5.414zM16 0c-8.837 0-16 7.163-16 16s7.163 16 16 16 16-7.163 16-16-7.163-16-16-16zM16 28c-6.627 0-12-5.373-12-12s5.373-12 12-12c6.627 0 12 5.373 12 12s-5.373 12-12 12z">
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
                    }

                    wp_reset_postdata();
                    ?>

                    

                </div>
                <!-- DISQUS -->
                <div class="mb-[100px] sm:text-center sm:px-[10px]">
                    <h2>
                        !!!!DISQUS!!!!
                    </h2>
                </div>
            </div>
            <!-- Top Authors -->
            <?php get_sidebar(); ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>