<?php
namespace SKYCore\Templates;

class Link
{
    private $tag;

    public function __construct(array $dados)
    {
        $tag = '<link ';
        if(isset($dados['href'])){
            $tag .= ' href="'.$dados['href'].'"';
        }

        if(isset($dados['hreflang'])){
            $tag .= ' hreflang="'.$dados['hreflang'].'"';
        }

        if(isset($dados['media'])){
            $tag .= ' media="'.$dados['media'].'"';
        }

        if(isset($dados['rel'])){
            $tag .= ' rel="'.$dados['rel'].'"';
        }

        if(isset($dados['type'])){
            $tag .= ' type="'.$dados['type'].'"';
        }

        if(isset($dados['sizes'])  && isset($dados['rel'])){
            if($dados['rel'] == 'icon')
                $tag .= ' sizes="'.$dados['sizes'].'"';
        }

        $tag .= '>';

        $this->tag = $tag;
    }

    public function getTag():string {
        return $this->tag;
    }

}