<?php

namespace Riverstone\Quickview\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class Add
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    protected $redirectFactory;
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * Add constructor.
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        Context $context,
        StoreManagerInterface $storeManager,
        ProductRepositoryInterface $productRepository
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->context = $context;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * Redirects after adding a product to the comparison list if quick view is enabled.
     *
     * @param \Magento\Catalog\Controller\Product\Compare\Add $subject
     * @param \Magento\Framework\Controller\Result\Redirect $result
     * @return \Magento\Framework\Controller\Result\Redirect
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function afterExcute(\Magento\Catalog\Controller\Product\Compare\Add $subject, $result)
    {
        $resultRedirect = $this->redirectFactory->create();
        $productId = (int)$this->context->getRequest()->getParam('product');
        $storeId = $this->storeManager->getStore()->getId();
        try {
            $product = $this->productRepository->getById($productId, false, $storeId);
        } catch (NoSuchEntityException $e) {
            $product = null;
        }
        if ($product) {
            $params = $this->context->getRequest()->getParams();
            if (isset($params['riverstonequickview']) && $params['riverstonequickview'] == 1) {
                return $resultRedirect->setPath($product->getUrlModel()->getUrl($product));
            }
        }
        return $result;
    }
}
