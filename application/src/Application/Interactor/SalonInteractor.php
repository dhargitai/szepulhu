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
        return new SalonResponse(
            $salon->getPicture(),
            $salon->getName(),
            $salon->getAddress(),
            $salon->getAddressAdditional(),
            $salon->getCity(),
            $salon->getPostCode(),
            $salon->getPhone(),
            $salon->getMapUrl(),
            $salon->getMap(),
            $salon->getProfessionals()
        );
    }
}
