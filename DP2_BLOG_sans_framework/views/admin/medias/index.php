<h1>Administration des medias</h1>

<?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">Vous êtes connecté!</div>
<?php endif ?>

<a href="<?= HREF_ROOT ?>admin/tags" class="btn btn-success my-3">Administation des tags</a>
<a href="<?= HREF_ROOT ?>admin/posts" class="btn btn-success my-3">Administation des Articles</a>


<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Media</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['medias'] as $media) : ?>
            <tr>
                <th scope="row"><?= $media->id ?></th>
                <td><img class="img-thumbnail" width="300" src="../public/<?= $media->path ?>"></td>
                <td><?= $media->path ?></td>   
                <td><?= $media->alttext ?></td>
                <td>
                    <form action="<?= HREF_ROOT ?>admin/medias/delete/<?= $media->id ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>