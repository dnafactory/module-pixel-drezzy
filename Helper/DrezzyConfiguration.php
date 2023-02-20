<?php

namespace DNAFactory\PixelDrezzy\Helper;

class DrezzyConfiguration extends \Magento\Framework\App\Helper\AbstractHelper implements \DNAFactory\PixelDrezzy\Api\DrezzyConfigurationInterface
{
    const XML_DREZZY_GENERAL_MERCHANT_KEY = 'dna_drezzy/general/merchant_key';
    const XML_DREZZY_CHECKOUT_PIXEL_ENABLED = 'dna_drezzy/order_pixel/enabled';
    public function getMerchantKey($scopeConfig = \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $scopeCode = null): string
    {
        return $this->getConfig(self::XML_DREZZY_GENERAL_MERCHANT_KEY, $scopeConfig, $scopeCode);
    }
    public function isOrderPixelEnabled($scopeConfig = \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $scopeCode = null): string
    {
        return boolval($this->getConfig(self::XML_DREZZY_CHECKOUT_PIXEL_ENABLED, $scopeConfig, $scopeCode)?? false);
    }

    protected function getConfig($config, $scopeConfig = \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $scopeCode = null)
    {
        return $this->scopeConfig->getValue($config, $scopeConfig, $scopeCode);
    }
}
