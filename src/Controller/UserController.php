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
use App\Exception\ResourceValidationException;
use App\Exception\ResourceNoAssociatedException;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

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
     * 
     * Allows to register a new user and link it to the customer who creates it.
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="Bearer jwt",
     *     description="JWT token is required."
     * )
     * @SWG\Parameter(
     *     name="Content-Type",
     *     in="header",
     *     required=true,
     *     type="string",
     *     default="application/json",
     *     description="Define the content type."
     * )
     * @SWG\Response(
     *     response=201,
     *     description="Registering the user performed successfully."
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Information entered incorrect or already existing."
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Invalid JWT token."
     * )
     */
    public function register(User $user, UserPasswordEncoderInterface $encoder, ConstraintViolationList $violations)
    {
        if (count($violations))
        {
            foreach ($violations as $violation)
            {
                $message = sprintf("%s", $violation->getMessage());
            }
            throw new ResourceValidationException($message);
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
     * 
     * Allows to remove a user.
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="JWT token is required."
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Deleting the user performed successfully."
     * )
     * @SWG\Response(
     *     response=404,
     *     description="The desired resource does not exist or is not associated with your account."
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Invalid JWT token."
     * )
     */
    public function remove(User $user)
    {
        if ($this->getUser()->getClient() != $user->getClient())
        {
            $message = "L'utilisateur renseigné n'est pas associé à votre compte.";
            throw new ResourceNoAssociatedException($message);
        }

        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * @Rest\Get(
     *     path = "/api/users",
     *     name = "user_list")
     * @QueryParam(name="page", requirements="\d+", default="0", description="Desired begin page.")
     * @QueryParam(name="limit", requirements="\d+", default="5", description="Number of items desired per page.")
     * 
     * View a paged list of associated users with your account.
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="JWT token is required."
     * )
     * @SWG\Parameter(
     *     name="If-None-Match",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="Compare the etag given as parameter with that received and return a 304 code status response if they are identical."
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Displays the list of users associated with your account."
     * )
     * @SWG\Response(
     *     response=304,
     *     description="The data is identical to that of the cache."
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Invalid JWT token."
     * )
     */
    public function list(Request $request, ParamFetcher $paramFetcher, SerializerInterface $serializer)
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

        $response = new Response();
        $response->setContent($serializer->serialize($users_list, 'json'));
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Get(
     *     path = "/api/users/{id}",
     *     name = "user_details",
     *     requirements = {"id"="\d+"})
     * @Cache(Etag="user.getUsername() ~ user.getEmail() ~ user.getPassword()", public=true)
     * 
     * Allows to show the details of a defined user.
     *
     * @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="JWT token is required."
     * )
     * @SWG\Parameter(
     *     name="If-None-Match",
     *     in="header",
     *     required=true,
     *     type="string",
     *     description="Compare the etag given as parameter with that received and return a 304 code status response if they are identical."
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Displays the defined user."
     * )
     * @SWG\Response(
     *     response=404,
     *     description="The desired resource does not exist or is not associated with your account."
     * )
     * * @SWG\Response(
     *     response=304,
     *     description="The data is identical to that of the cache."
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Invalid JWT token."
     * )
     */
    public function details(User $user)
    {
        if ($user === null || $this->getUser()->getClient() != $user->getClient())
        {
            $message = "L'utilisateur renseigné n'existe pas ou n'est pas associé à votre compte.";
            throw new ResourceNoAssociatedException($message);
        }
        
        return $user;
    }
}
