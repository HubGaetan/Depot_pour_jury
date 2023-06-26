<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Media;


class MediaController extends Controller{


    public function index()
    {
        $this->isAdmin();

        $medias = (new Media($this->getDB()))->all();

        return $this->view('admin.medias.index', compact('medias'));
    }

    /**
     * Summary of Create
     * @return void
     */
    public function create()
    {
        $this->isAdmin();

        $medias = (new Media($this->getDB()))->all();

        return $this->view('admin.medias.form');
    }

    /**
     * Summary of CreateTag
     * @return void
     */
    public function createMedia()
    {
        $this->isAdmin();

        $medias = new Media($this->getDB());       

        $result = $medias->create($_POST);

      

        if ($result) {
            return header('Location:'.HREF_ROOT.'admin/medias');
        }
    }

    /**
     * Summary of edit
     * @param int $id
     * @return void
     */
    public function edit(int $id)
    {
        if(IS_DEBUG) var_dump('MediaCOntroller edit: ', $id);
        $this->isAdmin();

        $medias = (new Media($this->getDB()))->findById($id);
        
        return $this->view('admin.medias.form', compact('medias'));
    }

    /**
     * Summary of UdpateTag
     * @param int $id
     * @return void
     */
    public function update(int $id)
    {
        $this->isAdmin();

        $medias = new Media($this->getDB());

        // var_dump("PostController update:",$_POST);
       // var_dump("PostController update:",$_POST, $tags);

    

        $result = $medias->update($id, $_POST);

        
        if ($result) {
            return header('Location: '.HREF_ROOT.'admin/medias');
        }
    }

    /**
     * Summary of DelateTag
     * @param int $id
     * @return void
     */
    public function destroy(int $id)
    {
        $this->isAdmin();

        $medias = new Media($this->getDB());
        $result = $medias->destroy($id);

        if ($result) {
            return header('Location: '.HREF_ROOT.'admin/medias');
        }
    }

    public function upload()
    {
       // var_dump("MediaController upload: ", $_FILES);
      

        foreach($_FILES['image_uploads']['name'] as $filename){
            /* Choose where to save the uploaded file */
            $location = DIR_IMAGES.$filename;
        }

        /* Save the uploaded files to the local filesystem */
          /* Get the name of the uploaded file */
        foreach ($_FILES['image_uploads']['tmp_name'] as $tmp_name) {
            if (move_uploaded_file($tmp_name, $location)) {
                echo 'Success upload image';                             
            } else {
                echo 'Failure upload image';
            }
        }

        return header('Location: '.HREF_ROOT.'admin/posts');    
    }
}
