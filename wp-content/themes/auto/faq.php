<?php
/*
Template Name: faq
*/
?>
<?php get_header(); ?>
    <section>
        <div class="container flex items-center flex-col justify-center mb-[100px] ">
            <h1 class="mt-[100px] mb-[16px] text-[27px] font-semibold leading-[140%] mb-[16px] capitalize">
                <span class="bg-primary text-[white] px-[3px] mr-[2px]">Frequently</span>Asked question
            </h1>
            <p class="text-[#666666] text-[16px] leading-[150%] font-normal	mb-[40px]">Here You can look for most common and frequently asked question</p>
            <div>
                <?php echo do_shortcode('[faq id="602"]'); ?>
            </div>
            <div class="flex flex-col font-normal leading-[140%] items-center">
                    <h2 class="text-[#333333] text-center text-[21px] mb-[32px]">Can't find an answer to your question?</h2>
                    <button onclick="toggleModalContact()" type="button" class="flex justify-center items-baseline border-solid border border-primary text-[16px] rounded-[6px] py-[15px] w-[153px] group hover:bg-primary hover:text-[white]  transition-all duration-250">Contact Us
                        <svg class="w-[20px] h-[10px] ml-[8px] fill-[#666666] group-hover:fill-[white] transition-all duration-250">
                            <use href="<?php echo get_template_directory_uri(); ?>/assets/img/icons.svg#icon-Arrow-r"></use>
                        </svg>
                    </button>
            </div>
        </div>
    </section>
<?php get_footer(); ?>