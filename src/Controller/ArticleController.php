<?php
/**
 * Created by PhpStorm.
 * User: rdb
 * Date: 2019-02-16
 * Time: 16:46
 */

namespace App\Controller;


use App\Entity\Article;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;



class ArticleController extends AbstractController
{

    //comme $isDebug est défini comme param dans service.yaml
    //comme un controller est comme un service
    //on passe la var avec un constructeurÒ
    /**
     * @var
     */
    private $isDebug;

    public function __construct(bool $isDebug)
    {
       //dump($isDebug);die;
        $this->isDebug = $isDebug;
    }


    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     *
     */
    public function show($slug, SlackClient $slack, EntityManagerInterface $em)
    {
        if ($slug === 'khaaaaaan'){
            $slack->sendMessage('Khan2', 'Re-salut DUCON  !!!!!!');
        }

        $repository = $em->getRepository(Article::class);
        /** @var Article $article */
        $article = $repository->findOneBy(['slug' =>$slug]);
        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        //dump($article);die;

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
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        // TODO actually heart/unheart the article

        $logger->info((' un article a subi un coeur'));

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}
