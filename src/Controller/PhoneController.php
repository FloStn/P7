<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Phone;
use App\Repository\PhoneRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use App\Exception\ResourceDoesNotExistException;

class PhoneController extends AbstractController
{
    private $repository;

    public function __construct(PhoneRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Get(
     *     path = "/api/phones",
     *     name = "phones_catalog")
     * @QueryParam(name="page", requirements="\d+", default="1", description="Page souhaitée")
     * @QueryParam(name="limit", requirements="\d+", default="5", description="Index de fin de la pagination")
     * @Cache(expires="+30 minutes", public=true)
     */
    public function catalog(ParamFetcher $paramFetcher)
    {
        $page = $paramFetcher->get('page');
        $limit = $paramFetcher->get('limit');
        $phones_list = array();
        $query = $this->repository->getPagination($page, $limit);

        foreach($query as $row)
        {
            array_push($phones_list, $row);
        }

        return $phones_list;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Get(
     *     path = "/api/phones/{id}",
     *     name = "phone_details",
     *     requirements = {"id"="\d+"})
     * @Cache(expires="+30 minutes", public=true)
     */
    public function details(Phone $phone)
    {
        if ($phone === null)
        {
            $message = "Ce téléphone n'existe pas.";
            throw new ResourceDoesNotExistException($message);
        }

        return $phone;
    }
}
