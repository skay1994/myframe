<?php
namespace App\Apptj\Controllers\api;


use App\Apptj\Models\{
    PostMeta, Posts
};
use SKYCore\Controllers\RestController;

class Post extends RestController
{
    public function novo()
    {
        $this->type('post');

        $post = $this->post_content();

        $this->db->beginTransaction();

        $date = '';

        if(empty($post->date)){
            $date = date('Y-m-d H:i:s');
        } else {
            $date = $post->date;
        }

        try {
            $newpost = new Posts();
            $newpost->title = $post->title;
            $newpost->content = $post->content;
            $newpost->company = $this->session->company['id'];
            $newpost->user = $post->author;
            $newpost->create = $date;
            $newpost->status = $post->status;
            $newpost->flush();


            $this->db->commit();
        } catch (\Exception $e){
            $this->db->rollBack();
            throw $e;
        }

    }

    /**
     * @return array
     */
    public function getCategory()
    {
        $categories = new PostMeta();
        return $categories->findBy([
            'type' => 'category',
            'post_id' => $this->id
        ]);
    }

    /**
     * @return array
     */
    public function getTags()
    {
        $categories = new PostMeta();
        return $categories->findBy([
            'type' => 'tag',
            'post_id' => $this->id
        ]);
    }
}