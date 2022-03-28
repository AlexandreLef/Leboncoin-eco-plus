<?php

namespace App\Controller;

use App\DTO\ProductDto;
use App\DTO\SearchDto;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController {

    private function getExtension($mimeType): string {
        if ($mimeType == 'image/png') return '.png';
        else return '';
    }

    #[Route('/product/list', name: 'product_list')]
    public function list(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $products = $productRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var SearchDto $product */
            $searchDto = $form->getData();
        }

        return $this->render('product/list.html.twig', ['products' => $products, 'categories' => $categoryRepository->findAll(), 'total' => count($products)]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/product/add', name: 'product_add')]
    public function add(Request $request, EntityManagerInterface $doctrine, CategoryRepository $categoryRepository): Response {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ProductDto $product */
            $productDto = $form->getData();

            $product = new Product();
            $product->setFromDto($productDto);

            $doctrine->persist($product);
            $doctrine->flush();

            $images = $productDto->getImages();
            foreach($images as $i => $image) {
                $imageName = './assets/img/products/' . $product->getId() . '/';
                $image->move($imageName, $i . $this->getExtension($image->getMimeType()));
            }

            $doctrine->persist($product);
            $doctrine->flush();
        }

        return $this->render('product/add.html.twig', ['form' => $form->createView(), 'categories' => $categoryRepository->findAll()]);
    }
}































/**
 * TODO: Feed the patate
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%/%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&##%%%&(+//#&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%#////////////&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&///////////#&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&%(/////%&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%##&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%///#%////%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
%%%%#/////////%%%%%%%%%.....%%%%%%%%%%%%%%%%%....%%%%%%%%%%%%%%%%%////(&%#//%%%%
%%%%%%%(////#&%%%%%...........%%%%%%%%%%%...........%%%%%%%%%%%%%#///////////&%%
%%%%%%%%%%%%%%%%%...............%%%%%%...............%%%%%%%%%%%%%%/////////#%%%
%%%%%%%%%%%%%%%%......................................%%%%%%%%%%%%%%%///(&%%%%%%
%%%%%%%%%%%%%%..........................................%%%%%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%%%%..............................................//%%%%%%%%%%%%%%%%%%%%
%%%%%%%%%...............................................+/////...%%%%%%%%%%%%%%%
%%%%%%%................................................+/////...////%%%%%%%%%%%%
%%%%%%..,&&&%.........................*.................///,.../////..%%%%%%%%%%
%%%%...#&%&&&,....................,&&&&&%&.....................///,...//%%%%%%%%
%%%%...&&&&&&....&&..##..,&.......&&%&&&&&*.........................+////%%%%%%%
%%%....&&%&&.......&&.(&&&........%&&&&&&&,........................./////.%%%%%%
%%%................................*&&&&&...................................%%%%
%%%.........................................................................%%%%
%%%%.........................................................................%%%
%%%%.........................................................................%%%
%%%%%........................................................................%%%
%%%%%%%.........,%%%////(%%#.................................................%%%
**/