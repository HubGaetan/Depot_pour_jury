<?php

namespace App\Models;

class Tag extends Model
{
    // definition du nom de la table
    protected $table = 'tags';


    // requete permettant de récuperer les post associés a un tag
    public function getPosts()
    {
        return $this->query("
        SELECT p.* FROM posts p
        INNER JOIN post_tag pt ON pt.post_id=p.id
        WHERE pt.tag_id = ? ;", [$this->id]);
    }

// select tous les post de la table post (p)
// faire une jonction entre la table post_tag (pt) avec post_id (pt) = id (post (p)) 
// ou le tag id est tag_id recupérer dynamiquement

// *choisi tous les posts appartenant a la jonction post_tag ou tag_id vaut $this->id 


}