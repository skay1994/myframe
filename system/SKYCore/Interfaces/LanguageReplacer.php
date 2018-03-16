<?php

namespace SKYCore\Interfaces;

interface LanguageReplacer
{

    public function __construct(array $configs = null);

    public function getFile(string $url);

    public function getModels();

    public function getTexts();

    public function result(string $html);

}