<?php

namespace Application\DataFixtures\ORM;

use Application\Model\Professional;
use Application\Model\User;
use Application\Sonata\MediaBundle\Entity\GalleryHasMedia;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Nelmio\Alice\Fixtures;
use SebastianBergmann\PHPLOC\CLI\Application;
use Sonata\MediaBundle\Model\GalleryInterface;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Model\MediaManagerInterface;
use Sonata\MediaBundle\SonataMediaBundle;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;

class AppFixtures implements FixtureInterface, ContainerAwareInterface
{
    protected $container;

    public function load(ObjectManager $om)
    {
        Fixtures::load(__DIR__.'/tasks.yml', $om, array('providers' => array($this)));
        Fixtures::load(__DIR__.'/salons.yml', $om, array('providers' => array($this)));
        Fixtures::load(__DIR__.'/users.yml', $om, array('providers' => array($this)));
        Fixtures::load(__DIR__.'/services.yml', $om, array('providers' => array($this)));
        Fixtures::load(__DIR__.'/recommendations.yml', $om, array('providers' => array($this)));
    }

    public function newImage($kind = 'people')
    {
        $filesArray = array();
        $files = Finder::create()
            ->name('*.{jpg,png,gif}')
            ->in(__DIR__.'/../data/images/' . $kind);
        foreach ($files as $file) {
            $filesArray[] = $file;
        }
        return $this->createImageMediaFile($filesArray[array_rand($filesArray)]);
    }

    public function newGallery()
    {
        $gallery = $this->getGalleryManager()->create();
        $filesArray = array();
        $files = Finder::create()
            ->name('*.jpg')
            ->in(__DIR__.'/../data/images/other');
        foreach ($files as $file) {
            $filesArray[] = $file;
        }
        for ($i = 1; $i <= 4; $i++) {
            $image = $this->createImageMediaFile($filesArray[array_rand($filesArray)]);
            $this->addMedia($gallery, $image);
        }
        $gallery->setEnabled(true);
        $gallery->setName('media_gallery_' . $i);
        $gallery->setDefaultFormat('medium');
        $gallery->setContext('default');
        $this->getGalleryManager()->update($gallery);
        return $gallery;
    }

    public function serviceGroup()
    {
        $serviceGroups = array(
            'Haj',
            'Arc',
            'Stílus',
            'Kényeztetés',
            'Gyógykezelés',
            'Kéz',
            'Láb',
        );
        return $serviceGroups[array_rand($serviceGroups)];
    }

    public function gender()
    {
        $genders = array(
            User::GENDER_FEMALE,
            User::GENDER_MALE,
            User::GENDER_UNKNOWN
        );
        return $genders[array_rand($genders)];
    }

    public function interests()
    {
        $interests = array(
            Professional::INTEREST_FREE_APPOINTMENT_SCHEDULING,
            Professional::INTEREST_FREE_CLIENT_TRACKING,
            Professional::INTEREST_FREE_WEBSITE_AND_ONLINE_MARKETING,
            Professional::INTEREST_GROW_AND_SIMPLIFY_BUSINESS,
            Professional::INTEREST_NOT_SURE,
        );
        shuffle($interests);
        return array_slice($interests, 0, mt_rand(0, count($interests) - 1));
    }

    public function service()
    {
        $services = array(
            'Hajfestés',
            'Arcmasszírozás',
            'Stílustanácsadás',
            'Közös bevásárlás',
            'Lazító masszázs',
            'Gyógymasszázs',
            'Tanácsadás',
            'Talpmasszázs',
            'Gerinctorna',
            'Sminkelés',
            'Manikűr',
            'Lábköröm festés',
            'Hajvágás',
            'Dajjer :)',
        );
        return $services[array_rand($services)];
    }

    public function hungarianCity()
    {
        $cities = array(
            'Baja',
            'Budapest',
            'Cegléd',
            'Debrecen',
            'Eger',
            'Esztergom',
            'Gyöngyös',
            'Győr',
            'Gyula',
            'Hajdúböszörmény',
            'Hajdúnánás',
            'Hajdúszoboszló',
            'Hódmezővásárhely',
            'Jászberény',
            'Kaposvár',
            'Karcag',
            'Kecskemét',
            'Kiskunfélegyháza',
            'Kiskunhalas',
            'Kisújszállás',
            'Komárom',
            'Kőszeg',
            'Makó',
            'Mezőtúr',
            'Miskolc',
            'Nagykanizsa',
            'Nagykőrös',
            'Nyíregyháza',
            'Pápa',
            'Pécs',
            'Sopron',
            'Szeged',
            'Székesfehérvár',
        );
        return $cities[array_rand($cities)];
    }

    protected function createImageMediaFile($fileName)
    {
        $manager = $this->getMediaManager();
        $media = $manager->create();
        $media->setBinaryContent($fileName);
        $media->setEnabled(true);
        $manager->save($media, 'default', 'sonata.media.provider.image');
        return $media;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function getRepositoryOf($className)
    {
        return $this->container->get('doctrine.orm.entity_manager')->getRepository($className);
    }

    /**
     * @param \Sonata\MediaBundle\Model\GalleryInterface $gallery
     * @param \Sonata\MediaBundle\Model\MediaInterface $media
     * @return void
     */
    public function addMedia(GalleryInterface $gallery, MediaInterface $media)
    {
        $galleryHasMedia = new GalleryHasMedia();
        $galleryHasMedia->setMedia($media);
        $galleryHasMedia->setPosition(count($gallery->getGalleryHasMedias()) + 1);
        $galleryHasMedia->setEnabled(true);
        $gallery->addGalleryHasMedias($galleryHasMedia);
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    protected function getMediaManager()
    {
        return $this->container->get('sonata.media.manager.media');
    }

    /**
     * @return \Sonata\MediaBundle\Model\MediaManagerInterface
     */
    protected function getGalleryManager()
    {
        return $this->container->get('sonata.media.manager.gallery');
    }
}
