<?php

namespace Ecpay\General\Plugin\Model\Method;

use Magento\OfflinePayments\Model\Cashondelivery as BaseCod;
use Magento\Quote\Api\Data\CartInterface;

class Cashondelivery extends BaseCod
{
    public function afterIsAvailable(BaseCod $subject, $result, ?CartInterface $quote = null)
    {
        // 如果沒有 quote 或原本就不可用，直接回傳
        if (!$result || !$quote) {
            return $result;
        }

        // 取得物流方式
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod();

        if ($quote && $shippingMethod == 'ecpaylogistichometcat_ecpaylogistichometcat' && $quote->getGrandTotal() > 20000) {
            return false; // 超過金額就不允許 COD
        }
        return $result;
    }
}
