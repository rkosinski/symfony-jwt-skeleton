<?php declare(strict_types=1);

namespace App\Controller\Api;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class ProductController extends FOSRestController
{
    public function products(): View
    {
        return $this->view(['Apple', 'Banana', 'Lemon']);
    }
}
