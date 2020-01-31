<?php

namespace Rmtram\Array2Tables\TestCase;

use Rmtram\Array2Tables\Creator;
use Rmtram\Array2Tables\Tables\Html\Config as HtmlConfig;
use Rmtram\Array2Tables\Tables\Markdown\Config as MarkdownConfig;
use Spatie\Snapshots\MatchesSnapshots;

class CreatorTest extends \PHPUnit\Framework\TestCase
{
    use MatchesSnapshots;

    public function providerTestHtml()
    {
        return [
            'empty' => [[]],
            'config_null' => [
                [['id' => 1, 'age' => 1]]
            ],
            'caption' => [
                [['id' => 1, 'age' => 1]],
                new HtmlConfig(['caption' => 'dummy']),
            ],
            'caption_escape_on' => [
                [['escape' => '<script>alert(1)</script>'], ['escape' => '<p>a</p>'],],
                new HtmlConfig(),
            ],
            'caption_escape_off' => [
                [['escape' => '<script>alert(1)</script>'], ['escape' => '<p>a</p>'],],
                new HtmlConfig(['escape' => false]),
            ],
            'set_tag_attributes' => [
                [['text' => 't']],
                new HtmlConfig([
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
            'attributes_escape_default' => [
                [['text' => 't']],
                new HtmlConfig([
                    'attributes' => [
                        'table'   => [
                            'id' => 'table',
                            'class' => '<script>alert(1)</script>',
                            'data-id' => 1
                        ],
                    ],
                ])
            ],
            'attributes_escape_off' => [
                [['text' => 't']],
                new HtmlConfig([
                    'attributes' => [
                        'table'   => [
                            'id' => 'table',
                            'class' => '<script>alert(1)</script>',
                            'data-id' => 1
                        ],
                    ],
                    'escape' => false
                ])
            ],
            'attributes_double_quote_escape_on' => [
                [['text' => 't']],
                new HtmlConfig([
                    'attributes' => [
                        'table'   => [
                            'id' => 'table',
                            'class' => '"<script>alert(1)</script>"',
                            'data-id' => 1
                        ]
                    ],
                ])
            ],
            'attributes_double_quote_escape_off' => [
                [['text' => 't']],
                new HtmlConfig([
                    'attributes' => [
                        'table'   => [
                            'id' => 'table',
                            'class' => '"<script>alert(1)</script>"',
                            'data-id' => 1
                        ],
                    ],
                    'escape' => false
                ])
            ],
            'diffrence_keys' => [
                [['text' => 'a'], ['text' => 'b', 'other' => 'c']]
            ],
            'array_value' => [
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

    public function providerTestMarkdown()
    {
        return [
            'escape_on' => [
                [['id' => 1, 'name' => '<p>hoge</p>']],
                new MarkdownConfig()
            ],
            'escape_off' => [
                [['id' => 1, 'name' => '<p>hoge</p>']],
                new MarkdownConfig(['escape' => false])
            ],
            'align_right' => [
                [['id' => 1, 'name' => '<p>hoge</p>']],
                new MarkdownConfig(['align' => 'right'])
            ],
            'align_center' => [
                [['id' => 1, 'name' => '<p>hoge</p>']],
                new MarkdownConfig(['align' => 'center'])
            ],
            'align_center_and_attribute_align_right' => [
                [['id' => 1, 'name' => 'a']],
                new MarkdownConfig([
                    'align' => 'center',
                    'attributesAlign' => [
                        'name' => 'right'
                    ]
                ])
            ],
            'multiple_attributes_align' => [
                [
                    ['id' => 1, 'name' => 'a', 'age' => 1],
                    ['id' => 2, 'name' => 'a', 'age' => 2],
                    ['id' => 3, 'name' => 'a', 'age' => 3],
                    ['id' => 4, 'name' => 'a', 'age' => 4]
                ],
                new MarkdownConfig([
                    'attributesAlign' => [
                        'id' => 'right',
                        'name' => 'center',
                        'age' => 'left'
                    ]
                ])
            ],
            'align_center_and_invalid_attribute_align' => [
                [['id' => 1, 'name' => 'a']],
                new MarkdownConfig([
                    'align' => 'center',
                    'attributesAlign' => [
                        'name' => '<p>hoge</p>'
                    ]
                ])
            ],
        ];
    }

    /**
     * @param $items
     * @param null $config
     * @param bool $throwable
     * @dataProvider providerTestMarkdown
     */
    public function testMarkdown($items, $config = null, $throwable = false)
    {
        try {
            $this->assertMatchesSnapshot(Creator::make($items)->markdown($config)->render());
        } catch (\Throwable $e) {
            $this->assertTrue($throwable, $e);
        }
    }

    public function providerTestAscii()
    {
        return [
            'empty' => [
                []
            ],
            'one' => [
                [
                    ['id' => 1]
                ]
            ],
            'different_attr_for_last_row' => [
                [
                    ['id' => 1],
                    ['id' => 2, 'name' => 'a']
                ]
            ],
            'different_attr_for_first_row' => [
                [
                    ['id' => 1, 'name' => 'a'],
                    ['id' => 2]
                ]
            ],
            'multibyte' => [
                [
                    ['name' => 'ああああ', 'address' => 'あああああaaa'],
                    ['name' => 'いいいいいいい', 'address' => 'いいいいいいいいiiii'],
                ]
            ]
        ];
    }

    /**
     * @dataProvider providerTestAscii
     */
    public function testAscii($items, $throwable = false)
    {
        try {
            $this->assertMatchesSnapshot(Creator::make($items)->ascii()->render());
        } catch(\Throwable $e) {
            $this->assertTrue($throwable, $e);
        }
    }
}
