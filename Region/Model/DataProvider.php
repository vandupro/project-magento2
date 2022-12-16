<?php declare(strict_types=1);


namespace Cowell\Region\Model;

use Cowell\Region\Model\ResourceModel\Region;
use Cowell\Region\Model\ResourceModel\Region\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var
     */
    protected $collection;

    /**
     * @var
     */
    protected $loadedData;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Region
     */
    protected $resourceModel;
    /**
     * Constructor
     *
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Cowell\Region\Model\ResourceModel\Region $resourceModel,
        array $meta = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->resourceModel = $resourceModel;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $data = $model->getData();
            $data['dynamic_rows'] = $this->resourceModel->getRegionName($model['region_id']);
            $this->loadedData[$model->getId()] = $data;
            $fullData = $this->loadedData;
            $this->loadedData[$model->getId()] = $fullData[$model->getId()];
        }
        $data = $this->dataPersistor->get('cowell_region_index');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('cowell_region_index');
        }

        return $this->loadedData;
    }
}

