<?php

namespace Riverstone\Quickview\Observer;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Layout;

/**
 * Class AddUpdateHandlesObserver
 *
 */
class UpdateHandlesObserver implements ObserverInterface
{
    protected const XML_PATH_QUICKVIEW_REMOVE_TAB = 'riverstone_quickview/general/remove_product_tab';
    protected const XML_PATH_QUICKVIEW_REMOVE_ADDTO_COMPARE = 'riverstone_quickview/general/remove_addto_compare';
    protected const XML_PATH_QUICKVIEW_REMOVE_ADDTO_WISHLIST = 'riverstone_quickview/general/remove_addto_wishlist';
    protected const XML_PATH_QUICKVIEW_REMOVE_REVIEWS = 'riverstone_quickview/general/remove_reviews';
    protected const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_RELATED = 'riverstone_quickview/general/remove_product_related';
    protected const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_UPSELL = 'riverstone_quickview/general/remove_product_upsell';
    protected const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_INFOR_MAILTO = 'riverstone_quickview/general/
    remove_product_info_mailto';
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }

    /**
     * Add New Layout handle
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return self
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $layout = $observer->getData('layout');
        $fullActionName = $observer->getData('full_action_name');

        if ($fullActionName != 'riverstone_catalog_product_view') {
            return $this;
        }

        $productId = $this->request->getParam('id');
        if (isset($productId)) {
            try {
                $product = $this->productRepository->getById(
                    $productId,
                    false,
                    $this->storeManager->getStore()->getId()
                );
            } catch (NoSuchEntityException $e) {
                return false;
            }

            $productType = $product->getTypeId();

            $layout->getUpdate()->addHandle('riverstone_catalog_product_view_type_' . $productType);
        }
        $this->quickViewRemove($layout);
        return $this;
    }

    /**
     * Quick view remove
     *
     * @param Layout $layout
     */
    protected function quickViewRemove($layout)
    {
        $removeTab = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_TAB,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($removeTab == 0) {
            $layout->getUpdate()->addHandle('riverstone_quickview_removeproduct_tab');
        }
        $removeAddToCompare = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_ADDTO_COMPARE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($removeAddToCompare == 0) {
            $layout->getUpdate()->addHandle('riverstone_quickview_remove_addtocompare');
        }
        $removeAddToWishList = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_ADDTO_WISHLIST,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($removeAddToWishList == 0) {
            $layout->getUpdate()->addHandle('riverstone_remove_addtowishlist');
        }
        $removeReviews = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_REVIEWS,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($removeReviews == 0) {
            $layout->getUpdate()->addHandle('riverstone_remove_reviews');
        }
        $removeProductRelated = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_PRODUCT_RELATED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($removeProductRelated == 0) {
            $layout->getUpdate()->addHandle('riverstone_remove_product_related');
        }
        $removeProductUpsell = $this->scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_PRODUCT_UPSELL,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($removeProductUpsell == 0) {
            $layout->getUpdate()->addHandle('riverstone_remove_product_upsell');
        }
        $layout->getUpdate()->addHandle('riverstone_product_info_mailto');
    }
}
