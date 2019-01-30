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
    private $repository;

    public function __construct(EntityManagerInterface $em, UserRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
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
        
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Delete(
     *     path = "/api/users/{id}",
     *     name = "user_remove")
     */
    public function remove(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Get(
     *     path = "/api/users",
     *     name = "users_list")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page souhaitée")
     * @QueryParam(name="limit", requirements="\d+", default="5", description="Index de fin de la pagination")
     * @Cache(expires="+30 minutes", public=true)
     */
    public function list(ParamFetcher $paramFetcher)
    {
        $page = $paramFetcher->get('page');
        $limit = $paramFetcher->get('limit');
        $users_list = array();
        $client = $this->getUser();
        $query = $this->repository->getPagination($client, $page, $limit);

        foreach($query as $row)
        {
            array_push($users_list, $row);
        }

        return $users_list;
    }
}
