<section class="posts-3 py-10">
    <div class="container">
        <div class="row gx-lg-5">
            <div class="col-lg-8 pr-xl-4">
                <div class="entry-header">
                    <h1 class="display-6 py-2">Featured Stories</h1>
                </div>
                <?php
                $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';
                $stories = Story::all(10, true, 0, $order);
                if (count($stories) > 0) {
                    foreach ($stories as $index => $story) : ?>

                <div class=" single-entry featured-entry text-center wow fadeInUp2" data-wow-offset="30"
                    data-wow-duration="1.5s" data-wow-delay="0.15s">
                    <div class="entry-thumb mb-5">
                        <a href="<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>"> <img
                                src="<?php echo WEBPATH ?>/frontend/assets/images/story/<?php echo $story->image ?>"
                                class="img-fluid" alt="blog"></a>
                        <div class="entry-share d-flex">
                            <a href="#"><i class="fa fa-heart"></i></a>
                            <a href="<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>"><i
                                    class="fa fa-link"></i></a>
                        </div>
                    </div>
                    <div class="entry-content px-3">
                        <span class="entry-meta">
                            <a
                                href="<?php echo WEBPATH ?>/frontend/pages/category.php"><?php echo $story->category()->name ?></a>
                        </span>
                        <h3 class="entry-title mb-4"><a
                                href="<?php echo WEBPATH ?>/frontend/pages/story.php?id=<?php echo $story->id ?>"><?php echo $story->title ?></a>
                        </h3>
                        <span class="fs-sm">by <a href="#"><?php echo $story->author() ?></a></span>
                    </div>
                </div>

                <?php endforeach;
                } else { ?>
                <div class=" d-flex align-items-center mb-5">
                    <div class="ps-3 text-center">
                        <p class="fs-ms text-muted text-center"> No recent published stories</p>
                    </div>
                </div>
                <?php }
                ?>


                <div class="entry-navigation my-5 pt-5 text-center">
                    <span><a href="<?php echo WEBPATH ?>/?order=DESC">Newer</a></span>
                    <span><a href="<?php echo WEBPATH ?>/?order=ASC">Older</a></span>
                </div>
            </div>

            <div class="col-lg-4 sidebar left-line ps-5">


                <div class="widget add">
                    <h2>Advertisement</h2>
                    <a href="#"><img src="/coursework/frontend/assets/images/add-2.jpg" class="img-fluid" alt="add"></a>
                </div>
                <div class="widget post-widget">
                    <div class="widget-title">
                        <h2 id="recently_viewed">Recently Viewed</h2>
                    </div>
                    <div class=" d-flex align-items-center mb-5">
                        <a href="post-style-1.html"><img class="rounded-circle"
                                src="/coursework/frontend/assets/images/rb-2.jpg" width="86" alt="Post image">
                        </a>
                        <div class="ps-3">
                            <h4 class="title-sm">
                                <a href="post-style-1.html">Do interesting things, and interesting things will
                                    happen</a>
                            </h4>
                            <span class="fs-ms text-muted">September 15, 2021 </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-5">
                        <a href="post-style-1.html"><img class="rounded-circle"
                                src="/coursework/frontend/assets/images/rb-1.jpg" width="86" alt="Post image">
                        </a>
                        <div class="ps-3">
                            <h4 class="title-sm">
                                <a href="post-style-1.html">Do interesting things, and interesting things will
                                    happen</a>
                            </h4>
                            <span class="small text-muted">September 21, 2021 </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-5">
                        <a href="post-style-1.html"><img class="rounded-circle"
                                src="/coursework/frontend/assets/images/rb-1.jpg" width="86" alt="Post image">
                        </a>
                        <div class="ps-3">
                            <h4 class="title-sm">
                                <a href="post-style-1.html">Do interesting things, and interesting things will
                                    happen</a>
                            </h4>
                            <span class="small text-muted">September 21, 2021 </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-5">
                        <a href="post-style-1.html"><img class="rounded-circle"
                                src="/coursework/frontend/assets/images/rb-1.jpg" width="86" alt="Post image">
                        </a>
                        <div class="ps-3">
                            <h4 class="title-sm">
                                <a href="post-style-1.html">Do interesting things, and interesting things will
                                    happen</a>
                            </h4>
                            <span class="small text-muted">September 21, 2021 </span>
                        </div>
                    </div>
                </div>
                <div class="widget category-widget">
                    <div class="widget-title">
                        <h2>Categories</h2>
                    </div>
                    <ul>
                        <?php
                        $categories = Category::all();
                        if (count($categories) > 0) {
                            foreach ($categories as $index => $category) : ?>

                        <li>
                            <a href="#"><span><?php echo ++$index ?></span><?php echo $category->name ?></a>
                        </li>
                        <?php endforeach;
                        } else { ?>
                        <li class="ps-3 text-center">
                            <p class="fs-ms text-muted text-center"> No categories</p>
                        </li>
                        <?php }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>