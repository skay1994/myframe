<?php

namespace App\Apptj\Controllers\api;

use SKYCore\Controllers\RestController;
use App\Apptj\Models\Categories as ModelCategory;
use Symfony\Component\HttpFoundation\Response;

class Categories extends RestController
{
    public function novo()
    {
        $post = $this->post_content();

        $this->db->beginTransaction();

        $date = '';

        if(empty($post->date)){
            $date = date('Y-m-d H:i:s');
        } else {
            $date = $post->date;
        }

        try {

            $category = new ModelCategory();
            $category->company = $this->session->company['id'];
            $category->name = $post->name;
            $category->type = $post->type;
            $category->create = $date;
            $category->flush();

            $response = new class{
                var $success = '0';
                var $data = [];
            };

            $response->success = '1';
            $response->data = [
                'category_id' => $category->id
            ];

            $this->db->commit();

            $this->sendWithJson(Response::HTTP_OK, $response);
        } catch (\Exception $e){
            $this->db->rollBack();
            throw $e;
        }
    }
}