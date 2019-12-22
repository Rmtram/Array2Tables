<?php

namespace Rmtram\Array2Tables\TestCase;

use Rmtram\Array2Tables\Escape;

class EscapeTest extends \PHPUnit\Framework\TestCase
{

    public function providerTestH()
    {
        return [
            ['', ''],
            [0, 0],
            ['hoge', 'hoge'],
            ['<script>alert(1)</script>', '&lt;script&gt;alert(1)&lt;/script&gt;']
        ];
    }

    /**
     * @param $value
     * @param $expected
     * @dataProvider providerTestH
     */
    public function testH($value, $expected)
    {
        $this->assertEquals($expected, Escape::h($value));
    }

    public function providerTestD()
    {
        return [
            ['', ''],
            [0, 0],
            ['hoge', 'hoge'],
            ['<script>alert(1)</script>', '<script>alert(1)</script>'],
            ['&lt;script&gt;alert(1)&lt;/script&gt;', '<script>alert(1)</script>']
        ];
    }

    /**
     * @param $value
     * @param $expected
     * @dataProvider providerTestD
     */
    public function testD($value, $expected)
    {
        $this->assertEquals($expected, Escape::d($value));
    }
}
