<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\MainMenu;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="app_")
 */
class AppController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->redirectToRoute('app_show_sub_category', [
            'category_slug' => 'discover',
            'sub_category_slug' => 'newsroom'
        ]);
        /*
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();


        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'main_menu' => $mainMenu,
            'current_main_menu' => null
        ]);
        */
    }

    /**
     * @Route("/{category_slug}", name="show_category")
     * @param $category_slug
     * @return Response
     */
    public function showCategory($category_slug)
    {

        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();

        $categoryRepository = $this->getDoctrine()->getRepository('App:Category');
        $category = $categoryRepository->findOneBy([
           'slug' => $category_slug
        ]);

        if(!$category){throw $this->createNotFoundException('The product does not exist');};

        $subCategories = $categoryRepository->findBy([
            'parent' => $category
        ]);



        return $this->render('app/show_category.html.twig', [
            'controller_name' => $category->getTitle(),
            'main_menu' => $mainMenu,
            'current_main_menu' => $category->getSlug(),
            'current_category' => $category,
            'sub_categories' => $subCategories,
        ]);
    }

    /**
     * @Route("/{category_slug}/{sub_category_slug}", name="show_sub_category")
     */
    public function showSubCategory($category_slug, $sub_category_slug)
    {
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();

        $categoryRepository = $this->getDoctrine()->getRepository('App:Category');

        $category = $categoryRepository->findOneBy([
            'slug' => $category_slug
        ]);

        $currentSubCategory = $categoryRepository->findOneBy([
            'slug' => $sub_category_slug
        ]);

        $subCategories = $categoryRepository->findBy([
            'parent' => $currentSubCategory
        ]);



        if($currentSubCategory->getRedirectToPost()){
            return $this->redirectToRoute('app_show_post', [
                'category_slug' => $category_slug,
                'sub_category_slug' => $sub_category_slug,
                'post_slug' => $currentSubCategory->getPosts()->first()->getSlug()
            ]);
        }

        return $this->render('app/show_sub_category.html.twig', [
            'controller_name' => $category->getTitle(),
            'main_menu' => $mainMenu,
            'current_main_menu' => $category->getSlug(),

            'sub_categories' => $subCategories,

            'current_category' => $category,
            'current_sub_category' => $currentSubCategory,

            'current_post' => ['slug' => 'null']
        ]);
    }

    /**
     * @Route("/{category_slug}/{sub_category_slug}/{post_slug}", name="show_post")
     * @param $category_slug
     * @param $sub_category_slug
     * @param $post_slug
     * @param Request $request
     * @return Response
     */
    public function showPost($category_slug, $sub_category_slug, $post_slug, Request $request)
    {
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();

        $searchQuery = ($request->isMethod('POST')) ? $request->request->get('search') : false;
        $isPost = ($searchQuery)? true : false;
        $results = false;

        if ($searchQuery){
            $postRepository = $this->getDoctrine()->getRepository('App:Post');
            $results = $postRepository->findByLikeSearch($searchQuery);
        }

        $error = !$results;

        $categoryRepository = $this->getDoctrine()->getRepository('App:Category');

        $postRepository = $this->getDoctrine()->getRepository('App:Post');
        $tagRepository = $this->getDoctrine()->getRepository('App:Tag');
        $tags = $tagRepository->findAll();
        $category = $categoryRepository->findOneBy([
            'slug' => $category_slug
        ]);

        $subCategories = $categoryRepository->findBy([
            'parent' => $category
        ]);

        $currentSubCategory = $categoryRepository->findOneBy([
            'slug' => $sub_category_slug
        ]);

        $currentPost = $postRepository->findOneBy([
           'slug' => $post_slug
        ]);

        $leadPost = $postRepository->findOneBy([
            'parent' => 23,
            'isLeadStory' => true,
        ],[
            'created' => 'DESC'
        ]);


        $template = ($currentPost->getHasTemplate())
            ? $category->getSlug().$currentPost->getTemplate()
            : 'show_post.html.twig';

        return $this->render('app/' . $template, [
            'controller_name' => $category->getTitle(),
            'main_menu' => $mainMenu,
            'current_main_menu' => $category->getSlug(),

            'sub_categories' => $subCategories,

            'current_category' => $category,
            'current_sub_category' => $currentSubCategory,
            'tags' => $tags,

            'current_post' => $currentPost,
            'lead_post' => $leadPost,
            'results' => $results,
            'error' => $error,
            'isPost' => $isPost,
        ]);
    }

    /**
     * @Route("/{category_slug}/{sub_category_slug}/{post_slug}/{sub_post_slug}", name="show_sub_post")
     */
    public function showSubPost($category_slug, $sub_category_slug, $post_slug, $sub_post_slug)
    {
        $mainMenuRepository = $this->getDoctrine()->getRepository('App:MainMenu');
        $mainMenu = $mainMenuRepository->findAll();

        $categoryRepository = $this->getDoctrine()->getRepository('App:Category');

        $postRepository = $this->getDoctrine()->getRepository('App:Post');

        $category = $categoryRepository->findOneBy([
            'slug' => $category_slug
        ]);

        $subCategories = $categoryRepository->findBy([
            'parent' => $category
        ]);

        $currentSubCategory = $categoryRepository->findOneBy([
            'slug' => $sub_category_slug
        ]);

        $currentPost = $postRepository->findOneBy([
            'slug' => $post_slug
        ]);

        $currentSubPost = $postRepository->findOneBy([
           'slug' => $sub_post_slug
        ]);

        $previousPost = $postRepository->getPreviousPost($currentSubPost->getId(),$currentSubPost->getParent());
        $nextPost = $postRepository->getNextPost($currentSubPost->getId(),$currentSubPost->getParent());

        $template = ($currentSubPost->getHasTemplate())
            ? $category->getSlug().$currentSubPost->getTemplate()
            : 'show_post.html.twig';

        return $this->render('app/' . $template, [
            'controller_name' => $category->getTitle(),
            'main_menu' => $mainMenu,
            'current_main_menu' => $category->getSlug(),

            'sub_categories' => $subCategories,

            'current_category' => $category,
            'current_sub_category' => $currentSubCategory,

            'current_post' => $currentPost,
            'current_sub_post' => $currentSubPost,

            'previous_post' => $previousPost,
            'next_post' => $nextPost
        ]);
    }

}
