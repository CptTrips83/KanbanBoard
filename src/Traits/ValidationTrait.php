<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

trait ValidationTrait
{
    private function validateRequest(
        Request $request,
        string $method,
        UserInterface $user = null,
    ) : bool {
        if($request->isXmlHttpRequest()) {
            if ($user == null) {
                return false;
            }
            if (!$request->isMethod($method)) {
                return false;
            }
            return true;
        }
        return false;
    }
}