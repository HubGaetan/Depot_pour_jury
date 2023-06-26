<h1><?= $params['media']->name ?></h1>

<?php foreach ($params['media']->getPosts() as $post) : ?>
    <div class="card mb-3">
        <div class="card-body">
            <a><a href="<?= HREF_ROOT ?>posts/<?= $post->id ?>"><?= $post->title ?></a></a>
        </div>
    </div>
<?php endforeach ?>

