<?php
/**
 * Created by PhpStorm.
 * User: wouter
 * Date: 10-5-18
 * Time: 19:50
 */

namespace App\Controller;


use App\Entity\Store;
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
     * @Route("/admin/store/remove")
     */
    public function removeStore(EntityManagerInterface $entityManager, Request $request) : Response
    {

        $toDelete = $request->request->get("remove", "");
        $store = $entityManager->getRepository(Store::class)->findOneBy(array('id' => $toDelete));
        $entityManager->remove($store);
        $entityManager->flush();

        return $this->redirectToRoute("storeAdmin");
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @Route("/admin/store/add")
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
     * @Route("/admin")
     */
    public function adminPanel() : Response
    {
        return $this->render('admin.html.twig', array());
    }
}