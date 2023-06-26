<h1>Les derniers articles</h1>

<?php foreach ($params['posts'] as $post) : ?>
    <div class="card mb-3">
        <div class="card-body">
            <h2><?= $post->title ?></h2>
            <div>
                <?php foreach ($post->getTags() as $tag) : ?>
                    <span class="badge badge-success"><a href="<?= HREF_ROOT ?>tags/<?= $tag->id ?>" class="text-white"><?= $tag->name ?></a></span>
                <?php endforeach ?>
            </div>

            <div>
                <?php foreach ($post->getMedias() as $media) : ?>
                    <span><img class="img-thumbnail" width="300em" src="public/<?= $media->path ?>"></span>
                <?php endforeach ?>
            </div>

            <small class="text-info">Publié le <?= $post->getCreatedAt() ?></small>
            <p><?= $post->getExcerpt() ?></p>
            <?= $post->getButton() ?>
        </div>
    </div>
<?php endforeach ?>
