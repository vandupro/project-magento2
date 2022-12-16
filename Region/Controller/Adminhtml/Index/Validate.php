<?php
namespace Cowell\Region\Controller\Adminhtml\Index;

use Cowell\Region\Model\ResourceModel\Region\CollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Serialize\Serializer\Json;

class Validate extends Action
{
    /**
     * @var Json
     */
    protected $_json;
    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;
    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    public function __construct(
        Context $context,
        Json $json,
        JsonFactory $resultJsonFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->_json = $json;
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $request = $this->getRequest()->getParams();
        $regionCode = $request["code"];
        $regionCountry = $request["country_id"];
        $resultJson = $this->_resultJsonFactory->create();
        $validatedResponse = new \Magento\Framework\DataObject();
        $collection = $this->_collectionFactory->create()->addFieldToFilter('code', $regionCode)->getData();
        foreach ($collection as $key=>$value) {
            $oldCountry = $value['country_id'] ?? '';
            if ($regionCountry && $oldCountry == $regionCountry) {
                if ($collection->getSize() > 0) {
                    $validatedResponse->setError(true);
                    $validatedResponse->setMessages( 'This country code was taken');
                }
            }
        }
        return $resultJson->setData($validatedResponse);
    }
}
