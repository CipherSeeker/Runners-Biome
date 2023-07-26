<!-- Top Authors -->
<section class="ml-[80px] flex flex-col justify-left md:ml-[0px] md:justify-center">
  <div class="sm:flex sm:flex-col sm:items-center md:items-center md:flex md:flex-col">
    <div class="mt-[80px] mb-[59px] md:w-[auto] sm:w-[auto]">
      <h2 class="text-xl font-semibold">
        <span class="bg-primary text-[white] px-[3px] mr-[2px]">Top</span>Authors
      </h2>
    </div>
    <div class="mb-[59px]">
      <!-- Author -->
      <?php
      $authors = get_users(array('orderby' => 'name', 'order' => 'ASC'));
      foreach ($authors as $author) {
        ?>

        <div class="mb-[22px] flex flex-wrap sm:items-left items-end">
          <img class="rounded-[57.5px] w-[80px] h-[80px]" src="<?php echo get_avatar_url($author->ID); ?>" alt="">
          <div class="ml-[24px] sm:ml-[8px]">
            <h3 class="text-base text-textTitles font-semibold leading-[100%] mb-[8px] sm:w-[auto]">
              <?php echo $author->display_name; ?>
            </h3>
            <p class="text-xs text-textTags font-light leading-[150%] mb-[16px]">
              <?php echo get_user_meta($author->ID, 'description', true); ?>
            </p>

          </div>
        </div>

        <?php
      }
      ?>

      <!-- End Post -->
    </div>


  </div>

  <!-- Categories -->
  <div class="flex flex-col">
    <div class="flex mb-[40px] sm:justify-center md:justify-center">
      <a href="#" onclick="toggleModal()">
        <h2 class="text-xl font-semibold bg-primary text-[white] px-[3px]">
          Categories
        </h2>
      </a>
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
  <!-- Todays Update -->
  <div class="flex flex-col">
    <div class="flex mb-[40px] sm:justify-center md:justify-center">
      <h2 class="text-xl font-semibold">
        <span class="bg-primary text-[white] px-[3px] mr-[2px]">Today's</span>Update
      </h2>
    </div>
    <div class="flex md:justify-center">
      <ul class="columns-2 gap-[25px] mb-[80px] sm:gap-[5px] md:gap-[5px] sm:flex md:flex flex-wrap">
        <li
          class="flex-grow mb-[25px] sm:mb-[5px] md:mb-[5px] w-[166px] h-[111px] sm:w-[140px] md:w-[166px] md:h-[120px] flex flex-col items-center justify-center bg-tertiary rounded-[10px]">
          <p class="mb-[6px] text-primary text-2xl font-semibold">
            14
          </p>
          <p>New Posts</p>
        </li>
        <li
          class="flex-grow w-[166px] h-[111px] sm:w-[140px] md:w-[166px] md:h-[120px] flex flex-col items-center justify-center bg-tertiary rounded-[10px]">
          <p class="mb-[6px] text-primary text-2xl font-semibold">
            29
          </p>
          <p>New Subscribers</p>
        </li>
        <li
          class="flex-grow mb-[25px] sm:mb-[5px] md:mb-[5px] w-[166px] sm:w-[140px] md:w-[166px] md:h-[120px]  h-[111px] flex flex-col items-center justify-center bg-tertiary rounded-[10px]">
          <p class="mb-[6px] text-primary text-2xl font-semibold">
            480
          </p>
          <p>Total Visitors</p>
        </li>
        <li
          class="flex-grow w-[166px] h-[111px] sm:w-[140px] md:w-[166px] md:h-[120px] flex flex-col items-center justify-center bg-tertiary rounded-[10px]">
          <p class="mb-[6px] text-primary text-2xl font-semibold">
            138
          </p>
          <p>Blog Read</p>
        </li>
      </ul>
    </div>
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
      <li class="">
        <a href="<?php echo get_tag_link(4); ?>" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Health
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Runningrest
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Gear
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Marathon
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Running
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Training
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Health
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Food
          </p>
        </a>
      </li>
      <li>
        <a href="#" class="group">
          <p
            class="group-hover:border-primary group-hover:bg-primary group-hover:text-[white] transition-all duration-250 py-[10px] px-[20px] border border-[#C4C4C4] rounded-[4px] leading-[100%] text-base text-textTags font-normal">
            Fitness
          </p>
        </a>
      </li>
    </ul>
  </div>
</section>
</div>