<footer class="bg-tertiary h-[435px] sm:h-[auto] mt-[80px] md:h-[auto]">
  <div
    class="container  sm:after:hidden md:after:hidden after:content-[''] after:block after:w-[auto] after:h-[1px] after:bg-[#D1E7E5] after:rounded-[3px]">
    <div class="flex justify-between sm:flex-col sm:justify-center md:flex-col md:justify-center">
<!-- Logo -->
      <div class="flex flex-col mt-[103px] sm:text-center md:items-center md:text-center">
        <div class="flex sm:justify-center">
          <a href="/" class="flex text-lg font-semibold group items-baseline">
            <span
              class="bg-primary text-[white] px-[3px] text-2xl font-semibold group-hover:ring-primary group-hover:ring-1 group-focus:ring-1 group-focus:ring-primary transition-all duration-250">Runners</span>
            Biome
          </a>
        </div>
        <p
          class="w-[236px] mt-[24px] mr-[110px] sm:w-[auto] sm:mr-[0px] font-normal text-textPosts text-base leading-[150%] sm:justify-center md:mr-[0px]">
          Your Ultimate Blog on Running. Technique, Injuries, Diet, Nutrition, Weight Loss & More.
        </p>
      </div>
<!-- Posts -->
    <?php if (!wp_is_mobile()) : ?>
      <div class="flex flex-col mt-[103px] mr-[140px] sm:hidden md:hidden">
        <div>
          <h3 class="mb-[24px] text-lg font-semibold">Posts</h3>
        </div>
        <ul>
            <?php
              $categories = get_categories();
              foreach ($categories as $category) {
                ?>
                <li class="mb-[16px] font-normal text-textPosts text-base leading-[150%]">
                  <a href="<?php echo get_category_link($category->term_id); ?>">
                    <p class="hover:text-primary transition-all duration-250">
                      <?php echo esc_html($category->name); ?>
                    </p>
                  </a>
                </li>
                <?php
              }
            ?>
        </ul>
      </div>
      <!-- Quick Links -->
      <div class="flex flex-col mt-[103px] sm:hidden md:hidden">
        <div>
          <h3 class="mb-[24px] text-lg font-semibold">Quick Links</h3>
        </div>
        <ul>
          <li class="mb-[16px] font-normal text-textPosts text-base leading-[150%]">
            <a href="<?php echo home_url('/frequently-asked-questions/'); ?>">
              <p class="hover:text-primary transition-all duration-250">
                FAQ
              </p>
            </a>
          </li>
          <li class="mb-[16px] font-normal text-textPosts text-base leading-[150%]">
            <a href="<?php echo home_url('/terms-and-conditions/'); ?>">
              <p class="hover:text-primary transition-all duration-250">
                Terms & Conditions
              </p>
            </a>
          </li>
          <li class="mb-[16px] font-normal text-textPosts text-base leading-[150%]">
            <a href="<?php echo home_url('/privacy-policy/'); ?>">
              <p class="hover:text-primary transition-all duration-250">
                Privacy Policy
              </p>
            </a>
          </li>
        </ul>
      </div>
      <?php endif; ?>
<!-- Subscribe -->
      <div class="flex flex-col mt-[103px] ml-[130px] md:mt-[50px] sm:ml-[0px] md:ml-[0px] sm:items-center md:items-center">
        <div>
          <h3 class="mb-[24px] text-lg font-semibold">
            Subscribe for newsletter
          </h3>
        </div>
        <div>
            <?php echo do_shortcode('[mailpoet_form id="1"]'); ?>
        </div>
<!-- Share On: -->
        <div
          class="mb-[66px] sm:flex sm:flex-col sm:items-center sm:mt-[80px] md:flex md:flex-col md:items-center md:mt-[80px]">
          <h3 class="mb-[26px] text-lg font-semibold">Share On:</h3>
          <div class="flex flex-wrap justify-left list-none gap-[18px]">
            <?php echo do_shortcode('[Sassy_Social_Share]'); ?>
          </div>
        </div>
<!-- Line -->
        <div class=""></div>
      </div>
    </div>
  </div>
</footer>
<!-- Contact Modal -->
<div id="modal-contact" class="modal is-hidden">
  <div class="modal-content container bg-tertiary rounded-[12px] flex justify-center md:px-4">
    <div
      class="relative mb-[40px] md:after:hidden after:content-[''] after:block after:w-[1000px] after:h-[1px] after:bg-[#D1E7E5] after:rounded-[3px]">
      <div>
        <button onclick="toggleModalContact()" type="button"
          class="modal-button absolute top-[0] left-[107.5%] md:left-[60%] group bg-tertiary hover:bg-primary hover:fill-[white] md:static">
          <svg class="modal-button-close fill-primary group-hover:fill-[white]">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-close-button">
            </use>
          </svg>
        </button>
        <div class="flex justify-center mb-[60px] mt-[80px]">
          <h2 class="text-xl font-semibold">
            <span class="bg-primary text-[white] px-[3px] mr-[2px]">Contact</span>Us
          </h2>
        </div>
      </div>
