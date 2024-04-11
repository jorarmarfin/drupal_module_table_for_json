<?php

namespace Drupal\table_for_json\Controller;

class AdminTableForJsonController
{
    public function content()
    {
        return [
            '#type' => 'markup',
            '#markup' => 'Hello, World!',
        ];
    }

}