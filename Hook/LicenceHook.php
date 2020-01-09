<?php

namespace Licence\Hook;
use Licence\Model\Licence;
use Licence\Model\LicenceQuery;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Model\BrandQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\Lang;
use Thelia\Model\LangQuery;
use Thelia\Model\ProductQuery;
class LicenceHook extends BaseHook
{
    public function ReadLicence(HookRenderEvent $event)
    {
        $orderId = $event->getArgument('order_id');
        $params =  ['order_id' => $orderId];

        $licencefind= LicenceQuery::create()->findOneByOrderId($orderId);
        if(null !== $licencefind){
            $params['product_id']=$licencefind->getProductId();
            $params['product_key']= $licencefind->getProductKey();
            $params['expiration_date']=$licencefind->getExpirationDate();
        }
        $event->add(
            $this->render(
                "read-licence.html", $params     
            )
        );
    }
}