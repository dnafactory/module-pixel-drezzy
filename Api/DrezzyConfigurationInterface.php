<?php

namespace DNAFactory\PixelDrezzy\Api;

interface DrezzyConfigurationInterface
{
    public function getMerchantKey(): string;
    public function isOrderPixelEnabled(): string;
}
