<?php
namespace Ivoz\Provider\Domain\Model\Locution;
use Ivoz\Core\Domain\Model\TempFileContainnerTrait;
use Ivoz\Core\Domain\Service\FileContainerInterface;

/**
 * Locution
 */
class Locution extends LocutionAbstract implements LocutionInterface, FileContainerInterface
{
    use LocutionTrait;
    use TempFileContainnerTrait;


    /**
     * @return array
     */
    public function getFileObjects()
    {
        return [
            'OriginalFile',
            'EncodedFile'
        ];
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getLocutionPath ()
    {
        return 'FSO not implemented yet';
        throw new \Exception('FSO not implemented yet');
        return substr($this->fetchEncodedFile()->getFilePath(), 0, - 4);
    }
}
