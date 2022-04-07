<?php

declare(strict_types=1);

namespace App\Controller;

class Error404 implements Controller
{
    public function render(): void
    {
        echo '<h1>Page 404</h1>';
    }
}