<!--Contact Form-->
      <div>
           <?php echo do_shortcode('[wpforms id="491"]'); ?>
      </div>
    </div>
  </div>
</div>
<!-- Header Mobile Modal -->
<?php if (wp_is_mobile()) : ?>
    <div class="modal is-hidden" id="modal-mobile">
      <div>
        <button type="button" class="relative z-5 modal-button group bg-tertiary hover:bg-primary hover:fill-[white]"
          onclick="toggleMobileModal()">
          <svg class="modal-button-close fill-primary group-hover:fill-[white]">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-close-button"></use>
          </svg>
        </button>
        <div class="mob-menu flex">
          <ul class="flex flex-col gap-[5px] sm:mt-[75px] md:mt-[75px] items-center text-center w-screen">
            <li class="flex justify-center mb-[10px] mt-[20px] w-[100%] px-[25px]">
              <a href="/"
                class="w-[100%] font-medium hover:bg-primary bg-secondary hover:text-[white] py-[25px] transition-all duration-250 rounded-lg">Home</a>
            </li>
            <li class="flex justify-center mb-[10px] mt-[20px] w-[100%] px-[25px]  transition-all duration-250">
              <button type="button" onclick="toggleModal()"
                class="w-[100%] font-medium hover:bg-primary bg-secondary hover:text-[white] py-[25px] transition-all duration-250 rounded-lg">
                Categories
              </button>
            </li>
            <li class="fflex justify-center mb-[60px] mt-[20px] w-[100%] px-[25px]">
              <button type="button" onclick="toggleModalContact()"
                class="w-[100%] font-medium hover:bg-primary bg-secondary hover:text-[white] py-[25px] transition-all duration-250 rounded-lg">Contact
              </button>
            </li>
            <!-- Search -->
            <li>
              <form role="search" method="get" class="flex items-center relative w-screen px-[25px]"
                action="<?php echo esc_url(home_url('/')); ?>">
                <input required type="search"
                  class="w-[100%] h-[auto] py-[22px] px-[15px] rounded-lg border-solid border-[2px] border-primary hover:border-primary focus:border-transparent focus:ring-primary focus:ring-2 transition-all duration-250"
                  placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'your-theme-domain'); ?>"
                  value="<?php echo get_search_query(); ?>" name="s" />
                <button type="submit" aria-label="Search"
                  class="z-[2] left-[90%] sm:left-[85%] absolute top-[50%] -translate-y-[50%] w-[26px] h-[32px] flex items-center">
                  <svg class="inline-block stroke-0 stroke-[#222222] fill-[#222222] h-5 w-5" viewBox="0 0 32 32">
                    <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-search"></use>
                  </svg>
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </div>
<?php endif; ?>
<!-- Categoties Modal -->
<div id="modal" class="modal is-hidden">
  <div class="modal-content container bg-tertiary rounded-[12px] sm:px-4">
    <div class="mb-[80px] overflow-y-auto md:h-[100vh] md:w-[auto] md:flex md:flex-col ">
      <button type="button" class="modal-button group bg-tertiary hover:bg-primary hover:fill-[white]  md:mt-[100px] md:block md:content-center"
        onclick="toggleModal()">
        <svg class="modal-button-close fill-primary group-hover:fill-[white]">
          <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-close-button">
          </use>
        </svg>
      </button>
      <div class="flex justify-center mb-[60px] mt-[20px] md:mt-[50px]">
        <h2 class="text-xl font-semibold text-textTitles">
          Categories
        </h2>
      </div>
      <div class="">
        <ul class="flex justify-center gap-[30px] md:flex-col">
        <li>
          <a href="<?php echo get_category_link(5); ?>"
            class="mb-[25px] w-[268px] h-[152px] md:w-[100%] flex flex-col items-center justify-center bg-secondary rounded-[10px] group hover:bg-primary transition-all duration-250">
            <svg class="w-[40px] h-[40px] fill-primary group-hover:fill-[white] mb-[24px]">
              <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-Health">
              </use>
            </svg>
            <p class="text-base font-medium leading-[150%] text-textTitles group-hover:text-[white]">
                <?php $category = get_category(5);
                    echo $category->name;
                ?>
            </p>
          </a>
        </li>
      </ul>
  </div>
    </div>
  </div>
</div>
  <?php wp_footer(); ?>
</body>
</html>