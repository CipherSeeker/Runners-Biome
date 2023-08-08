<?php
/*
Template Name: privacypolicy
*/
?>
<?php get_header(); ?>
    <main>
        <sectoin>
            <div class="container">
                <div class="mt-[80px]">
                    <h1 class="flex justify-center text-[27px] text-textTitles font-semibold leading-[140%] mb-[64px] mt-[16px]">
                            <?php the_title(); ?>
                    </h1>
                    <div class="prose">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </sectoin>
    </main>
<?php get_footer(); ?>