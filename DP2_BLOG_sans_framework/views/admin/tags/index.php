<h1>Administration des tags</h1>

<?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">Vous êtes connecté!</div>
<?php endif ?>

<a href="<?= HREF_ROOT ?>admin/tags/create" class="btn btn-success my-3">Créer un nouvel tags</a>
<a href="<?= HREF_ROOT ?>admin/posts" class="btn btn-success my-3">Administation des Articles</a>
<a href="<?= HREF_ROOT ?>admin/medias" class="btn btn-success my-3">Administation des medias</a>

<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($params['tags'] as $tag) : ?>
            <tr>
                <th scope="row"><?= $tag->id ?></th>
                <td><?= $tag->name ?></td>
                <td>
                    <a href="<?= HREF_ROOT ?>admin/tags/edit/<?= $tag->id ?>" class="btn btn-warning">Modifier</a>
                   
                    <form action="<?= HREF_ROOT ?>admin/tags/delete/<?= $tag->id ?>" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>