<!-- Top Authors -->
<section class="ml-[80px] flex flex-col justify-left md:ml-[0px] md:justify-center md:hidden">
  <div class="sm:flex sm:flex-col sm:items-center md:items-center md:flex md:flex-col">
    <div class="mt-[80px] mb-[59px] md:w-[auto] sm:w-[auto]">
      <h2 class="text-xl font-semibold">
        <span class="bg-primary text-[white] px-[3px] mr-[2px]">Top</span>Authors
      </h2>
    </div>
    <div class="mb-[59px] md:hidden">
    <!-- Author -->
    <?php
        $authors = get_users(array('role' => 'author', 'orderby' => 'name', 'order' => 'ASC'));
        foreach ($authors as $author) {
            $author_id = $author->ID;
            $bio = get_field('bio', 'user_' . $author_id);
            if ($bio) {
                $author_page_url = get_author_posts_url($author_id);
    ?>
            <div class="mb-[22px] flex flex-wrap sm:items-left items-end">
                <div class="w-[80px] h-[80px]">
                    <?php echo get_avatar($author_id, 80); ?>
                </div>
                <div class="ml-[24px] sm:ml-[8px]">
                    <h3 class="text-base text-textTitles font-semibold leading-[100%] mb-[8px] sm:w-[auto]">
                        <a class="hover:text-primary transition-all duration-250" href="<?php echo $author_page_url; ?>"><?php echo $author->display_name; ?></a> <!-- Посилання на сторінку автора -->
                    </h3>
                    <p class="text-xs text-textTags font-light leading-[150%] mb-[16px] w-[250px] line-clamp-2">
                        <?php echo $bio; ?>
                    </p>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <!-- End Post -->
</div>
</div>
  <!-- Categories -->
  <div class="flex flex-col">
    <div class="flex mb-[40px] sm:justify-center md:justify-center">
        <h2 class="text-xl font-semibold bg-primary text-[white] px-[3px]">
          Categories
        </h2>
    </div>
    <ul class="mb-[59px]">
      <?php
      $categories = get_categories();
      foreach ($categories as $category) {
        $category_link = get_category_link($category->cat_ID);
        $post_count = $category->category_count;
        ?>
        <li
          class="group flex justify-between border-dashed border-b-[1px] border-[#D1E7E5] mb-[12px] hover:text-primary transition-all duration-250">
          <a href="<?php echo esc_url($category_link); ?>">
            <h3
              class="group-hover:text-primary text-sm font-medium mb-[12px] text-categoriesText transition-all duration-250">
              <?php echo esc_html($category->name); ?>
            </h3>
          </a>
          <p>
            <?php echo $post_count; ?>
          </p>
        </li>
        <?php
      }
      ?>
    </ul>
  </div>
<!-- Instagram Posts -->
  <div class="flex flex-col mb-[59px]">
    <div class="flex mb-[38px] sm:justify-center md:justify-center">
      <h2 class="text-xl font-semibold">
        <span class="bg-primary text-[white] px-[3px] mr-[2px]">Instagram</span>Posts
      </h2>
    </div>
    <div>
      <div>
        <?php echo do_shortcode('[instagram feed="110"]'); ?>
      </div>
    </div>
  </div>
  <!-- Search With Tags -->
  <div class="flex flex-col">
    <div class="mb-[40px] sm:justify-center sm:flex md:justify-center md:flex">
      <h2 class="text-xl font-semibold">
        <span class="bg-primary text-[white] px-[3px] mr-[2px]">Search</span>With Tags
      </h2>
    </div>
    <ul class="flex flex-wrap w-[360px] gap-[12px] sm:w-[auto] sm:justify-center sm:mb-[40px] md:w-[auto] md:justify-center">
    <?php
    $tags = get_tags();
    if ($tags) {
      foreach ($tags as $tag) {
        $tag_link = get_tag_link($tag->term_id); 
        ?>
        <li class="">
          <a href="<?php echo $tag_link; ?>" class="group">
            <p class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
              <?php echo $tag->name; ?>
            </p>
          </a>
        </li>
        <?php
      }
    }
    ?>
  </ul>
  </div>
</section>