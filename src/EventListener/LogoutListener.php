<?php
/**
 * Created by PhpStorm.
 * User: Georges
 * Date: 25/05/2020
 * Time: 10:08
 */

namespace App\EventListener;

use App\Manager\UserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use FOS\UserBundle\Model\UserManagerInterface;

class LogoutListener implements LogoutHandlerInterface
{
    protected $userManager;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(UserManager $userManager, SessionInterface $session){
        $this->userManager = $userManager;
        $this->session = $session;
    }

    public function logout(Request $request, Response $response, TokenInterface $token) {
        $username = $token->getUsername();
        $user = $this->userManager->findOneBy(["username" => $username]);
        $user->setSessionStore($request->getSession()->get('_security.main.target_path'));
        $this->userManager->save($user);
        $this->session->invalidate();
    }
}