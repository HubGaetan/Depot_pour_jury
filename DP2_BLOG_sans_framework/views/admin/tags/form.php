<script language=javascript>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>

<h1><?= $params['tags']->name ?? 'Créer un nouveau tag' ?></h1>

<?php 
// var_dump($_REQUEST);
// $_REQUEST['url'] = "http://localhost/".$_REQUEST['url'];
// var_dump($_REQUEST);
?>
<?php
 echo "<pre>";
 if(IS_DEBUG) var_dump("POST:",$_POST, "</br>");
if(IS_DEBUG) var_dump($params);
 echo "</pre>";
?>
<form method="POST" name="postlink" action="<?= isset($params['tags']) ? HREF_ROOT."admin/tags/edit/{$params['tags']->id}" :  "../../admin/tags/create" ?>" >
    <div class="form-group">
        <label for="title">Nom</label>
        <input type="text" class="form-control" name="name" id="name" value="<?= $params['tags']->name ?? '' ?>">
    </div>
    
    <button type="submit"  class="btn btn-primary"><?= isset($params['tags']) ? "Enregistrer les modifications" : "Enregistrer mon tag" ?></button>
    
    </form>