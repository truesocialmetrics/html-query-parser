<?php
namespace TweeHtml\Parser;
use Zend\Dom\Query;

class Parser
{
    protected $html = '';

    public function __construct($html) 
    {
        $this->setHtml($html);
    }

    public function setHtml($html)
    {
        $html = @mb_convert_encoding($html, 'UTF-8', mb_detect_encoding($html));
        $html = @mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $html = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />' . $html;
        $this->html = $html;
    }

    public function getHtml()
    {
        return $this->html;
    }

    public function findElements($pattern)
    {
        try {
            $items = array();
            $query = new Query($this->getHtml(), 'utf-8');
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
            $query = new Query($this->getHtml(), 'utf-8');
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
            $query = new Query($this->getHtml(), 'utf-8');
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