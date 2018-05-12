<?php
/**
 * Created by PhpStorm.
 * User: wouter
 * Date: 10-5-18
 * Time: 19:50
 */

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Store;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    /**
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @Route("/admin/store/remove", name="removeStore")
     */
    public function removeStore(EntityManagerInterface $entityManager, Request $request) : Response
    {

        $toDelete = $request->request->get("remove", "");
        $store = $entityManager->getRepository(Store::class)->findOneBy(array('id' => $toDelete));
        $entityManager->remove($store);
        $entityManager->flush();

        return $this->redirectToRoute("storeAdmin", array('message' => "The things was removed?"));
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @Route("/admin/store/add", name="addStore")
     */
    public function addStore(EntityManagerInterface $entityManager, Request $request) : Response
    {
        $newName = $request->request->get("name", "");
        $newUrl = $request->request->get("url", "");

        if(substr($newUrl, -1 ) != "/"){
            $newUrl=$newUrl."/";
        }

        if(!empty($newUrl) && !empty($newUrl)){
            $store = new Store();
            $store->setName($newName);
            $store->setUrl($newUrl);
            $entityManager->persist($store);
            $entityManager->flush();
        }

        return $this->redirectToRoute("storeAdmin");
    }

    /**
     * @Route("/admin/store", name="storeAdmin")
     */
    public function overviewStores(EntityManagerInterface $entityManager) : Response
    {
        $stores = $entityManager->getRepository(Store::class)->findAll();
        return $this->render('admin/store.html.twig', array(
            'stores' => $stores,
        ));
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param CategoryRepository $repository
     * @param Request $request
     * @return Response
     * @Route("/admin/category/remove", name="removeCatagory")
     */
    public function removeCategory(EntityManagerInterface $entityManager, CategoryRepository $repository, Request $request) : Response
    {
        $toDelete = $request->request->get("remove", "");

        $message = "Deleted the Category with id ". $toDelete;

        if(!empty($toDelete)) {
            $category = $repository->findOneById($toDelete);

            if(count($category->getCategories()) == 0) {
                if(count($category->getProducts()) == 0) {
                    $entityManager->remove($category);
                    $entityManager->flush();
                } else {
                    $message = "Couldn't delete category, it has products";
                }
            } else {
                $message = "Couldn't delete category, it has children";
            }
        }

        return $this->redirectToRoute("categoryAdmin", array('message' => $message));
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @Route("/admin/category/add", name="addCategory")
     */
    public function addCategory(EntityManagerInterface $entityManager, CategoryRepository $repository, Request $request) : Response
    {
        $newName = $request->request->get("name", "");
        $newParent = $request->request->get("parent", -1);

        if(!empty($newName)) {
            $newCategory = new Category();
            $newCategory->setName($newName);

            if($newParent != -1){
                $parent = $repository->findOneById($newParent);
                $newCategory->setParent($parent);
            }

            $entityManager->persist($newCategory);
            $entityManager->flush();
        }
        return $this->redirectToRoute("categoryAdmin");
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @Route("/admin/category", name="categoryAdmin")
     */
    public function overviewCategory(CategoryRepository $categoryRepository) : Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('admin/category.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * @Route("/admin")
     */
    public function adminPanel() : Response
    {
        return $this->render('admin.html.twig', array());
    }
}