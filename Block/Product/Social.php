<?php

namespace Riverstone\Quickview\Block\Product;

class Social extends \Magento\Catalog\Block\Product\View
{
    protected const XML_PATH_QUICKVIEW_REMOVE_PRODUCT_INFOR_MAILTO = 'riverstone_quickview/general/
    remove_product_info_mailto';

    /**
     * Retrieve the configuration value for showing email.
     *
     * @return string|null
     */
    public function getConfigShowEmail()
    {
        return $this->_scopeConfig->getValue(
            self::XML_PATH_QUICKVIEW_REMOVE_PRODUCT_INFOR_MAILTO,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getId()
        );
    }
}
