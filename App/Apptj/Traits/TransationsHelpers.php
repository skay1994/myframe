<?php

namespace App\Apptj\Traits;


trait TransationsHelpers
{
    public function tType(int $type)
    {
        $value = '';

        if($type === 1){
            $value = 'Crédito';
        } elseif($type === 0) {
            $value = 'Debito';
        }

        return $value;
    }

    public function tableColor(int $type)
    {
        $value = '';

        if($type === 1){
            $value = 'alert-success';
        } elseif($type === 0) {
            $value = 'alert-danger';
        }

        return $value;
    }
}