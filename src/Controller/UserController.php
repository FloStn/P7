<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\View(statusCode = 201)
     * @Rest\Post(
     *     path = "/api/users",
     *     name = "user_register")
     * @ParamConverter("user", converter="fos_rest.request_body")
     * @Cache(expires="+30 minutes", public=true)
     */
    public function register(User $user, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            $list_errors = array();
        
            foreach($errors as $error)
            {
                $errorString = (string) $error;
                array_push($list_errors, $errorString);
            }
        
            return $list_errors;
        }

        $user->setClient($this->getUser()->getClient());
        $passwordEncoder = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($passwordEncoder);
        $user->setRoles(['ROLE_USER']);
        $this->getUser()->setRoles(['ROLE_CLIENT']);
        
        $this->em->persist($user);
        $this->em->flush();
    }
}
