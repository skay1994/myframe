<?php

namespace App\Apptj\Controllers\api;


use App\Apptj\Models\TransRecurrence;
use App\Apptj\Models\Users;
use App\Apptj\Traits\TransationsHelpers;
use SKYCore\Controllers\RestController;
use Symfony\Component\HttpFoundation\Response;

class FinancialRecurrence extends RestController
{
    use TransationsHelpers;

    public function table()
    {
        $this->type('post');

        $qb = TransRecurrence::getQueryBuilder('t');

        $post = $this->post_content();

        $data_tables = new class{
            var $draw;
            var $recordsTotal;
            var $recordsFiltered;
            var $data = [];
        };

        $data_tables->recordsTotal = count(TransRecurrence::getAllDataBy([
            'company' => $this->session->company['id']
        ]));

        $data_tables->draw = (int)$post->draw;

        $qb->where('t.company = :company');

        $query_params = [
            'company' => $this->session->company['id']
        ];

        if(!empty($post->search)){

            $qb->andWhere('t.id LIKE :value OR t.name LIKE :value OR t.user LIKE :value OR t.type LIKE :value OR t.currency LIKE :value OR t.value LIKE :value OR t.create LIKE :value');
            $query_params['value'] = (string) '%'.$post->search['value'].'%';
        }

        $qb->setParameters($query_params);

        $column = strip_tags($post->columns[$post->order[0]['column']]['name']);
        $directional = $post->order[0]['dir'];

        if($directional === 'asc'){
            $directional = 'ASC';
        } elseif($directional === 'desc') {
            $directional = 'DESC';
        }

        $colums = [
            'id',
            'name',
            'type',
            'currency',
            'value',
            'create'
        ];

        if(array_search($column,$colums)){
            $qb->orderBy('t.'.$column,$directional);
        }

        $qb->setFirstResult($post->start);
        $qb->setMaxResults($post->length);
        $data = $qb->getQuery()->getResult();

        $data_tables->recordsFiltered = count($data);

        foreach ($data as $value){
            /** @var TransRecurrence $value */

            $values = [
                $value->id,
                utf8_encode($value->name),
                $value->value,
                $value->currency,
                utf8_encode(Users::load($value->user)->name),
                $this->tType($value->type),
                $value->date_recurrence->format('d/m/y H:i'),
                'DT_RowClass' => $this->tableColor($value->type)
            ];

            $data_tables->data[] = $values;
        }

        $this->sendWithJson(Response::HTTP_OK,\GuzzleHttp\json_encode($data_tables,JSON_UNESCAPED_UNICODE),true);

    }
}