<?php

$C['custom_anchor_core_class'] = false;

$GA['system_start'] = function (\SKYCore\load $loader, \SKYCore\configuration $config, \SKYCore\Anchor $anchor){
    function testedaporra(){
        var_dump($_SERVER);
    };

    $anchor->addCallback('system','anchor_start','testedaporra',new SKYCore\Anchors\system(),10);
};

$C['anchor_reference'] = [];