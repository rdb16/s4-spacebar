<?php
/**
 * Created by PhpStorm.
 * User: rdb
 * Date: 2019-02-16
 * Time: 16:46
 */

namespace App\Controller;

use App\Entity\Article;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleController extends AbstractController
{
    //comme $isDebug est défini comme param dans service.yaml comme un controller est comme un service, on construit
    /**
     * @var
     */
    private $isDebug;

    public function __construct(bool $isDebug)
    {
          $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        //$articles = $repository->findAll();
        //$articles = $repository->findBy([], ['publishedAt' =>'DESC']);
        $articles = $repository->findAllPublishedOrderedByNewest();
        //dump($articles);die;
        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     * @param Article $article
     * @param SlackClient $slack
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() === 'khaaaaaan'){
            $slack->sendMessage('Khan2', 'Re-salut DUCON  !!!!!!');
        }


        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];



       return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
             ]);

    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     *
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();

        $logger->info((' un article a subi un coeur'));


        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}
