<?php

namespace App\Controller;

use App\DTO\ProductDto;
use App\DTO\SearchDto;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Transliterator;

class ProductController extends AbstractController
{

    #[Route('/', name: 'home')]
    #[Route('/product/list', name: 'product_list')]
    public function list(Request $request, ProductService $productService,  ProductRepository $productRepository, CategoryRepository $categoryRepository): Response {
        $renderPage = $request->getRequestUri() == '/product/list' ? 'product/list.html.twig' : 'home/index.html.twig';

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        $transliterator = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC');
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var SearchDto $searchDto */
            $searchDto = $form->getData();
            $categoryId = $searchDto->getCategory()?->getId();
            $search = $transliterator->transliterate(mb_strtolower($searchDto->getSearch()));
            $city = $transliterator->transliterate(mb_strtolower($searchDto->getCity()));
            if ($categoryId) $tmpProducts = $productRepository->findBy(['category' => $searchDto->getCategory()]);
            else $tmpProducts = $productRepository->findAll();
            $products = [];
            foreach ($tmpProducts as $product) {
                $tmpName = $transliterator->transliterate(mb_strtolower($product->getName()));
                $tmpCity = $transliterator->transliterate(mb_strtolower($product->getCity()));
                if ($search == '' && $city != '') {
                    if (str_contains($tmpCity, $city)) $products[] = $product;
                } else if ($search != '' && $city == '') {
                    if (str_contains($tmpName, $search)) $products[] = $product;
                } else {
                    $products[] = $product;
                }
            }
            $renderPage = 'product/list.html.twig';
        } else {
            $products = $productRepository->findAll();
        }

        // Show no-image if no image is available otherwise show the first one
        foreach($products as $product) {
            $productService->getFirstProductImage($product);
        }


        return $this->render($renderPage, [
            'form' => $form->createView(),
            'products' => $products,
            'categories' => $categoryRepository->findAll(),
            'total' => count($products),
            'selectedCategoryId' => $categoryId ?? -1,
            'search' => isset($searchDto) ? $searchDto->getSearch() : '',
            'city' => isset($searchDto) ? $searchDto->getCity() : '',
        ]);
    }

    #[Route('/product/detail/{id}', name: 'product_detail')]
    public function detail(Product $product, ProductService $productService): Response
    {
        setlocale(LC_ALL, 'fr_FR');
        $productService->getProductImages($product);
        return $this->render('product/detail.html.twig', ['product' => $product]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/product/add', name: 'product_add')]
    public function add(Request $request, EntityManagerInterface $doctrine, CategoryRepository $categoryRepository): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ProductDto $productDto */
            $productDto = $form->getData();

            $product = new Product();
            $productDto->setEntityFromDto($product);
            $product->setUser($this->getUser());
            $product->setDate(new DateTime());

            $doctrine->persist($product);
            $doctrine->flush();

            $images = $productDto->getImages();
            foreach ($images as $i => $image) {
                $imageName = './assets/img/products/' . $product->getId() . '/';
                $image->move($imageName, $i . $this->getExtension($image->getMimeType()));
            }

            $doctrine->persist($product);
            $doctrine->flush();

            return $this->render('product/added.html.twig', ['product' => $product]);
        }

        return $this->render('product/add.html.twig', ['form' => $form->createView(), 'categories' => $categoryRepository->findAll()]);
    }

    private function getExtension($mimeType): string
    {
        if ($mimeType == 'image/png') return '.png';
        if ($mimeType == 'image/jpeg') return '.jpg';
        else return '';
    }

    #[Route('/product/manage', name: 'product_manage')]
    public function manage(ProductRepository $productRepository): Response
    {

        $products = $productRepository->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('product/manage.html.twig', [
            'products' => $products
        ]);
    }
}































/**
 * TODO: Feed the patate
 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%/%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&##%%%&(+//#&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%#////////////&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&///////////#&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&%(/////%&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%%%##&%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%///#%////%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%#/////////%%%%%%%%%.....%%%%%%%%%%%%%%%%%....%%%%%%%%%%%%%%%%%////(&%#//%%%%
 * %%%%%%%(////#&%%%%%...........%%%%%%%%%%%...........%%%%%%%%%%%%%#///////////&%%
 * %%%%%%%%%%%%%%%%%...............%%%%%%...............%%%%%%%%%%%%%%/////////#%%%
 * %%%%%%%%%%%%%%%%......................................%%%%%%%%%%%%%%%///(&%%%%%%
 * %%%%%%%%%%%%%%..........................................%%%%%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%%%%..............................................//%%%%%%%%%%%%%%%%%%%%
 * %%%%%%%%%...............................................+/////...%%%%%%%%%%%%%%%
 * %%%%%%%................................................+/////...////%%%%%%%%%%%%
 * %%%%%%..,&&&%.........................*.................///,.../////..%%%%%%%%%%
 * %%%%...#&%&&&,....................,&&&&&%&.....................///,...//%%%%%%%%
 * %%%%...&&&&&&....&&..##..,&.......&&%&&&&&*.........................+////%%%%%%%
 * %%%....&&%&&.......&&.(&&&........%&&&&&&&,........................./////.%%%%%%
 * %%%................................*&&&&&...................................%%%%
 * %%%.........................................................................%%%%
 * %%%%.........................................................................%%%
 * %%%%.........................................................................%%%
 * %%%%%........................................................................%%%
 * %%%%%%%.........,%%%////(%%#.................................................%%%
 **/