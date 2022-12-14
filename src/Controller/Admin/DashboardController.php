<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        $url = $this->adminUrlGenerator->setController(ProductsCrudController::class)->generateUrl();

     return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('HoopsLife');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('HoopsLife');

        yield MenuItem::subMenu('Categories')->setSubItems([
            MenuItem::linkToCrud('ajouter une categories', 'fas fa-list', Categories::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('afficher categories', 'fas fa-eye', Categories::class)
        ]);

        yield MenuItem::subMenu('produits')->setSubItems([
            MenuItem::linkToCrud('ajouter un produit', 'fas fa-list', Products::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('afficher produits', 'fas fa-eye', Products::class)
        ]);




    }
}
