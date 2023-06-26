<h1><?= $params['post']->title ?></h1>
<div>
    <?php foreach ($params['post']->getTags() as $tag) : ?>
        <span class="badge badge-info"><?= $tag->name ?></span>
    <?php endforeach ?>
    <?php foreach ($params['post']->getMedias() as $media) : ?>
        <span><img class="img-thumbnail" src="../public/<?= $media->path ?>"></span>
        <!-- <span class="badge badge-info"><?= $media->path ?></span> -->
    <?php endforeach ?>
</div>
<p><?= $params['post']->content ?></p>
<a href="<?= HREF_ROOT ?>posts" class="btn btn-secondary">Retourner en arrière</a>
