<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Running Blog</title>

  <?php wp_head(); ?>

</head>

<body class="font-['Noto_Sans'] ">
  <!-- Header -->
  <header class="">
    <div class="bg-secondary">
      <nav
        class="container mx-auto flex h-[70px] items-center text-textHeader text-[15px] justify-between sm:px-4 md:px-4 lg:px-4">
        <!-- Logo -->
        <div class="justify-center sm:flex md:flex xl:hidden">
          <a href="/" class="flex text-lg font-semibold group items-baseline">
            <span
              class="bg-primary text-[white] px-[3px] text-2xl font-semibold group-hover:ring-primary group-hover:ring-1 group-focus:ring-1 group-focus:ring-primary transition-all duration-250">Running</span>
            Guide
          </a>
        </div>
        <ul class="flex gap-[5px] sm:hidden md:hidden">
          <li class="flex">
            <a href="/"
              class="font-medium hover:bg-primary hover:text-[white] py-[25px] px-[15px] transition-all duration-250 border-transparent">Home</a>
          </li>
          <li class="flex">
            <a href="./404.html"
              class="font-medium hover:bg-primary hover:text-[white] py-[25px] px-[15px] transition-all duration-250">About</a>
          </li>
          <li>
            <a href="#" onclick="toggleModal()"
              class="group font-medium flex items-end gap-[5px] hover:bg-primary hover:text-[white] py-[25px] pl-[15px] pr-[10px]">
              Categories
              <svg id="rotate" class="w-[16px] h-[16px] fill-textHeader group-hover:fill-[white]">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-ctrl"></use>

              </svg>
            </a>

          </li>
          <li class="flex">
            <a href="./post.html"
              class="font-medium hover:bg-primary hover:text-[white] py-[25px] px-[15px] transition-all duration-250">All
              Posts</a>
          </li>
        </ul>
        <!-- Logo -->
        <div class="justify-center sm:hidden md:hidden lg:hidden">
          <a href="#" class="flex text-lg font-semibold group items-baseline">
            <span
              class="bg-primary text-[white] px-[3px] text-2xl font-semibold group-hover:ring-primary group-hover:ring-1 group-focus:ring-1 group-focus:ring-primary transition-all duration-250">Running</span>
            Guide
          </a>
        </div>

        <!-- Search -->

        <ul class="flex gap-[5px] items-center">
          <li class="flex sm:hidden md:hidden">
            <form role="search" method="get" class="flex items-center relative "
              action="<?php echo esc_url(home_url('/')); ?>">


              <input required type="search"
                class="w-[249px] sm:w-[150px] h-[32px] pl-[8px] pr-[24px] py-[15px] rounded-lg border-transparent hover:border-primary focus:border-transparent focus:ring-primary focus:ring-2 transition-all duration-250"
                placeholder="<?php echo esc_attr_x('Search...', 'placeholder', 'your-theme-domain'); ?>"
                value="<?php echo get_search_query(); ?>" name="s" />



              <button type="submit"
                class="z-[2] left-[90%] sm:left-[50%] absolute top-[50%] -translate-y-[50%] w-[26px] h-[32px] flex items-center">

                <svg class="inline-block stroke-0 stroke-[#222222] fill-[#222222] h-5 w-5" viewBox="0 0 32 32"
                  id="searchIcon">
                  <symbol id="icon-search" viewBox="0 0 32 32">
                    <path
                      d="M19.427 20.427c-1.39 0.99-3.090 1.573-4.927 1.573-4.694 0-8.5-3.806-8.5-8.5s3.806-8.5 8.5-8.5c4.694 0 8.5 3.806 8.5 8.5 0 1.837-0.583 3.537-1.573 4.927l5.585 5.585c0.55 0.55 0.546 1.431-0 1.976l-0.023 0.023c-0.544 0.544-1.431 0.546-1.976 0l-5.585-5.585zM14.5 20c3.59 0 6.5-2.91 6.5-6.5s-2.91-6.5-6.5-6.5c-3.59 0-6.5 2.91-6.5 6.5s2.91 6.5 6.5 6.5v0z">
                    </path>
                  </symbol>
                  <use xlink:href="#icon-search"></use>
                </svg>
              </button>
            </form>
          </li>
          <li class="flex sm:hidden md:hidden">
            <a onclick="toggleModalContact()" href="#"
              class="group font-medium flex items-end gap-[5px] hover:bg-primary hover:text-[white] py-[25px] pl-[15px] pr-[10px]">Contact
              <svg id="rotate-contact" class="w-[16px] h-[16px] fill-textHeader group-hover:fill-[white]">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-ctrl"></use>
              </svg>
            </a>

            <!-- Contact Modal -->


          </li>
        </ul>

        <!-- Header Mobile Modal -->

        <button type="button" class="hidden sm:flex md:flex w-[26px]" onclick="toggleMobileModal()">
          <svg class="">
            <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-Hamburger"></use>
          </svg>
        </button>


        <!-- End of Header Modal -->
      </nav>
    </div>
  </header>