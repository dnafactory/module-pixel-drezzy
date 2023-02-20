<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace DNAFactory\PixelDrezzy\Block\Checkout;

use DNAFactory\PixelDrezzy\Api\DrezzyConfigurationInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Template\Context;

class Pixel extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Framework\App\Http\Context
     */
    protected $httpContext;

    /**
     * @var \Magento\Sales\Model\Order
     */
    protected $order;
    /**
     * @var DrezzyConfigurationInterface
     */
    protected $configuration;

    /**
     * @param Context $context
     * @param Session $checkoutSession
     * @param DrezzyConfigurationInterface $configuration
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        DrezzyConfigurationInterface $configuration,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_checkoutSession = $checkoutSession;
        $this->configuration = $configuration;
        $this->httpContext = $httpContext;
    }


    protected function getOrder(){
        if(!$this->order)
            $this->order = $this->_checkoutSession->getLastRealOrder();
        return $this->order;
    }

    protected function _toHtml()
    {
        if(!$this->configuration->isOrderPixelEnabled() || empty($this->configuration->getMerchantKey())){
            return '';
        }
        $ordObj = $this->getOrder();
        $products = $ordObj->getAllVisibleItems();
        $TPtpi['chiaveMerchant'] = $this->configuration->getMerchantKey();
        $TPtpi['orderid'] = $ordObj->getIncrementId();
        $TPtpi['amount'] = number_format ( $ordObj['grand_total'] , 2, '.','');
        $i = 0;
        $product_names_and_sku = "";
        foreach($products as $prod){
            $singleProd = $prod->getData();
            $prodName = str_replace("'", "", $singleProd['name']);
            $product_names_and_sku = $product_names_and_sku . "&items[" . $i . "][sku]=" . $singleProd['item_id'] . "&items[" . $i . "][product_name]=" . $prodName;
            $i = $i + 1;
        }
        return "<img src=\"https://www.drezzy.it/api/orders/v1.0/tr.gif?merchant_name=".$TPtpi['chiaveMerchant']."&order_id=".$TPtpi['orderid'].$product_names_and_sku."&amount=".$TPtpi['amount']."\" width=1 height=1 style=\"border:none\">";
    }


}
