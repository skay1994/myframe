<?php

namespace App\Apptj\Traits;


use App\Apptj\Models\TransRecurrence;
use SKYCore\Traits\Helpers\LoadInstances;

trait Recurrence
{
    use LoadInstances;

    public function new_recurrence($item)
    {
        $this->db->beginTransaction();

        try{
            $recurrence = new TransRecurrence();
            $recurrence->company = $this->session->company['id'];
            $recurrence->user = $this->session->user['id'];
            $recurrence->type = $item->type;
            $recurrence->name = utf8_decode($item->name);
            $recurrence->currency = $item->currency;
            $recurrence->value = $item->value;
            $recurrence->date_recurrence = $item->date;
            $recurrence->create = new \DateTime(date('Y-m-d H:i'));
            $recurrence->comment = $item->comment;
            $recurrence->status = '1';
            $recurrence->flush();

            $this->db->commit();

        } catch (\Exception $e){
            $this->db->rollBack();
            throw $e;
        }
    }
}