<script language=javascript>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>

<h1><?= $params['medias']->path ?? 'Créer un nouveau media' ?></h1>

<?php 
 // var_dump($_REQUEST);
// $_REQUEST['url'] = "http://localhost/".$_REQUEST['url'];
// var_dump($_REQUEST);
?>
<?php
// echo "<pre>";
// var_dump("POST:",$_POST, "</br>");
// var_dump($params);
// echo "</pre>";
?>
<form method="POST" name="postlink" action="<?= isset($params['medias']) ? HREF_ROOT."admin/medias/edit/{$params['medias']->id}" :  "../../admin/medias/create" ?>" >
    <div class="form-group">
        <label for="title">Media</label>
        <input type="text" class="form-control" name="path" id="path" value="<?= $params['medias']->path ?? '' ?>">
    </div>
    
    <button type="submit"  class="btn btn-primary"><?= isset($params['medias']) ? "Enregistrer les modifications" : "Enregistrer mon media" ?></button>
    
    </form>