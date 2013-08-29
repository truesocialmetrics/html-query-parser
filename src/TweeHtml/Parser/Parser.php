<?php
namespace TweeHtml\Parser;
use Zend\Dom\Query;

class Parser
{
    protected $html = '';

    public function __construct($html) 
    {
        $this->html = $html;
    }

    public function findElements($pattern)
    {
        try {
            $items = array();
            $query = new Query($this->html);
            $list = $query->execute($pattern);
            foreach ($list as $item) {
                $items[] = $list->getDocument()->saveXml($item);
            }
            return $items;
        } catch (\Exception $e) {
            return array();
        }
    }

    public function findElement($pattern)
    {
        try {
            $query = new Query($this->html);
            $list = $query->execute($pattern);
            if (!count($list)) {
                return null;
            }
            return $list->getDocument()->saveXml($list->rewind());
        } catch (\Exception $e) {
            return null;
        }
    }

    public function findElementAttribute($pattern, $attribute)
    {
        try {
            $query = new Query($this->html);
            $list = $query->execute($pattern);
            if (!count($list)) {
                return null;
            }
            return $list->rewind()->getAttribute($attribute);
        } catch (\Exception $e) {
            return null;
        }
    }
}