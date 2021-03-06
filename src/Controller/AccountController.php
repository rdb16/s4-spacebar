<?php
/**
 * Created by PhpStorm.
 * User: rdb
 * Date: 2019-02-15
 * Time: 19:41
 */

namespace App\Controller;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class AccountController extends BaseController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(LoggerInterface $logger)
    {
        //dd($this->getUser()->getFirstName());
        $logger->debug('Checking account page for '.$this->getUser()->getEmail());
        return $this->render('account/index.html.twig', [
        ]);
    }
    /**
     * @Route("/api/account", name="api_account")
     */
    public function accountApi()
    {
        $user = $this->getUser();

        //return $this->json($user);
        return $this->json($user, 200, [], [
           'groups' => ['main'],
        ]);
    }
}
