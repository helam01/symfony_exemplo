<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{   
    public function paginaAction(Request $request)
    {
        $list = ['Iten 01', 'Iten 02', 'Iten 03'];

        return $this->render('site/pagina.html.twig', ['list' => $list]);
    }
}
