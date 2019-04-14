<?php

namespace App\Transformers;

abstract class Transformer
{

    /**
    * Transform collection of items
    *
    * @param $items
    * @return Array 
    */
    public function transformCollection(array $items)
    {
    	return array_map([$this, 'transform'], $items);
    }

    /**
    * Transform the item
    *
    * @param $item
    * @return Array 
    */
    public abstract function transform($item);
}