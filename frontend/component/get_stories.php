<div class="widget post-widget">
    <div class="widget-title">
        <h2 id="recently_viewed">Your latest stories</h2>
    </div>
    <?php
    include_once ROOTPATH . "/backend/models/user.php";

    if (isset($_SESSION['id'])) {
        $stories = User::get($_SESSION['id'], 10)->stories();
        foreach ($stories as $index => $story) : ?>
            <?php $content = wordwrap($story->content, 30, "...");
            
            ?>
            <div class=" d-flex align-items-center mb-5">
                <a href="post-style-1.html"><img class="rounded-circle" src="<?php echo WEBPATH ?>/frontend/assets/images/story/<?php echo $story->image ?>" width="86" alt="Post image">
                </a>
                <div class="ps-3">
                    <h4 class="title-sm">
                        <a href="post-style-1.html"><?php echo $story->title ?></a>
                    </h4>
                    <span class="fs-ms text-muted"> <?php echo date("F jS, Y h:i", strtotime($story->created_at)) ?></span>
                </div>
            </div>

    <?php endforeach;
    } ?>
</div>