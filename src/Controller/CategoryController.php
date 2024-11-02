<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Form\EditCategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\DeleteCategoryType;

class CategoryController extends AbstractController
{

    #[Route('/moderation/categories', name: 'app_categories')]
    public function Categories(Request $request, CategoryRepository $categoryRepository, EntityManagerInterface $em): Response {

        $categories = $categoryRepository->findAll();
        $form = $this->createForm(DeleteCategoryType::class, null, [
            'categories' => $categories
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedCategories = $form->get('categories')->getData();
            foreach ($selectedCategories as $category) {
                $em->remove($category);
            }
            $em->flush();

            $this->addFlash('notice', 'Catégories supprimées avec succès');
            return $this->redirectToRoute('app_categories');
        }

        return $this->render('category/categories.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
        ]); 
    }


    #[Route('/moderation/edit-category/{id}', name: 'app_edit_category')]
    public function editCategory(Request $request, Category $category, EntityManagerInterface $em): Response {

        $form = $this->createForm(EditCategoryType::class, $category);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
                $em->persist($category);
                $em->flush();
                $this->addFlash('notice','Catégorie modifiée');
                return $this->redirectToRoute('app_categories');
            }
        }
        
        return $this->render('category/edit_category.html.twig', [
            'form' => $form->createView()
        ]); 
    }


    #[Route('/moderation/delete-category/{id}', name: 'app_delete_category')]
    public function deleteCategory(Request $request, Category $category, EntityManagerInterface $em): Response {

        if($category!=null){
            $em->remove($category);
            $em->flush();
            $this->addFlash('notice','Catégorie supprimée');
        }

        return $this->redirectToRoute('app_categories');
    }
}
