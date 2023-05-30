<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    // personnaliser la page de réponse lorsque l'utilisateur n'a pas l'accès (le bon rôle)
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        $content = "<h1>Vous n'êtes pas autorisé à consulter cette page</h1>
                    <a href=\"/\" class=\"btn btn-primary\">Retour au site</a>";
        return new Response($content, 403);
    }
}