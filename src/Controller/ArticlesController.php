<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractBaseController
{
    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }

    /**
     * @Route("/articles", name="articles", methods={"GET"})
     */
    public function list(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();
        return $this->json(
            [$articles],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }

    /**
     * @Route("/article/{id}", name="articleId", methods={"GET"})
     */
    public function getArticleById(Article $article)
    {
        return $this->json(
            [$article],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }

    /**
     * @Route("/newArticle", name="newArticle", methods={"POST"})
     */
    public function newArticle(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManagerInterface->persist($article);
            $this->entityManagerInterface->flush();

            return $this->json(Response::HTTP_CREATED);
        } else {
            $errors = $this->getFormsErrors($form);
            return $this->json([$errors], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * @Route("/delete/{id}", name="delete_article", methods={"DELETE"})
     */
    public function deleteCarById(Article $article)
    {
        if ($article) {
            $this->entityManagerInterface->remove($article);
            $this->entityManagerInterface->flush();

            return $this->json(
                Response::HTTP_OK
            );
        }
    }

    /**
     * @Route("/patch/{id}", name="alter_article", methods={"PATCH"})
     */
    public function patchArticleById(Article $article, Request $request)
    {
        return $this->update(false, $request, $article);
    }

    /**
     * @Route("/put/{id}", name="put_article", methods={"PUT"})
     */
    public function putArticleById(Article $article, Request $request)
    {
        return $this->update(true, $request, $article);
    }

    private function update(bool $clearMissing = true, Request $request, Article $article)
    {

        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ArticleType::class, $article);
        $form->submit($data, $clearMissing);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManagerInterface->flush();

            return $this->json(
                Response::HTTP_OK
            );
        }
    }

    /**
     * @Route("/articlePopular", name="articlePopular", methods={"GET"})
     */
    public function popularArticle(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findBy(array('trending' => 1));
        return $this->json(
            [$articles],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }

    /**
     * @Route("/articleCategory/{id}", name="articleCategory", methods={"GET"})
     */
    public function articleCategory(ArticleRepository $articleRepository, Category $category)
    {
        $articles = $articleRepository->findBy(array('category' => $category->getId()));
        return $this->json(
            [$articles],
            Response::HTTP_OK,
            [],
            ["groups" => "article:detail"]
        );
    }
}
