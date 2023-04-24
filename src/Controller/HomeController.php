<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AppListTable;
use App\Entity\StockTable;
use App\Model\HomeModel;
use App\Services\HomeService;
use Doctrine\ORM\EntityManagerInterface;



use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{


    /**
     * Instance of Entity Manager interface
     * 
     * @var EntityManagerInterface $em 
     */
    private EntityManagerInterface $em;

    /**
     * Constructor is used to initilize entity manager variabe.
     * 
     * @param object $em 
     * Store the object of EntityManagerInterface Class.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Loads list of stock present in db.
     * 
     * @Route("/home", name="home_page_route")
     * 
     * @param EntityManagerInterFace $entityManager
     * Instance of EntityManagerInterFace
     * 
     * @param Request $request
     * Instance of Request
     * 
     * @return  Response
     * Returns list of available stocks with the response.
     * 
     */
    public function home(EntityManagerInterface $entityManager): Response
    {
        $stock_list_repo = $entityManager->getRepository(StockTable::class);

        //list of all available stocks
        $stock_list = $stock_list_repo->findAll();

        //list of all stocks added by the user.
        $stock_list_user = $stock_list_repo->findBy(['created_by' => 'Bishal@b.com']);

        return $this->render('home/home_page.html.twig',  ['stock_list' => $stock_list, 'stock_list_user' => $stock_list_user]);
    }

    /**
     * Navigate to update page.
     * 
     * @Route("/update_stock_page{stock_id}", name="update_stock_page_route")
     * 
     * @param $stock_id
     */
    public function updateStock($stock_id)
    {
        //...


        return $this->render('home/update_stock.html.twig',  ['stock_id' => $stock_id]);
    }


    /**
     * Naviate to add stock page and add new stock in db
     * 
     * @Route("/add_stock", name="add_stock_page_route")
     * 
     * @param Request $request
     * Instance of request object.
     * 
     */
    public function AddStockPage(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $stock = new StockTable();
            $stock->setStockName($request->request->get('name'));
            $stock->setStockPrice($request->request->get('price'));
            $stock->setCreatedBy($_COOKIE['uid']);
            $stock->setLastUpdate("24/04/2023");
            $this->em->persist($stock);
            if ($this->em->flush() == null) {
                $result['status'] = "success";
                $result['message'] = "Stock created successfully";
                setCookie('uid', $request->request->get('email'));
            } else {
                $result['status'] = "failed";
                $result['message'] = "stock creation failed";
            }
            return json_encode($result);
        }

        return $this->render('home/add_stock.html.twig');
    }
}
