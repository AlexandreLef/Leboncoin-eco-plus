<?php

namespace App\Controller;

use App\DTO\ProductDto;
use App\DTO\SearchDto;
use App\Entity\Product;
use App\Entity\Search;
use App\Entity\User;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{


    #[Route('/product/list', name: 'product_list')]
    public function list(Request $request, ProductService $productService, ProductRepository $productRepository, CategoryRepository $categoryRepository, EntityManagerInterface $doctrine): Response {
        // Prepare form
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get values from form
            $searchDto = $form->getData();
            /** @var SearchDto $searchDto */
            $categoryId = $searchDto->getCategory()?->getId();
            $search = $productService->normalize($searchDto->getSearch());
            $city = $productService->normalize($searchDto->getCity());

            // Get the product only from the selected category (or all)
            if ($categoryId) $tmpProducts = $productRepository->findBy(['category' => $searchDto->getCategory()]);
            else $tmpProducts = $productRepository->findAll();

            // Check if the product contains the city (if any) or the search (if any)
            $products = [];
            foreach ($tmpProducts as $product) {
                $tmpName = $productService->normalize($product->getName());
                $tmpCity = $productService->normalize($product->getCity());
                // In a sentence it would be:
                // If product's city contains the searched city and the searched city is not empty
                // AND product's name contains the searched string and the searched string is not empty
                if ((str_contains($tmpCity, $city) || $city == '') && (str_contains($tmpName, $search) || $search == '')) $products[] = $product;
            }

            // Add the search to the database
            if ($search != '' || $city != '') {
                $search = new Search();
                $user = $this->getUser(); /** @var User $user */
                $search->setUser($user);
                $search->setCategory($searchDto->getCategory() ?? null);
                $search->setSearch($searchDto->getSearch() ?? null);
                $search->setCity($searchDto->getCity() ?? null);
                $doctrine->persist($search);
                $doctrine->flush();
            }
        } else {
            // By default, we show all products
            $products = $productRepository->findAll();
        }

        return $this->render('product/list.html.twig', [
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
    public function detail(Product $product): Response {
        return $this->render('product/detail.html.twig', ['product' => $product]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/product/add', name: 'product_add')]
    public function add(Request $request, EntityManagerInterface $doctrine, CategoryRepository $categoryRepository): Response
    {   // Prepare form
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get form values
            $productDto = $form->getData(); /** @var ProductDto $productDto */

            // Create product object
            $user = $this->getUser(); /** @var User $user */
            $product = new Product();
            $productDto->setEntityFromDto($product);
            $product->setUser($user);
            $product->setDate(new DateTime());
            // Insert into database
            $doctrine->persist($product);
            $doctrine->flush();

            // Get the images that the user uploaded
            $images = $productDto->getImages();
            foreach ($images as $i => $image) {
                // Move them into the img public folder
                $imageName = './assets/img/products/' . $product->getId() . '/';
                $image->move($imageName, $i . $this->getExtension($image->getMimeType()));
            }

            return $this->render('product/added.html.twig', ['product' => $product]);
        }

        return $this->render('product/add.html.twig', ['form' => $form->createView(), 'categories' => $categoryRepository->findAll()]);
    }

    private function getExtension($mimeType): string {
        if ($mimeType == 'image/png') return '.png';
        if ($mimeType == 'image/jpeg') return '.jpg';
        else return '';
    }

    #[Route('/product/manage', name: 'product_manage')]
    public function manage(Request $request, EntityManagerInterface $doctrine, CategoryRepository $categoryRepository): Response
    {
        $user = $this->getUser(); /** @var User $user */
        $products = $user->getProducts();

        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get form values
            $productDto = $form->getData();
            /** @var ProductDto $productDto */

            // Create product object
            $user = $this->getUser();
            /** @var User $user */
            $product = new Product();
            $productDto->setEntityFromDto($product);
            $product->setUser($user);
            $product->setDate(new DateTime());
            // Insert into database
            $doctrine->persist($product);
            $doctrine->flush();

            // Get the images that the user uploaded
            $images = $productDto->getImages();
            foreach ($images as $i => $image) {
                // Move them into the img public folder
                $imageName = './assets/img/products/' . $product->getId() . '/';
                $image->move($imageName, $i . $this->getExtension($image->getMimeType()));
            }
        }

        return $this->render('product/manage.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @throws EntityNotFoundException
     */
    #[Route('/product/manage/delete/{id}', name: 'product_manage_delete', methods: 'GET')]
    public function delete(ProductRepository $productRepository, Product $product): Response
    {
        $productRepository->delete($product);
        return $this->redirectToRoute('product_manage');
    }


    #[Route('/product/manage/update/{id}/dto/{dto}', name: 'product_manage_update', methods: 'GET')]
    public function update(ProductService $productService, Product $product, ProductDto $productDto): Response
    {
        $productDto->setEntityFromDto($product);
        $productService->addOrUpdate($productDto, $product);
        return $this->redirectToRoute('product_manage');
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