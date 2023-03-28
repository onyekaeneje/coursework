 
<section class="hero-slider">
    <div class="owl-carousel owl-theme" id="hero-slider-two">
        <?php
        include_once $_SERVER['DOCUMENT_ROOT'] . "/storyapp/backend/models/category.php";
        include_once $_SERVER['DOCUMENT_ROOT'] . "/storyapp/backend/models/story.php";
        $categories = Category::all();
        foreach ($categories as $index => $category) {
        ?>
            <div class="item py-10 overly" style="background-image: url(assets/images/<?php echo $category->image ?>);">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-sm-10 mx-auto text-center">
                            <a class="entry-meta text-white" href="category.html"><?php echo $category->name; ?></a>
                            <h1 class="my-5"><a class="text-white" href="post-style-1.html"><?php echo $category->description; ?></a></h1>
                            <a href="post-style-1.html" class="btn-unfill text-white"><?php echo $category->cta; ?><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>

    </div>
</section>