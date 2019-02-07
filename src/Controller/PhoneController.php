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
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

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
     * @QueryParam(name="page", requirements="\d+", default="0", description="Desired begin page.")
     * @QueryParam(name="limit", requirements="\d+", default="5", description="Number of items desired per page.")
     * 
     * View a paged list of phones.
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
     *     description="Displays the list of phones."
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
    public function catalog(Request $request, ParamFetcher $paramFetcher, SerializerInterface $serializer)
    {
        $page = $paramFetcher->get('page');
        $limit = $paramFetcher->get('limit');
        $phones_list = array();
        $query = $this->repository->getPagination($page, $limit);

        foreach($query as $row)
        {
            array_push($phones_list, $row);
        }

        $response = new Response();
        $response->setContent($serializer->serialize($phones_list, 'json'));
        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Get(
     *     path = "/api/phones/{id}",
     *     name = "phone_details",
     *     requirements = {"id"="\d+"})
     * @Cache(Etag="phone.getType() ~ phone.getFormat() ~ phone.getIntegratedComponents() ~ phone.getWidth() ~ phone.getDepth() ~ phone.getHeight() ~ phone.getWeight() ~ phone.getCaseColor() ~ phone.getCaseMaterial() ~ phone.getMobileBroadbandGeneration() ~ phone.getOperatingSystem() ~ phone.getSimCardType() ~ phone.getClockFrequency() ~ phone.getProcessorCoreQty() ~ phone.getArchitecture() ~ phone.getRam() ~ phone.getInternalMemoryCapacity() ~ phone.getUserMemory() ~ phone.getFrontCameraResolution() ~ phone.getBackCameraResolution() ~ phone.getBatteryTechnologie() ~ phone.getBrand() ~ phone.getPrice()", public=true)
     * 
     * Allows to show the details of a defined phone.
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
     *     description="Displays the defined phone."
     * )
     * @SWG\Response(
     *     response=404,
     *     description="The desired resource does not exist."
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
