<?php

namespace Riverstone\Quickview\Block;

use Exception;

class Initialize extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Riverstone\Quickview\Helper\Data
     */
    protected $helper;

    /**
     * @param \Riverstone\Quickview\Helper\Data $helper
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Riverstone\Quickview\Helper\Data $helper,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

    /**
     * Returns config
     *
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getConfig()
    {
        return [
            'baseUrl' => $this->getBaseUrl()
        ];
    }

    /**
     * Class Helper::Data
     *
     * @return \Riverstone\Quickview\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * Return base url.
     *
     * @codeCoverageIgnore
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getBaseUrl()
    {
        try {
            return $this->_storeManager->getStore()->getBaseUrl();
        } catch (Exception $e) {
            return null;
        }
    }
}
