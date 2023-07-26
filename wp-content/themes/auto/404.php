<?php get_header(); ?>
<main>
      <section>
        <div class="container">
          <div
            class="flex flex-col items-center mt-[100px] mb-[24px] sm:text-center sm:px-[10px]"
          >
            <p
              class="text-[200px] text-primary font-bold leading-[100%] pb-[24px] sm:text-[150px]"
            >
              404
            </p>
            <p
              class="capitalize mb-[40px] text-textHeader text-base font-semibold leading-[150%]"
            >
              the page you are looking for does not exist!
            </p>
            <a
              href="/"
              class="flex items-center mb-[100px] border-b-2 border-transparent hover:border-primary hover:border-b-2 transition-all duration-300"
            >
              <svg class="w-[20px] h-[20px]">
                <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-Arrow-back"></use>
              </svg>
              <p
                class="capitalize ml-[12px] text-primary text-[20px] font-semibold leading-[140%]"
              >
                Back to homepage
              </p>
            </a>
          </div>
        </div>
      </section>

      <!-- Footer -->

      
</main>
<?php get_footer(); ?>