<?php
/**
 * Created by PhpStorm.
 * User: rdb
 * Date: 2019-02-15
 * Time: 19:43
 */

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @method User|null getUser()
 */
abstract class BaseController extends AbstractController
{
    protected function getUser(): User
    {
        return parent::getUser();
    }
}
