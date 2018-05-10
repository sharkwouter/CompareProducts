<?php
/**
 * Created by PhpStorm.
 * User: wouter
 * Date: 10-5-18
 * Time: 19:50
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/admin/store")
     */
    public function addStores() : Response
    {
        return $this->render('admin/store.html.twig', array());
    }


    /**
     * @Route("/admin")
     */
    public function adminPanel() : Response
    {
        return $this->render('admin.html.twig', array());
    }
}