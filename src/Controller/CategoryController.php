<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractBaseController
{
    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function listCategory(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->json(
            [$categories],
            Response::HTTP_OK,
            [],
            ["groups" => "category:detail"]
        );
    }

    /**
     * @Route("/category/{id}", name="categoryId", methods={"GET"})
     */
    public function getArticleById(Category $category)
    {
        return $this->json(
            [$category],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }

    /**
     * @Route("/newCategory", name="newCategory", methods={"POST"})
     */
    public function newArticle(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManagerInterface->persist($category);
            $this->entityManagerInterface->flush();

            return $this->json(Response::HTTP_CREATED);
        } else {
            $errors = $this->getFormsErrors($form);
            return $this->json([$errors], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/deleteCategory/{id}", name="delete_category", methods={"DELETE"})
     */
    public function deleteCarById(Category $category)
    {
        if ($category) {
            $this->entityManagerInterface->remove($category);
            $this->entityManagerInterface->flush();

            return $this->json(
                Response::HTTP_OK
            );
        }
    }

    /**
     * @Route("/patchCategory/{id}", name="alter_category", methods={"PATCH"})
     */
    public function patchArticleById(Category $category, Request $request)
    {
        return $this->update(false, $request, $category);
    }

    /**
     * @Route("/putCategory/{id}", name="put_category", methods={"PUT"})
     */
    public function putArticleById(Category $category, Request $request)
    {
        return $this->update(true, $request, $category);
    }

    private function update(bool $clearMissing = true, Request $request, Category $category)
    {

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(CategoryType::class, $category);
        $form->submit($data, $clearMissing);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManagerInterface->flush();

            return $this->json(
                Response::HTTP_OK
            );
        }
    }
}
