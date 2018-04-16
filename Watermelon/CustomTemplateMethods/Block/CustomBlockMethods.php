<?php


namespace Watermelon\CustomTemplateMethods\Block;
use Magento\Framework\View\Element\Template;

class CustomBlockMethods extends Template
{

    protected $_categoryFactory;  

    protected $_reviewFactory;

    protected $_storeManager;

    protected $_reviewsColFactory;

    public function __construct(
    \Magento\Catalog\Model\CategoryFactory $categoryFactory,
    \Magento\Review\Model\ReviewFactory $reviewFactory,
    \Magento\Store\Model\StoreManagerInterface $storeManager,
    \Magento\Review\Model\ResourceModel\Review\CollectionFactory $collectionFactory,
    \Magento\Framework\View\Element\Template\Context $context
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_reviewFactory = $reviewFactory;
        $this->_storeManager = $storeManager;
        $this->_reviewsColFactory = $collectionFactory;
        parent::__construct($context);
    }


    public function getCategoryName()
    {
        $categoryId = '43';
        $category = $this->_categoryFactory->create()->load($categoryId);
        $categoryName = $category->getName();
        return $categoryName;
    }
    public function getCategoryNameById($id)
    {
        $categoryId = $id;
        $category = $this->_categoryFactory->create()->load($categoryId);
        $categoryName = $category->getName();
        return $categoryName;
    }

    public function getRatingSummary($product)
    {
        $this->_reviewFactory->create()->getEntitySummary($product, $this->_storeManager->getStore()->getId());
        $ratingSummary = $product->getRatingSummary()->getRatingSummary();

        return $ratingSummary;
    }
    public function getRatingCount($product)
    {
                $collection = $this->_reviewsColFactory->create()->addStoreFilter(
                        $this->_storeManager->getStore()->getId()
                )->addStatusFilter(
                        \Magento\Review\Model\Review::STATUS_APPROVED
                )->addEntityFilter(
                'product', $product->getId()
        );

        return $collection->getSize();
    }

	/**
     * @return string
     */
    public function amILoaded()
    {
        //Your block code
        return '<!-- CustomBlockMethods Loaded -->';
    }


}
