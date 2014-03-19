<?php
namespace Location\PlanBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller {
    /**
     * @Route("/", name="login")
     * @Template()
     */
    public function loginAction() {
        // Session laden
        $request = $this->getRequest();
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        return array(
        // last username entered by the user
        'last_username' => $session->get(SecurityContext::LAST_USERNAME), 'error' => $error,);
    }
    /**
     * @Route("/login_check/", name="login_check")
     */
    public function loginCheckAction() {
        // The security layer will intercept this request
        
    }
    /**
     * @Route("/logout/", name="logout")
     */
    public function logoutAction() {
        // The security layer will intercept this request
        
        
    }
}
