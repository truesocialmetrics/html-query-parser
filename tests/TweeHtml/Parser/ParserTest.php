<?php
namespace TweeHtml\Parser;
use PHPUnit_Framework_TestCase;

class ParserTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $parser = new Parser('<html><head></head><body /></html>');
    }

    public function testFindElements()
    {
        $parser = new Parser(file_get_contents(__DIR__ . '/_files/list.html'));
        $this->assertCount(3, $parser->findElements('ul li'));
        $this->assertEquals(array('<li>A</li>', '<li>B</li>', '<li>C</li>'), $parser->findElements('ul li'));
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


}