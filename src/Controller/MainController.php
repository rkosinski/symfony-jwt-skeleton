<?php declare(strict_types=1);

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

class MainController extends FOSRestController
{
    public function hello(): View
    {
        return  $this->view('Hello');
    }
}