<?php

namespace App\Apptj\Controllers\api;


use App\Apptj\Models\{
    FinancialTransactions,TransRecurrence,Users
};
use App\Apptj\Traits\{
    Recurrence,TransationsHelpers
};
use SKYCore\Controllers\RestController;
use Symfony\Component\HttpFoundation\Response;

class Financial extends RestController
{
    use Recurrence,TransationsHelpers;

    public function new()
    {
        $this->type('post');
        $post = $this->post_content();

        $response = new class{
            var $status = '0';
        };

        if(empty($post->value)){
            $this->lang->load('financial','strings','app');

            $response->error[] = $this->lang->app('financial','empty_fields','value');

            $this->sendWithJson(Response::HTTP_OK,json_encode($response,JSON_UNESCAPED_UNICODE),true);
        }

        if($post->currency === 'BRL'){
            $post->value = $value = str_replace(['.',','],['','.'],$post->value);
        }

        if(empty($post->date)){
            $post->date = date('Y-m-d H:i');
        }

        $post->date = new \DateTime($post->date);

        $this->db->beginTransaction();

        try {

            $financial = new FinancialTransactions();
            $financial->name = utf8_decode($post->name);
            $financial->company = $this->session->company['id'];
            $financial->type = $post->type;
            $financial->currency = $post->currency;
            $financial->user = $this->session->user['id'];
            $financial->value = $value;
            $financial->create = $post->date;
            $financial->comment = $post->comment;

            if(isset($post->recurrence)){
                $financial->recurrence = '1';
                $this->new_recurrence($post);
            } else {
                $financial->recurrence = '0';
            }

            $financial->flush();

            $response->status = '1';
            $response->transaction_id = $financial->id;

            $this->db->commit();

            $this->sendWithJson(Response::HTTP_OK,$response);

        } catch (\Exception $e){

            $this->db->rollBack();

            $response->error = $e->getMessage();

            $this->sendWithJson(Response::HTTP_OK,$response);
        }

    }

