<?php
/**
 * Created by PhpStorm.
 * User: wouter
 * Date: 10-5-18
 * Time: 14:24
 */
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MongoDB\Driver\ReadConcern;
use Symfony\Component\HttpFoundation\Response;

class OverviewController
{
    /**
     * @return Response
     * @Route("/")
     */
    public function Overview() : Response
    {
        return new Response("this is a test");
    }

    /**
     * @param string $searchString
     * @return Response
     * @Route("/{searchString}")
     */
    public function OverviewCatagory(string $searchString) : Response
    {
        return new Response($searchString);
    }
}