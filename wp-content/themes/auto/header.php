<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php wp_head(); ?>
  <meta name="description" content="<?php echo esc_attr($meta_description); ?>" />
</head>
<body class="font-['Noto_Sans']">
  <!-- Header -->
  <header>
    <div class="bg-secondary">
        <?php if (!wp_is_mobile()) : ?>
      <nav
        class="container mx-auto flex h-[70px] items-center text-textHeader text-[15px] justify-between sm:px-4 md:px-4 lg:px-4">
        <ul class="flex gap-[5px] sm:hidden md:hidden">
          <li class="flex">
            <a href="/"
              class="font-medium hover:bg-primary hover:text-[white] py-[25px] px-[15px] transition-all duration-250 border-transparent">Home</a>
          </li>
          <li>
            <button onclick="toggleModal()"
              class="group font-medium flex items-end gap-[5px] hover:bg-primary hover:text-[white] py-[25px] pl-[15px] pr-[10px] transition-all duration-250">
              Categories
              <svg id="rotate" class="w-[16px] h-[16px] fill-textHeader group-hover:fill-[white]">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-ctrl"></use>
              </svg>
            </button>
          </li>
          <li class="flex sm:hidden md:hidden mr-[18px]">
            <button onclick="toggleModalContact()"
              class="group font-medium flex items-end gap-[5px] hover:bg-primary hover:text-[white] py-[25px] pl-[15px] pr-[10px] transition-all duration-250">Contact
              <svg id="rotate-contact" class="w-[16px] h-[16px] fill-textHeader group-hover:fill-[white]">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-ctrl"></use>
              </svg>
            </button>
            <!-- Contact Modal -->
          </li>
        </ul>
        <!-- Logo -->
        <div class="justify-center sm:hidden md:hidden lg:hidden">
          <a href="/" class="flex text-lg font-semibold group items-baseline">
            <span
              class="bg-primary text-[white] px-[3px] text-2xl font-semibold group-hover:ring-primary group-hover:ring-1 group-focus:ring-1 group-focus:ring-primary transition-all duration-250">Runners</span>
            Biome
          </a>
        </div>
        <!-- Search -->
        <ul class="flex gap-[5px] items-center">
          <li class="flex sm:hidden md:hidden">
            <form role="search" method="get" class="flex items-center relative "
              action="<?php echo esc_url(home_url('/')); ?>">
              <input required type="search"
                class="w-[325px] sm:w-[150px] h-[32px] pl-[8px] pr-[24px] py-[20px] rounded-lg  focus:border-none hover:ring-primary hover:ring-1 focus:ring-primary focus:ring-2 transition-all duration-250"
                placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'your-theme-domain'); ?>"
                value="<?php echo get_search_query(); ?>" name="s" />
              <button type="submit" aria-label="Search"
                class="z-[2] left-[90%] sm:left-[50%] absolute top-[50%] -translate-y-[50%] w-[26px] h-[32px] flex items-center">
                <svg class="inline-block stroke-0 stroke-[#222222] fill-[#222222] h-5 w-5" viewBox="0 0 32 32">
                  <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-search"></use>
                </svg>
              </button>
            </form>
          </li>
        </ul>
      </nav>
      <?php endif; ?>
      <?php if (wp_is_mobile()) : ?>
          <!--Mobile Nav Bar-->
          <nav class="container mx-auto flex h-[70px] items-center text-textHeader text-[15px] justify-between sm:px-4 md:px-4 lg:px-4">
            <!-- Logo -->
            <div class="justify-center sm:flex md:flex">
              <a href="/" class="flex text-lg font-semibold group items-baseline">
                <span class="bg-primary text-[white] px-[3px] text-2xl font-semibold group-hover:ring-primary group-hover:ring-1 group-focus:ring-1 group-focus:ring-primary transition-all duration-250">Runners</span>
                Biome
              </a>
            </div>
            <!-- Header Mobile Modal -->
            <button type="button" aria-label="open header modal menu" class="sm:flex md:flex w-[26px]" onclick="toggleMobileModal()">
              <svg class="stroke-[black]">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-Hamburger"></use>
              </svg>
            </button>
          </nav>
        <?php endif; ?>
    </div>
  </header>