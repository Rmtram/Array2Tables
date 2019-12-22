<?php

namespace Rmtram\Array2Tables\TestCase;

use Rmtram\Array2Tables\Creator;
use Rmtram\Array2Tables\Tables\Html\Config;
use Spatie\Snapshots\MatchesSnapshots;

class CreatorTest extends \PHPUnit\Framework\TestCase
{
    use MatchesSnapshots;

    public function providerTestHtml()
    {
        return [
            [[]],
            [
                [['id' => 1, 'age' => 1]]
            ],
            [
                [['id' => 1, 'age' => 1]],
                new Config(['caption' => 'dummy']),
            ],
            [
                [['escape' => '<script>alert(1)</script>'], ['escape' => '<p>a</p>'],],
                new Config(),
            ],
            [
                [['escape' => '<script>alert(1)</script>'], ['escape' => '<p>a</p>'],],
                new Config(['escape' => false]),
            ],
            [
                [['text' => 't']],
                new Config([
                    'attributes' => [
                        'table'   => ['id' => 'table', 'class' => 'table', 'data-id' => 1],
                        'thead'   => ['class' => 'thead'],
                        'tbody'   => ['class' => 'tbody'],
                        'th'      => ['class' => 'th'],
                        'td'      => ['class' => 'td'],
                        'caption' => ['class' => 'caption'],
                    ],
                    'caption' => 'dummy'
                ])
            ],
            [
                [['text' => 't']],
                new Config([
                    'attributes' => [
                        'table'   => ['id' => 'table', 'class' => '<script>alert(1)</script>', 'data-id' => 1],
                    ],
                ])
            ],
            [
                [['text' => 't']],
                new Config([
                    'attributes' => [
                        'table'   => ['id' => 'table', 'class' => '<script>alert(1)</script>', 'data-id' => 1],
                    ],
                    'escape' => false
                ])
            ],
            [
                [['text' => 't']],
                new Config([
                    'attributes' => [
                        'table'   => ['id' => 'table', 'class' => '"<script>alert(1)</script>"', 'data-id' => 1],
                    ],
                ])
            ],
            [
                [['text' => 't']],
                new Config([
                    'attributes' => [
                        'table'   => ['id' => 'table', 'class' => '"<script>alert(1)</script>"', 'data-id' => 1],
                    ],
                    'escape' => false
                ])
            ],
            [
                [['text' => 'a'], ['text' => 'b', 'other' => 'c']]
            ],
            [
                [['text' => ['a', 'b']]], null, true
            ]
        ];
    }

    /**
     * @param $items
     * @param $config
     * @param bool $throwable
     * @dataProvider providerTestHtml
     */
    public function testHtml($items, $config = null, bool $throwable = false)
    {
        try {
            $this->assertMatchesSnapshot(Creator::make($items)->html($config)->render());
        } catch (\Throwable $e) {
            $this->assertTrue($throwable, $e);
        }
    }
}
