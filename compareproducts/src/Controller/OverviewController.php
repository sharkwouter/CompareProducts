<?php
/**
 * Created by PhpStorm.
 * User: wouter
 * Date: 10-5-18
 * Time: 14:24
 */
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductPrice;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use MongoDB\Driver\ReadConcern;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class OverviewController extends Controller
{
    /**
     * @return Response
     * @Route("/", name="overview")
     */
    public function Overview(EntityManagerInterface $entityManager)
    {
        $categories = $entityManager->getRepository( Category::class)->findBy(array('parent' => null));

        $title = "Category Overview";
        return $this->render('categories.html.twig', array(
            'title' => $title,
            'categories' => $categories,
    ));
    }

    /**
     * @return Response
     * @Route("/addcategories")
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
     * @return Response
     * @Route("/addgames")
     */
    public function AddTestGames(EntityManagerInterface $entityManager) : Response
    {
        $xbox360 = $entityManager->getRepository(Category::class)->findOneBy(array('name' => "Xbox 360"));
        $rr = new Product();
        $rr->setName("Ridge Racer 6");
        $rr->setCategory($xbox360);
        $rr->setEan("5030930049607");

        $driver = new Product();
        $driver->setName("Driver San Francisco");
        $driver->setCategory($xbox360);
        $driver->setEan("3307215673225");

        $entityManager->persist($rr);
        $entityManager->persist($driver);

        $entityManager->flush();

        return new Response("done");
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param string $productId
     * @return Response
     * @Route("product/{productId}")
     */
    public function OverviewProduct(EntityManagerInterface $entityManager, string $productId){
        $product = $entityManager->getRepository( Product::class)->findOneBy(array('id' => $productId));
        $productPrices = $entityManager->getRepository(ProductPrice::class)->findBy(array('product' => $product));
        $title = $product->getName();
        return $this->render('product.html.twig', array(
            'title' => $title,
            'product' => $product,
            'productPrices' => $productPrices,
        ));
    }

    /**
     * @param string $searchString
     * @return Response
     * @Route("/category/{categoryId}")
     */
    public function OverviewCatagory(EntityManagerInterface $entityManager, int $categoryId) : Response
    {
        $currentCategory = $entityManager->getRepository( Category::class)->findOneBy(array('id' => $categoryId));

        if(empty($currentCategory)) {
            return new Response("The category ".$categoryId." doesn't exist");
        }

        $categories = $currentCategory->getCategories();
        $products = $currentCategory->getProducts();
        $parentCategory = $currentCategory->getParent();

        $title = $currentCategory->getName();
        return $this->render('categories.html.twig', array(
            'title' => $title,
            'categories' => $categories,
            'products' => $products,
            'parentCategory' => $parentCategory,
        ));
    }
}