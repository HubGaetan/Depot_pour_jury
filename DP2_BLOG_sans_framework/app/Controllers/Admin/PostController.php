<?php

namespace App\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Media;
use App\Controllers\Controller;
use App\Controllers\Admin\MediaController;

class PostController extends Controller {

    
    /**
     * Summary of index
     * @return void
     */
    public function index()
    {
        $this->isAdmin();

        $posts = (new Post($this->getDB()))->all();

        return $this->view('admin.post.index', compact('posts'));
    }

    /**
     * Summary of create
     * @return void
     */
    public function create()
    {
        $this->isAdmin();

        $tags = (new Tag($this->getDB()))->all();
        $medias = (new Media($this->getDB()))->all();
              
        return $this->view('admin.post.form', compact('tags', 'medias'));
    }

    /**
     * Summary of createPost
     * @return void
     */
    public function createPost()
    {
        
        $this->isAdmin();

        $post = new Post($this->getDB());
        $mediacontroller = new MediaController($this->getDB());

        if(IS_DEBUG)  var_dump("Model edit:", $_POST);
        if(isset($_POST['newmedias'])) { $newmedias  = array_pop($_POST);}  else { $newmedias = array(); }
        if(isset($_POST['medias'])) { $medias  = array_pop($_POST);}  else { $medias = array(); }
        if(isset($_POST['tags'])) { $tags  = array_pop($_POST);}  else { $tags = array(); }
    //    $newmedias  = array_pop($_POST);
    //    $medias =   array_pop($_POST);
    //    $tags =  array_pop($_POST);    
            
        
// compact($tags, $medias)
        //var_dump($_POST); die();

        $result = $post->create($_POST, compact('tags', 'medias', 'newmedias'));

        if ($result) {
            $mediacontroller->upload();
            return header('Location:'.HREF_ROOT.'admin/posts');
        }
    }

    /**
     * Summary of edit
     * @param int $id
     * @return void
     */
    public function edit(int $id)
    {
        if(IS_DEBUG)  var_dump("Model edit:", $id);
        $this->isAdmin();

        $post = (new Post($this->getDB()))->findById($id);
        $tags = (new Tag($this->getDB()))->all();
        $medias = (new Media($this->getDB()))->all();
               
        //var_dump( $post);
        //var_dump( $tags);
        //var_dump( $medias);
        
        //var_dump("Model edit:", $post);
        //var_dump("Model edit:", $tags);
        return $this->view('admin.post.form', compact('post', 'tags', 'medias'));
        //return $this->view('admin.post.form', compact('post'));
    }

    /**
     * Summary of update
     * @param int $id
     * @return void
     */
    public function update(int $id)
    {
        if(IS_DEBUG) var_dump("PostController update id:", $id);
        $this->isAdmin();

        $post = new Post($this->getDB());
        
        $mediacontroller = new MediaController($this->getDB());
       
        
        if(IS_DEBUG) var_dump("PostController update POST:",$_POST);
        var_dump("PostController update POST:",$_POST);
        //die();
    
       if(isset($_POST['newmedias'])) { $newmedias  = array_pop($_POST);}  else { $newmedias = array(); }
       if(isset($_POST['medias'])) { $medias  = array_pop($_POST);}  else { $medias = array(); }
       if(isset($_POST['tags'])) { $tags  = array_pop($_POST);}  else { $tags = array(); }
    //    if(isset($_POST['medias'])) $medias = array_pop($_POST);
    //    if(isset($_POST['tags'])) $tags = array_pop($_POST);

        // $newmedias  = $_POST['newmedias'];
        // $medias  = $_POST['medias'];
        // $tags  = $_POST['tags'];       
        
    if(IS_DEBUG) var_dump("PostController POST newmedias:",$_POST, $tags, $medias , $newmedias);
    // die();
       // var_dump("PostController update:",$_POST, $tags, $medias);

        $result = $post->update($id, $_POST, compact( 'tags', 'medias', 'newmedias'));

        if ($result) {
   
            $mediacontroller->upload();
            return header('Location: '.HREF_ROOT.'admin/posts');
        }
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $this->isAdmin();

        $post = new Post($this->getDB());
        $result = $post->destroy($id);

        if ($result) {
            return header('Location: '.HREF_ROOT.'admin/posts');
        }
    }
}
