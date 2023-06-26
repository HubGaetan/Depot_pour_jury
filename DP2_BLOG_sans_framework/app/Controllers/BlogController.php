<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Media;

// Le blog controller permet de gerer toutes les commandes frontales de l'application
class BlogController extends Controller
{

    /**
     * 
     */
    public function welcome()
    {
        return $this->view('blog.welcome');
    }

    /**
     * Summary of index
     * @return void
     */
    public function index()
    {
        $post = new Post($this->getDB());
        $posts = $post->all();

        return $this->view('blog.index', compact('posts'));
    }

    /**
     * Summary of show
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        $post = new Post($this->getDB());
        $post = $post->findById($id);

        return $this->view('blog.show', compact('post'));
    }

    /**
     * Summary of tag
     * @param int $id
     * @return void
     */
    public function tag(int $id)
    {
        $tag = (new Tag($this->getDB()))->findById($id);

        return $this->view('blog.tag', compact('tag'));
    }

    public function media(int $id)
    {
        $medias = (new Media($this->getDB()))->findById($id);

        return $this->view('blog.media', compact('medias'));
    }


}