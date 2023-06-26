<script language=javascript>
function submitPostLink()
{    
    document.postlink.submit();
}
</script>

<h1><?= $params['post']->title ?? 'Créer un nouvel article' ?></h1>

<?php 
// var_dump($_REQUEST);
// $_REQUEST['url'] = "http://localhost/".$_REQUEST['url'];
// var_dump($_REQUEST);
?>

<?php if(IS_DEBUG) var_dump('form: ',$params) ?>


<form method="POST" enctype="multipart/form-data" name="postlink" action="<?= isset($params['post']) ? HREF_ROOT."admin/posts/edit/{$params['post']->id}" :  "../../admin/posts/create" ?>" >
    <div class="form-group">
        <label for="title">Titre de l'article</label>
        <input type="text" class="form-control" name="title" id="title" value="<?= $params['post']->title ?? '' ?>">
    </div>
    <div class="form-group">
        <label for="content">Contenu de l'article</label>
        <textarea name="content" id="content" rows="8" class="form-control"><?= $params['post']->content ?? '' ?></textarea>
    </div>
    <div class="form-group">
        <label for="tags">Tags de l'article</label>
        <select multiple class="form-control" id="tags" name="tags[]">
            
            <?php foreach ($params['tags'] as $tag) : ?>
                <option value="<?= $tag->id ?>"
                <?php if (isset($params['post'])) : ?>
                <?php $isFirst = 0 ?>
                <?php foreach ($params['post']->getTags() as $postTag) {
                    echo ($tag->id === $postTag->id) ? 'selected' : '';
                    $isFirst++;
                }
                
                ?>
                <?php endif ?>><?= $tag->name ?></option>
            <?php endforeach ?>
            <?php if($isFirst == 0){ echo "<option selected>Non Classé</option>"; } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="medias">media de l'article</label>
        <select multiple class="form-control" id="medias" name="medias[]">
           <?php $isFirst = 0 ?>
            <?php foreach ($params['medias'] as $media) : ?>
                
                <?php if (isset($params['post'])) : ?>
                <?php foreach ($params['post']->getMedias() as $postMedia) 
                {
                    if($media->id === $postMedia->id){
                        $isFirst++;
                        echo '<option value="'.$postMedia->id.'" selected>';
                        echo $media->path;
                        echo '</option>';
                    }                                       
                }
                ?>
                <?php endif ?>                
            <?php endforeach ?>
            <?php if($isFirst == 0) echo "<option selected>No Media</option>"; ?>
        </select>
    </div>

  <div class="form-group">
        <label for="newmedias">Nouveau media de l'article</label>
            <select multiple class="form-control" id="newmedias" name="newmedias[]">
               
           </select>
    </div>
 
    <div class="form-group">
    <label class="chooseimage" for="image_uploads">Choose images to upload (PNG, JPG)</label>
            <input
            type="file"
            id="image_uploads"
            name="image_uploads[]"
            accept=".jpg, .jpeg, .png"
            multiple />
            <div class="preview">
            </div>
       
    </div>


    <button type="submit"  class="btn btn-primary"><?= isset($params['post']) ? "Enregistrer les modifications" : "Enregistrer mon article" ?></button>
    
    </form>

    
    <!--

    Test séparé du form pour l'enregistrement des images qui appelle directement la route saveimages
    <form  method="POST" enctype="multipart/form-data" action=<?=HREF_ROOT."/admin/medias/saveimages"?>>
    <div class="form-group">
    <label for="image_uploads">Choose images to upload (PNG, JPG)</label>
            <input
            type="file"
            id="image_uploads"
            name="image_uploads[]"
            accept=".jpg, .jpeg, .png"
            multiple />
            <div class="preview">
            </div>
       
    </div>
    <button type="submit"class="btn btn-primary"> Save Image(s) </button>
    </form>

    -->
  



