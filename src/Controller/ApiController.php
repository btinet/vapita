<?php


namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{

    /**
     * @Route("/search", name="quick_search")
     * @param Request $request
     * @return Response
     */
    public function doQuickSearch(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->request->get('search');
            $postRepository = $this->getDoctrine()->getRepository('App:Post');
            $result = $postRepository->findByLikeSearch($data);
            if (!$result) {
                $result = false;
                $error = true;

                return $this->render('app/search_not_found.html.twig', [
                    'results' => $result,
                    'error' => $error,
                    'isPost' => true
                ]);
            }

            $error = false;
            return $this->render('app/search_results.html.twig', [
                'results' => $result,
                'error' => $error,
                'isPost' => true
            ]);
        }
        return null;
    }

    /**
     * @Route("/comment/{slug}", name="save_comment")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param  $slug
     * @return Response
     */
    public function saveComment(Request $request, EntityManagerInterface $em, $slug)
    {
        if ($request->isMethod('post')) {
            $data = $request->request->all();
            $postRepository = $this->getDoctrine()->getRepository('App:Post');
            $post = $postRepository->findOneBy([
                'slug' => $slug
            ]);

            $comment = new Comment();

            $comment
                ->setContent($data['content'])
                ->setAuthor($data['author'])
                ->setEmail($data['email'])
                ->setPost($post);
            $em->persist($comment);
            $em->flush();

            return $this->render('app/post_comment_row.html.twig', [
                'comment' => $comment
            ]);
        }
        return null;
    }


}