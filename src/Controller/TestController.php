<?php

namespace Drupal\table_for_json\Controller;

use Drupal\CommonsTraits\Traits\TestTrait;

class TestController
{
    use TestTrait;
    public function test()
    {
        return [
            '#type' => 'markup',
            '#markup' => 'Hello, World!',
        ];
    }

}