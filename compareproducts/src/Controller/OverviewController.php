<?php
/**
 * Created by PhpStorm.
 * User: wouter
 * Date: 10-5-18
 * Time: 14:24
 */
namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MongoDB\Driver\ReadConcern;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class OverviewController extends Controller
{
    /**
     * @return Response
     * @Route("/")
     */
    public function Overview(EntityManagerInterface $entityManager)
    {
        $categories = $entityManager->getRepository( Category::class)->findBy(array('parent' => null));

        $title = "compareProducts - Category Overview";
        return $this->render('categories.html.twig', array(
            'title' => $title,
            'categories' => $categories,
    ));
    }

    /**
     * @return Response
     * @Route("/add")
     */
    public function AddTestCategories(EntityManagerInterface $entityManager) : Response
    {
        $basecatagory = new Category();
        $basecatagory->setName("Games");

        $xbox360 = new Category();
        $xbox360->setName("Xbox 360");

        $gamecube = new Category();
        $gamecube->setName("Gamecube");

        $xboxone = new Category();
        $xboxone->setName("Xbox One");

        $basecatagory->addCategory($xbox360);
        $basecatagory->addCategory($gamecube);
        $basecatagory->addCategory($xboxone);

        $entityManager->persist($xbox360);
        $entityManager->persist($gamecube);
        $entityManager->persist($xboxone);
        $entityManager->persist($basecatagory);

        $entityManager->flush();

        return new Response("done");
    }


    /**
     * @param string $searchString
     * @return Response
     * @Route("/{category}")
     */
    public function OverviewCatagory(EntityManagerInterface $entityManager, string $category) : Response
    {
        $currentCategory = $entityManager->getRepository( Category::class)->findOneBy(array('name' => $category));

        if(empty($currentCategory)) {
            return new Response("The category ".$category." doesn't exist");
        }

        $categories = $currentCategory->getCategories();

        $title = "compareProducts - Category Overview";
        return $this->render('categories.html.twig', array(
            'title' => $title,
            'categories' => $categories,
        ));
    }
}