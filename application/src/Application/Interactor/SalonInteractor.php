<?php
/**
 * @author    Hargitai Dávid <div@diatigrah.hu>
 * @copyright Hargitai Dávid, 2015.05.28.
 * @package   szepulhu_interactors
 */

namespace Application\Interactor;

use Application\Entity\Professional\SalonRepository;

class SalonInteractor
{
    private $repostory;

    public function __construct(SalonRepository $repository)
    {
        $this->repostory = $repository;
    }

    public function createSalonResponse(SalonRequest $request)
    {
        $salon = $this->repostory->findOneBy(array('slug' => $request->slug));
        return new SalonResponse(array(
            'picture' => $salon->getPicture(),
            'name' => $salon->getName(),
            'address' => $salon->getAddress(),
            'addressAdditional' => $salon->getAddressAdditional(),
            'city' => $salon->getCity(),
            'postCode' => $salon->getPostCode(),
            'phone' => $salon->getPhone(),
            'mapUrl' => $salon->getMapUrl(),
            'map' => $salon->getMap(),
            'professionals' => $salon->getProfessionals(),
        ));
    }
}
