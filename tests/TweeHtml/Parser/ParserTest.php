<?php
namespace TweeHtml\Parser;
use PHPUnit_Framework_TestCase;

class ParserTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $parser = new Parser('<html><head></head><body /></html>');
        $this->assertEquals('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><html><head></head><body /></html>', $parser->getHtml());
    }

    public function testFindElements()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/list.html'));
        $this->assertCount(3, $parser->findElements('ul li'));
        $this->assertEquals(array('<li>A</li>', '<li>B</li>', '<li>C</li>'), $parser->findElements('ul li'));
    }

    public function testFindElementsChinese()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/list-chinese.html'));
        $items = $parser->findElements('span.share-body span.commentary');
        $this->assertCount(10, $items);
        $chinese = strip_tags($items[2]);
        $chinese = mb_substr($chinese, 0, 5, 'utf-8');
        $this->assertEquals('英国是在欧', $chinese);
    }

    public function testFindElementsNonExist()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/list.html'));
        $this->assertCount(0, $parser->findElements('strong'));
    }

    public function testFindElement()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/list.html'));
        $this->assertEquals('<li>A</li>', $parser->findElement('ul li')); 
    }

    public function testFindElementNonExist()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/list.html'));
        $this->assertEquals('', $parser->findElement('strong')); 
    }

    public function testFindElementAttribute()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/attribute.html'));
        $this->assertEquals('#item', $parser->findElementAttribute('strong', 'data-src'));
    }

    public function testFindElementsBroken()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/broken.html'));
        $this->assertEquals(array(), $parser->findElements('ul li')); 
    }

    public function testFindElementBroken()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/broken.html'));
        $this->assertNull($parser->findElement('ul li')); 
    }

    public function testFindElementAttributeBroken()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/broken.html'));
        $this->assertNull($parser->findElementAttribute('ul li', 'data-src')); 
    }

}