    public function graphs($type,$year = null)
    {
        $qb = FinancialTransactions::getQueryBuilder('t');

        $dados = array(
            'labels' => array(
                'Jan', 'Fev', 'Mar','Abr','Maio','Jun','Jul','Ago','Set','Out','Nov','Des'
            ),
            'labels_complete' => array(
                'Janeiro', 'Fevereiro', 'Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Desembro'
            ));

        $reponse = new class{
            public $status = '0';
        };

        $year = date('Y') ?? $year;

        switch ($type){
            case 'general':

                $credit = [];
                $debit = [];

                for ($i = 1; $i <= 12; $i++){
                    if($i <= 9){
                        $month = '0'.$i;
                    } else {
                        $month = $i;
                    }

                    $date = '%'.$year.'-'.$month.'%';

                    $queryCredit = $qb->where("t.company = :id AND t.create LIKE :date AND t.type = '1'")
                        ->setParameters([
                            'id' => $this->session->company['id'],
                            'date' => $date
                        ])
                        ->getQuery()->getResult();

                    if($queryCredit){
                        $total = 0;

                        foreach ($queryCredit as $value){
                            /** @var FinancialTransactions $value */
                            if($value->currency !== 'BRL'){
                                $guzzle = new \GuzzleHttp\Client();
                                $conversion = $guzzle->get("https://api.vitortec.com/currency/converter/v1.2/?from={$value->currency}&to=BRL&value={$value->value}");
                                $content = \GuzzleHttp\json_decode($conversion->getBody()->getContents());

                                if($content->status){
                                    $total += $content->data->resultSimple;
                                } else {
                                    $total += $value->value;
                                }
                            } else {
                                $total += $value->value;
                            }
                        }

                        $credit[] = $total;
                    } else {
                        $credit[] = 0;
                    }

                    $queryDebit = $qb->where("t.company = :id AND t.create LIKE :date AND t.type = '0'")
                        ->setParameters([
                            'id' => $this->session->company['id'],
                            'date' => $date
                        ])
                        ->getQuery()->getResult();

                    if($queryDebit){
                        $total = 0;

                        foreach ($queryDebit as $value){
                            /** @var FinancialTransactions $value */
                            if($value->currency !== 'BRL'){
                                $guzzle = new \GuzzleHttp\Client();
                                $conversion = $guzzle->get("https://api.vitortec.com/currency/converter/v1.2/?from={$value->currency}&to=BRL&value={$value->value}");
                                $content = \GuzzleHttp\json_decode($conversion->getBody()->getContents());

                                if($content->status){
                                    $total += $content->data->resultSimple;
                                } else {
                                    $total += $value->value;
                                }
                            } else {
                                $total += $value->value;
                            }
                        }

                        $debit[] = $total;
                    } else {
                        $debit[] = 0;
                    }
                }

                $dados['datasets'][] = array(
                    'type' => 'bar',
                    'label' => 'Ganhos',
                    'label2' => ' Ganhos',
                    'data' => $credit,
                    'backgroundColor' => '#257725'
                );

                $dados['datasets'][] = array(
                    'type' => 'bar',
                    'label' => 'Despesas',
                    'label2' => ' Despesas',
                    'data' => $debit,
                    'backgroundColor' => '#c93c3c'
                );

                break;
            case 'debit':
                $debit = [];

                for ($i = 1; $i <= 12; $i++){
                    if($i <= 9){
                        $month = '0'.$i;
                    } else {
                        $month = $i;
                    }

                    $date = '%'.$year.'-'.$month.'%';

                    $queryDebit = $qb->where("t.company = :id AND t.create LIKE :date AND t.type = '0'")
                        ->setParameters([
                            'id' => $this->session->company['id'],
                            'date' => $date
                        ])
                        ->getQuery()->getResult();

                    if($queryDebit){
                        $total = 0;

                        foreach ($queryDebit as $value){
                            /** @var FinancialTransactions $value */
                            if($value->currency !== 'BRL'){
                                $guzzle = new \GuzzleHttp\Client();
                                $conversion = $guzzle->get("https://api.vitortec.com/currency/converter/v1.2/?from={$value->currency}&to=BRL&value={$value->value}");
                                $content = \GuzzleHttp\json_decode($conversion->getBody()->getContents());

                                if($content->status){
                                    $total += $content->data->resultSimple;
                                } else {
                                    $total += $value->value;
                                }
                            } else {
                                $total += $value->value;
                            }
                        }

                        $debit[] = $total;
                    } else {
                        $debit[] = 0;
                    }
                }

                $dados['datasets'][] = array(
                    'type' => 'line',
                    'label' => 'Despesas',
                    'label2' => ' Despesas',
                    'data' => $debit,
                    'backgroundColor' => 'rgba(255,255,255,0)',
                    'borderColor' => '#c12a2a',
                    'pointBorderColor' => '#e81919',
                    'pointBackgroundColor' => '#e81919',
                );
                break;
            case 'credit':
                $credit = [];

                for ($i = 1; $i <= 12; $i++) {
                    if ($i <= 9) {
                        $month = '0' . $i;
                    } else {
                        $month = $i;
                    }

                    $date = '%' . $year . '-' . $month . '%';

                    $queryCredit = $qb->where("t.company = :id AND t.create LIKE :date AND t.type = '1'")
                        ->setParameters([
                            'id' => $this->session->company['id'],
                            'date' => $date
                        ])
                        ->getQuery()->getResult();

                    if ($queryCredit) {
                        $total = 0;

                        foreach ($queryCredit as $value) {
                            /** @var FinancialTransactions $value */
                            if ($value->currency !== 'BRL') {
                                $guzzle = new \GuzzleHttp\Client();
                                $conversion = $guzzle->get("https://api.vitortec.com/currency/converter/v1.2/?from={$value->currency}&to=BRL&value={$value->value}");
                                $content = \GuzzleHttp\json_decode($conversion->getBody()->getContents());

                                if ($content->status) {
                                    $total += $content->data->resultSimple;
                                } else {
                                    $total += $value->value;
                                }
                            } else {
                                $total += $value->value;
                            }
                        }

                        $credit[] = $total;
                    } else {
                        $credit[] = 0;
                    }
                }

                $dados['datasets'][] = array(
                    'type' => 'line',
                    'label' => 'Ganhos',
                    'label2' => ' Ganhos',
                    'data' => $credit,
                    'backgroundColor' => 'rgba(255,255,255,0)',
                    'borderColor' => '#257725',
                    'pointBorderColor' => '#29d829',
                    'pointBackgroundColor' => '#29d829',
                );
                break;
            case 'recurrence_credit':
                $credit = [];

                $qb = $this->db->getQueryBuilder();

                $qb = $qb->select('t')
                    ->from(TransRecurrence::class,'t');

                for ($i = 1; $i <= 12; $i++) {
                    if ($i <= 9) {
                        $month = '0' . $i;
                    } else {
                        $month = $i;
                    }

                    $date = '%' . $year . '-' . $month . '%';

                    $queryCredit = $qb->where("t.company = :id AND t.date_recurrence LIKE :date AND t.type = '1'")
                        ->setParameters([
                            'id' => $this->session->company['id'],
                            'date' => $date
                        ])
                        ->getQuery()->getResult();

                    if ($queryCredit) {
                        $total = 0;

                        foreach ($queryCredit as $value) {
                            /** @var TransRecurrence $value */
                            if ($value->currency !== 'BRL') {
                                $guzzle = new \GuzzleHttp\Client();
                                $conversion = $guzzle->get("https://api.vitortec.com/currency/converter/v1.2/?from={$value->currency}&to=BRL&value={$value->value}");
                                $content = \GuzzleHttp\json_decode($conversion->getBody()->getContents());

                                if ($content->status) {
                                    $total += $content->data->resultSimple;
                                } else {
                                    $total += $value->value;
                                }
                            } else {
                                $total += $value->value;
                            }
                        }

                        $credit[] = $total;
                    } else {
                        $credit[] = 0;
                    }
                }

                $dados['datasets'][] = array(
                    'type' => 'line',
                    'label' => 'Ganhos Recorrentes',
                    'label2' => ' Ganhos',
                    'data' => $credit,
                    'backgroundColor' => 'rgba(255,255,255,0)',
                    'borderColor' => '#257725',
                    'pointBorderColor' => '#29d829',
                    'pointBackgroundColor' => '#29d829',
                );
                break;
            case 'recurrence_debit':
                $debit = [];

                $qb = $this->db->getQueryBuilder();

                $qb = $qb->select('t')
                    ->from(TransRecurrence::class,'t');

                for ($i = 1; $i <= 12; $i++){
                    if($i <= 9){
                        $month = '0'.$i;
                    } else {
                        $month = $i;
                    }

                    $date = '%'.$year.'-'.$month.'%';

                    $queryDebit = $qb->where("t.company = :id AND t.date_recurrence LIKE :date AND t.type = '0'")
                        ->setParameters([
                            'id' => $this->session->company['id'],
                            'date' => $date
                        ])
                        ->getQuery()->getResult();

                    if($queryDebit){
                        $total = 0;

                        foreach ($queryDebit as $value){
                            /** @var TransRecurrence $value */
                            if($value->currency !== 'BRL'){
                                $guzzle = new \GuzzleHttp\Client();
                                $conversion = $guzzle->get("https://api.vitortec.com/currency/converter/v1.2/?from={$value->currency}&to=BRL&value={$value->value}");
                                $content = \GuzzleHttp\json_decode($conversion->getBody()->getContents());

                                if($content->status){
                                    $total += $content->data->resultFull;
                                } else {
                                    $total += $value->value;
                                }
                            } else {
                                $total += $value->value;
                            }
                        }

                        $debit[] = $total;
                    } else {
                        $debit[] = 0;
                    }
                }

                $dados['datasets'][] = array(
                    'type' => 'line',
                    'label' => 'Despesas Recorrentes',
                    'label2' => ' Despesas',
                    'data' => $debit,
                    'backgroundColor' => 'rgba(255,255,255,0)',
                    'borderColor' => '#c12a2a',
                    'pointBorderColor' => '#e81919',
                    'pointBackgroundColor' => '#e81919',
                );
                break;
        }

        $reponse->data = $dados;

        $this->sendWithJson(Response::HTTP_OK,$reponse);

    }

    public function history()
    {
        $this->type('post');

        $post = $this->post_content();

        $data_tables = new class{
            var $draw;
            var $recordsTotal;
            var $recordsFiltered;
            var $data = [];
        };

        $data_tables->recordsTotal = count(FinancialTransactions::getAllDataBy([
            'company' => $this->session->company['id']
        ]));

        $data_tables->draw = (int)$post->draw;

        $qb = FinancialTransactions::getQueryBuilder('t');
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

            /** @var FinancialTransactions $value */
            $recurrence = null;

            if($value->recurrence === 1){
                $recurrence = 'Sim';
            } elseif($value->recurrence === 0) {
                $recurrence = 'Não';
            }

            $values = [
                $value->id,
                utf8_encode($value->name),
                $value->value,
                $value->currency,
                utf8_encode(Users::load($value->user)->name),
                $recurrence,
                $this->tType($value->type),
                $value->create->format('d/m/y H:i'),
                'DT_RowClass' => $this->tableColor($value->type)
            ];

            $data_tables->data[] = $values;
        }

        $this->sendWithJson(Response::HTTP_OK,\GuzzleHttp\json_encode($data_tables,JSON_UNESCAPED_UNICODE),true);
    }
}