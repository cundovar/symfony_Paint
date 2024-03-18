<?php
namespace App\Tests\Security;

use App\Security\UserAuthenticator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class UserAuthenticatorTest extends TestCase
{
    public function testAuthenticateWithValidCredentials()
    {
        // Créer une session simulée
        $session = new Session(new MockArraySessionStorage());
        $session->start();
    
        // Créer une demande avec la session simulée
        $request = Request::create('/');
        $request->setSession($session);
    
        // Créer un double de la classe UrlGeneratorInterface (Mock)
        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
    
        // Configurer le double pour qu'il retourne une URL de redirection valide
        $urlGenerator->expects($this->once())
                     ->method('generate')
                     ->willReturn('/');
    
        // Créer une instance de votre authentificateur en passant le double en tant que dépendance
        $authenticator = new UserAuthenticator($urlGenerator);
    
        // Appeler la méthode authenticate() de l'authentificateur avec la demande simulée
        $passport = $authenticator->authenticate($request);
    
        // Vérifier que le passport est créé
        $this->assertInstanceOf(Passport::class, $passport);
    
        // Vérifier que la méthode onAuthenticationSuccess() retourne une redirection valide
        $token = $this->createMock(TokenInterface::class);
        $response = $authenticator->onAuthenticationSuccess($request, $token, 'main');
        $this->assertInstanceOf(RedirectResponse::class, $response);
        // Assurez-vous de vérifier l'URL de redirection ici
    }
}
