<?php

namespace App\Models;

use DateTime;
use App\Models\Tag;

class Post extends Model {

    protected $table = 'posts';

    /**
     * Summary of getCreatedAt
     * @return string
     */
    public function getCreatedAt(): string
    {
        return (new DateTime($this->created_at))->format('d/m/Y à H:i');
    }

    /**
     * Summary of getExcerpt
     * @return string
     */
    public function getExcerpt(): string
    {
        return substr($this->content, 0, 200) . '...';
    }

    /**
     * Summary of getButton
     * @return string
     */
    public function getButton(): string
    {
        return '<a href="'.HREF_ROOT.'posts/'.$this->id.'" class="btn btn-primary">Lire l article</a>';
        // return <<<HTML
        // <a href="http://localhost/oop-php-framework/posts/$this->id" class="btn btn-primary">Lire l'article</a>
        // HTML;
    }

    /**
     * Summary of getTags
     * 
     * @return mixed
     */
    public function getTags()
    {
        return $this->query("
            SELECT t.* FROM tags t
            INNER JOIN post_tag pt ON pt.tag_id = t.id
            WHERE pt.post_id = ?
        ", [$this->id]);
    }

    public function getMedias()
    {       
        return $this->query("
            SELECT m.* FROM medias m
            INNER JOIN post_media pm ON pm.media_id = m.id
            WHERE pm.post_id = ?
        ", [$this->id]);
    }

    /**
     * Summary of create
     * @param array $data
     * @param array|null $relations
     * @return bool
     */
    public function create(array $data, ?array $relations = null)
    {
    
        if(IS_DEBUG) var_dump("Post.php create: ", $relations );
        //die();
        parent::create($data);
        //var_dump("Post.php update", $data,  $relations);
        $id = $this->db->getPDO()->lastInsertId();

        foreach ($relations['tags'] as $tagId) {
            $stmt = $this->db->getPDO()->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$id, $tagId]);
        }


          // if(IS_DEBUG) var_dump("Post.php update relations[newmedias][0]:" , $relations['newmedias']);
          foreach($relations['newmedias'] as $newmedia)
          {
             // Var_dump("newmedia: ",$newmedia);
              $stmt = $this->db->getPDO()->prepare("SELECT id FROM medias WHERE path = ?");
              $stmt->execute([$newmedia]);  
              // TO DO Pour augmenter la sécurité il faudrait passer les variables en BindParam
              // on récupère l'id du path du media déjà présent
              $mediaId  = $stmt->fetchColumn();
              if(IS_DEBUG) var_dump("mediaId: ",$mediaId);
          
          // Si le path du media n'existe pas déjà dans la base de donnée
              if($mediaId === false) {
                  // récupérer  l'id 
                  //$stmt = $this->db->getPDO()->prepare("INSERT INTO medias (path) VALUES (?)");
                   // permet de réécrire un changement d'image pour un post (article) donné en respectant le changement d'ordre d'apparition dans la fenêtre de sélection
                  $stmt = $this->db->getPDO()->prepare("INSERT INTO medias (path) VALUES (?) ON DUPLICATE KEY UPDATE path = VALUES(path)");        
                  $stmt->execute([$newmedia]);
                  $mediaId = $this->db->getPDO()->lastInsertId();
             }
             else{
   
             }
             // on execute la requete de mise à jour avec le bon mediaId
              $stmt = $this->db->getPDO()->prepare("INSERT post_media (post_id, media_id) VALUES (?, ?)");
              $result =  $stmt->execute([$id, $mediaId]);
             
          }

        return true;
    }

    /**
     * Summary of update
     * @param int $id
     * @param mixed $data
     * @param array|null $relations
     * @return bool
     */
    public function update(int $id, mixed $data, ?array $relations = null)
    {
        if(IS_DEBUG) var_dump("Post.php update: relations:", $relations );
        parent::update($id, $data);

        // on delete les tags du post pour ajouter les nouveaux à la place
        $stmt = $this->db->getPDO()->prepare("DELETE FROM post_tag WHERE post_id = ?");
        $result = $stmt->execute([$id]);
       // var_dump("Post.php update", $data,  $relations);
        foreach ($relations['tags'] as $tagId) {
            $stmt = $this->db->getPDO()->prepare("INSERT post_tag (post_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$id, $tagId]);
        }

       if(IS_DEBUG) var_dump("Post.php update relations[newmedias][0]:" , $relations['newmedias']);
        foreach($relations['newmedias'] as $newmedia)
        {

            if(IS_DEBUG) Var_dump("newmedia: ",$newmedia);
            $stmt = $this->db->getPDO()->prepare("SELECT id FROM medias WHERE path = ?");
            $stmt->execute([$newmedia]);  
            // TO DO Pour augmenter la sécurité il faudrait passer les variables en BindParam
            // on récupère l'id du path du media déjà présent
            $mediaId  = $stmt->fetchColumn();
            if(IS_DEBUG) var_dump("mediaId: ",$mediaId);
        
        // Si le path du media n'existe pas déjà dans la base de donnée
            if($mediaId === false) {
                // récupérer  l'id 
                //$stmt = $this->db->getPDO()->prepare("INSERT INTO medias (path) VALUES (?)");
                 // permet de réécrire un changement d'image pour un post (article) donné en respectant le changement d'ordre d'apparition dans la fenêtre de sélection
                $stmt = $this->db->getPDO()->prepare("INSERT INTO medias (path) VALUES (?) ON DUPLICATE KEY UPDATE path = VALUES(path)");        
                $stmt->execute([$newmedia]);
                $mediaId = $this->db->getPDO()->lastInsertId();
           }
           else{
 
           }
           // on execute la requete de mise à jour avec le bon mediaId
            $stmt = $this->db->getPDO()->prepare("INSERT post_media (post_id, media_id) VALUES (?, ?)");
            $result =  $stmt->execute([$id, $mediaId]);
           
        }
  

        if ($result) {
           //  if(IS_DEBUG) die();
            return true;
        }

    }
}
