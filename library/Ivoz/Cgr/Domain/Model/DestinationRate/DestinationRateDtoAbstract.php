<?php

namespace Ivoz\Cgr\Domain\Model\DestinationRate;

use Ivoz\Core\Application\DataTransferObjectInterface;
use Ivoz\Core\Application\ForeignKeyTransformerInterface;
use Ivoz\Core\Application\CollectionTransformerInterface;
use Ivoz\Core\Application\Model\DtoNormalizer;

/**
 * @codeCoverageIgnore
 */
abstract class DestinationRateDtoAbstract implements DataTransferObjectInterface
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $status = 'waiting';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nameEn;

    /**
     * @var string
     */
    private $nameEs;

    /**
     * @var string
     */
    private $descriptionEn;

    /**
     * @var string
     */
    private $descriptionEs;

    /**
     * @var integer
     */
    private $fileFileSize;

    /**
     * @var string
     */
    private $fileMimeType;

    /**
     * @var string
     */
    private $fileBaseName;

    /**
     * @var \Ivoz\Provider\Domain\Model\Brand\BrandDto | null
     */
    private $brand;

    /**
     * @var \Ivoz\Cgr\Domain\Model\TpDestinationRate\TpDestinationRateDto[] | null
     */
    private $tpDestinationRates = null;


    use DtoNormalizer;

    public function __construct($id = null)
    {
        $this->setId($id);
    }

    /**
     * @inheritdoc
     */
    public static function getPropertyMap(string $context = '')
    {
        if ($context === self::CONTEXT_COLLECTION) {
            return ['id' => 'id'];
        }

        return [
            'tag' => 'tag',
            'status' => 'status',
            'id' => 'id',
            'name' => ['en','es'],
            'description' => ['en','es'],
            'file' => ['fileSize','mimeType','baseName'],
            'brandId' => 'brand'
        ];
    }

    /**
     * @return array
     */
    public function toArray($hideSensitiveData = false)
    {
        return [
            'tag' => $this->getTag(),
            'status' => $this->getStatus(),
            'id' => $this->getId(),
            'name' => [
                'en' => $this->getNameEn(),
                'es' => $this->getNameEs()
            ],
            'description' => [
                'en' => $this->getDescriptionEn(),
                'es' => $this->getDescriptionEs()
            ],
            'file' => [
                'fileSize' => $this->getFileFileSize(),
                'mimeType' => $this->getFileMimeType(),
                'baseName' => $this->getFileBaseName()
            ],
            'brand' => $this->getBrand(),
            'tpDestinationRates' => $this->getTpDestinationRates()
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function transformForeignKeys(ForeignKeyTransformerInterface $transformer)
    {
        $this->brand = $transformer->transform('Ivoz\\Provider\\Domain\\Model\\Brand\\Brand', $this->getBrandId());
        if (!is_null($this->tpDestinationRates)) {
            $items = $this->getTpDestinationRates();
            $this->tpDestinationRates = [];
            foreach ($items as $item) {
                $this->tpDestinationRates[] = $transformer->transform(
                    'Ivoz\\Cgr\\Domain\\Model\\TpDestinationRate\\TpDestinationRate',
                    $item->getId() ?? $item
                );
            }
        }

    }

    /**
     * {@inheritDoc}
     */
    public function transformCollections(CollectionTransformerInterface $transformer)
    {
        $this->tpDestinationRates = $transformer->transform(
            'Ivoz\\Cgr\\Domain\\Model\\TpDestinationRate\\TpDestinationRate',
            $this->tpDestinationRates
        );
    }

    /**
     * @param string $tag
     *
     * @return static
     */
    public function setTag($tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $status
     *
     * @return static
     */
    public function setStatus($status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param integer $id
     *
     * @return static
     */
    public function setId($id = null)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $nameEn
     *
     * @return static
     */
    public function setNameEn($nameEn = null)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameEn()
    {
        return $this->nameEn;
    }

    /**
     * @param string $nameEs
     *
     * @return static
     */
    public function setNameEs($nameEs = null)
    {
        $this->nameEs = $nameEs;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameEs()
    {
        return $this->nameEs;
    }

    /**
     * @param string $descriptionEn
     *
     * @return static
     */
    public function setDescriptionEn($descriptionEn = null)
    {
        $this->descriptionEn = $descriptionEn;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

    /**
     * @param string $descriptionEs
     *
     * @return static
     */
    public function setDescriptionEs($descriptionEs = null)
    {
        $this->descriptionEs = $descriptionEs;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescriptionEs()
    {
        return $this->descriptionEs;
    }

    /**
     * @param integer $fileFileSize
     *
     * @return static
     */
    public function setFileFileSize($fileFileSize = null)
    {
        $this->fileFileSize = $fileFileSize;

        return $this;
    }

    /**
     * @return integer
     */
    public function getFileFileSize()
    {
        return $this->fileFileSize;
    }

    /**
     * @param string $fileMimeType
     *
     * @return static
     */
    public function setFileMimeType($fileMimeType = null)
    {
        $this->fileMimeType = $fileMimeType;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileMimeType()
    {
        return $this->fileMimeType;
    }

    /**
     * @param string $fileBaseName
     *
     * @return static
     */
    public function setFileBaseName($fileBaseName = null)
    {
        $this->fileBaseName = $fileBaseName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileBaseName()
    {
        return $this->fileBaseName;
    }

    /**
     * @param \Ivoz\Provider\Domain\Model\Brand\BrandDto $brand
     *
     * @return static
     */
    public function setBrand(\Ivoz\Provider\Domain\Model\Brand\BrandDto $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return \Ivoz\Provider\Domain\Model\Brand\BrandDto
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param integer $id | null
     *
     * @return static
     */
    public function setBrandId($id)
    {
        $value = !is_null($id)
            ? new \Ivoz\Provider\Domain\Model\Brand\BrandDto($id)
            : null;

        return $this->setBrand($value);
    }

    /**
     * @return integer | null
     */
    public function getBrandId()
    {
        if ($dto = $this->getBrand()) {
            return $dto->getId();
        }

        return null;
    }

    /**
     * @param array $tpDestinationRates
     *
     * @return static
     */
    public function setTpDestinationRates($tpDestinationRates = null)
    {
        $this->tpDestinationRates = $tpDestinationRates;

        return $this;
    }

    /**
     * @return array
     */
    public function getTpDestinationRates()
    {
        return $this->tpDestinationRates;
    }
}


