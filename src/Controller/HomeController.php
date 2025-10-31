<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/', name: 'app_home')]
    public function __invoke(): RedirectResponse
    {
        return new RedirectResponse('/task/');
    }
}
