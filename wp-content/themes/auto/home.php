<?php
/*
Template Name: home
*/
?>
<?php get_header(); ?>
<main>
  <!-- Hero -->
  <section class="bg-tertiary">
    <div class="container mx-auto md:flex sm:flex sm:px-4">
      <!-- Flex initial -->
      <div class="flex md:flex-col ">
        <div class="flex-initial flex-col">
          <div class="flex mt-[90px] mb-[59px] sm:justify-center md:justify-center">
            <!-- Featured This Month -->
            <h2 class="text-xl font-semibold">
              <span class="bg-primary text-[white] px-[3px] mr-[2px]">Featured</span>This Month
            </h2>
          </div>
          <!-- Scroll -->
          <div class="h-[670px] w-[890px] overflow-auto scroll-container mb-[90px] sm:mb-[0px] sm:w-[auto] sm:h-[auto] md:mb-[0px] md:w-[auto] md:h-[auto]">
              <?php
              $args = array(
                'post_type' => 'post',
                'posts_per_page' => 3,
              );
              $query = new WP_Query($args);
              $post_counter = 0;
              while ($query->have_posts()):
                $query->the_post();
                $post_counter++;
                ?>
                <!-- Post -->
                <div class="flex rounded-[12px] bg-[white] w-[832px] h-[319px] mb-[32px] sm:flex-col sm:w-[auto] sm:h-[auto] md:flex-col md:items-center md:w-[auto] md:h-[auto]">
                  <div class="py-[24px] px-[24px]">
                    <?php
                    if (has_post_thumbnail()) {
                      the_post_thumbnail('auto', array('class' => 'object-cover h-[271px] w-[373px] rounded-[12px] sm:w-[auto] sm:h-[auto] md:w-[auto] md:h-[auto]'));
                    }
                    ?>
                  </div>
                  <div class="mt-[24px] w-[386px] md:px-[12px] sm:w-[auto] md:w-[auto] sm:flex sm:flex-col sm:items-center md:flex md:flex-col md:items-center md:text-center sm:mt-[4px] sm:pb-[24px]">
                    <?php
                    $categories = get_the_category();
                    if ($categories) {
                      foreach ($categories as $category) {
                        echo '<a class="bg-tertiary text-textTags text-xs font-normal px-[8px] py-[4px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                      }
                    }
                    ?>
                    <h3 class="line-clamp-3 hover:text-primary text-[27px] text-textTitles font-semibold leading-[140%] mb-[23px] mt-[8px] sm:text-center md:text-center transition-all duration-250">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="flex gap-[8px] items-center sm:flex-wrap sm:justify-center"> 
                      <div class="rounded-[18px] w-[18px] h-[18px]">
                        <?php echo do_shortcode('[avatar]'); ?>
                      </div>
                      <a class="hover:text-primary transition-all duration-250" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                        <p class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                          <?php the_author(); ?>
                        </p>
                      </a>
                      <p class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                        <svg class="inline-block h-[12px] w-[11px] pb-[2.5px] mr-[5px]" viewBox="0 0 32 32">
                          <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-calendar"></use>
                        </svg>
                        <span class="text-sm">
                          <?php echo get_the_date('d F Y'); ?>
                        </span>
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
                    <div class="mt-[19px] text-textPosts sm:text-center md:pb-[24px]">
                      <p class="line-clamp-3 md:line-clamp-4">
                        <?php echo get_the_excerpt(); ?>
                      </p>
                    </div>
                  </div>
                </div>
                <!-- Post -->
                <?php
                if ($post_counter >= 1 && wp_is_mobile()) {
                  break;
                }
              endwhile;
              wp_reset_postdata();
              ?>
            </div>
        </div>
        <div class="flex flex-col ml-[51px] sm:ml-[0px] md:ml-[0px] md:items-center md:hidden">
          <div class="justify-left mt-[90px] mb-[59px] sm:justify-center sm:flex sm:mt-[45px]">
            <div class="flex-initial">
              <h2 class="text-xl font-semibold">
                <span class="bg-primary text-[white] px-[3px] mr-[2px]">Popular</span>Posts
              </h2>
            </div>
          </div>
          <!-- Side Posts -->
          <div class="w-[auto] flex flex-col sm:w-[auto] md:w-[auto] md:hidden">
            <?php
            $popular_posts = pvc_get_most_viewed_posts(
              array(
                'posts_per_page' => 5,
                'post_type' => array('post'),
                'order' => 'desc',
              )
            );
            if ($popular_posts) {
              foreach ($popular_posts as $post) {
                setup_postdata($post);
                ?>
                <!-- Post -->
                <div class="mb-[22px] flex sm:justify-center md:flex-col md:mb-[66px]">
                    <?php
                    if (has_post_thumbnail()) {
                    the_post_thumbnail('thumbnail', array('class' => 'object-cover h-[115px] w-[129px] rounded-[7px]  md:w-[auto] md:h-[auto]'));
                         }
                     ?>
                  <div class="ml-[20px] w-[211px] sm:w-[auto]  sm:ml-[8px] sm:flex sm:flex-col sm:items-baseline mx-auto md:w-[auto] md:items-center md:flex md:flex-col md:ml-[auto] md:mt-[24px]">
                    <?php
                    $categories = get_the_category();
                    if ($categories) {
                      foreach ($categories as $category) {
                        echo '<a class="bg-secondary h-[24px] text-textTags text-xs font-normal mb-[8px] sm:mb-[4px] px-[8px] py-[4px] rounded-[3px] hover:bg-primary hover:text-[white] transition-all duration-250" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                      }
                    }
                    ?>
                    <h3
                      class="line-clamp-2 md:line-clamp-3 hover:text-primary text-base text-textTitles font-medium leading-[150%] mb-[16px] mt-[8px] sm:mb-[12px] w-[auto] sm:w-[auto] md:text-[27px] md:font-semibold md:leading-[140%] md:mb-[23px] sm:text-center md:text-center transition-all duration-250">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <div class="flex gap-[8px] items-center sm:gap-[4px]">
                      <div class="rounded-[18px] w-[18px] h-[18px] line-clamp-2">
                        <?php echo do_shortcode('[avatar]'); ?>
                      </div>
                      <a class="hover:text-primary transition-all duration-250" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                          <p
                            class="line-clamp-1 text-xs text-textUnderPosts sm:after:hidden xl:after:hidden after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                            <?php the_author(); ?>
                          </p>
                      </a>
                      <p class="text-xs text-textUnderPosts line-clamp-1">
                        <svg class="inline-block h-[12px] w-[12px] pb-[3px] mr-[5px] sm:mr-[0px] sm:ml-[4px]" viewBox="0 0 32 32">
                          <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-clock"></use>
                        </svg>
                        <span>
                          <?php the_field('time_to_read') ?> min. to read
                        </span>
                      </p>
                    </div>
                    <div class="mt-[19px] text-textPosts sm:text-center md:pb-[24px] xl:hidden md:text-center">
                    <p class="md:line-clamp-4">
                      <?php echo get_the_excerpt(); ?>
                    </p>
                  </div>
                  </div>
                </div>
                <?php
              }
              wp_reset_postdata();
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Recently Posted -->
  <section>
    <div class="container sm:px-4 mx-auto">
      <div class="flex md:flex-col">
        <div class="flex-initial flex-col justify-left w-[860px] md:w-[auto]">
          <div class="flex justify-left sm:justify-center md:justify-center">
            <div class="mt-[80px] mb-[59px]">
              <h2 class="text-xl font-semibold">
                <span class="bg-primary text-[white] px-[3px] mr-[2px]">Recently</span>Posted
              </h2>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-[30px] sm:grid-cols-1 md:grid-cols-1">
  <!-- Post -->
  <?php
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => 8,
    'offset' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
  );
  $recent_posts = new WP_Query($args);
  $post_counter = 0;
  if ($recent_posts->have_posts()) {
    while ($recent_posts->have_posts()) {
      $recent_posts->the_post();
      $post_counter++;
      ?>
      <div class="flex flex-col rounded-[12px] bg-[white] mb-[56px] sm:mb-[0px] mx-auto md:items-center md:text-center">
        <div class="sm:mb-[24px]">
          <?php
          if (has_post_thumbnail()) {
            the_post_thumbnail('large', array('class' => 'object-cover h-[262px] w-[413px] rounded-[12px] sm:h-[auto] sm:w-[auto] md:h-[auto] md:w-[auto]'));
          }
          ?>
        </div>
        <div class="mt-[24px] sm:flex sm:flex-col sm:items-center sm:mt-[4px] sm:pb-[24px] w-[350px] sm:w-[auto] md:w-[auto] md:flex md:flex-col md:items-center ">
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
            <a class="hover:text-primary transition-all duration-250" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
              <p class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
                <?php the_author(); ?>
              </p>
            </a>
            <p class="text-xs text-textUnderPosts after:content-[''] after:inline-block after:w-[0.5px] after:h-[12px] after:bg-[#999999] after:ml-[6px]">
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
          <div class="mt-[19px] text-textPosts sm:text-center sm:mt-[0px]">
            <p class="line-clamp-3 md:line-clamp-4">
              <?php echo get_the_excerpt(); ?>
            </p>
          </div>
        </div>
      </div>
      <?php
      // Застосовуємо медіа-запит для виходу з циклу на мобільних пристроях
      if ($post_counter >= 3 && wp_is_mobile()) {
        break;
      }
    }
    wp_reset_postdata();
  }
  ?>
  <!-- End post -->
</div>

        </div>
        <?php if (!wp_is_mobile()) : ?>
        <!-- Top Authors -->
        <?php get_sidebar(); ?>
        <?php endif; ?>
      </div>
        </div>
  </section>
</main>
<?php get_footer(); ?>