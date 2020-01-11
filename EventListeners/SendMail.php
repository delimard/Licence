<?php

namespace Licence\EventListeners;

use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Log\Tlog;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\OrderProductQuery;
use Thelia\Model\ProductQuery;
use Licence\Model\LicenceQuery;
use Licence\Model\Licence;
use Licence\Event\LicenceEvents;
use Licence\Model\Base\Licence as BaseLicence;
use Licence\Model\Base\LicenceQuery as BaseLicenceQuery;


class SendMail implements EventSubscriberInterface
{
     /** @var MailerFactory */
     protected $mailer;

     /** @var EventDispatcherInterface */
     protected $eventDispatcher;
 
     public function __construct(MailerFactory $mailer, EventDispatcherInterface $eventDispatcher)
     {
         $this->mailer = $mailer;
         $this->eventDispatcher = $eventDispatcher;
     }

    public function createKeys(OrderEvent $event)
    {
        $order = $event->getOrder();
        $orderId = $event->getOrder()->getId();
        $customerId= $event->getOrder()->getCustomerId();
        $dateExpiration=$event->getOrder()->getInvoiceDate()->add(date_interval_create_from_date_string('+1 Year'));

        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $segment_chars = 5;
        $num_segments = 4;
        $key_string = '';

        for ($i = 0; $i < $num_segments; $i++) 
        {
         $segment = '';
         for ($j = 0; $j < $segment_chars; $j++) {
         $segment .= $tokens[rand(0, 35)];
        }
        $key_string .= $segment;
        if ($i < ($num_segments - 1)) 
        {
        $key_string .= '-';
        }
        }

        if ($order->hasVirtualProduct() && $order->isPaid(true)) 
        {
            $produitsCommandes = OrderProductQuery::create()->findByOrderId($orderId);
            
            
            /** @var OrderProduct $produitCommande */
            foreach ($produitsCommandes as $produitCommande) {
                
                $produit=ProductQuery::create()->findOneByRef($produitCommande->getProductRef());
                $idproduit=$produit->getId();
                $licencesFind = LicenceQuery::create()->filterByCustomerId($customerId)->findOneByProductId($idproduit);
                if(null!==$licencesFind){
                $licenceOrder= $licencesFind->getOrderId();
                }
                if(empty($licencesFind)){
                    $licence= new licence;
                    $licence
                    ->setOrderId($orderId)
                    ->setCustomerId($customerId)
                    ->setProductId($idproduit)
                    ->setProductKey($key_string)
                    ->setExpirationDate($dateExpiration)
                    ->save();
                }
                else {
                    
                    if(!empty($licencesFind) && $licenceOrder==$orderId) {
                   }
                   else {
                    $keyexist=$licencesFind->getProductKey();
                    $dateExist=$licencesFind->getExpirationDate();
                    if($dateExist>$dateExpiration){
                        $newdate=$dateExist;
                    }
                    else {
                        $newdate=$dateExpiration;
                    }
                    $licence= new licence;
                    $licence
                    ->setOrderId($orderId)
                    ->setCustomerId($customerId)
                    ->setProductId($idproduit)
                    ->setProductKey($keyexist)
                    ->setExpirationDate($newdate)
                    ->save();
                   }
                 
                

                }
            }    
      
        }
        if ($order->hasVirtualProduct() && $order->isCancelled(true)) {
        $licencesDelete = LicenceQuery::create()->findByOrderId($orderId);

        /** @var Licence as $LicenceDelete */
            foreach($licencesDelete as $LicenceDelete) {
            $licence= $licencesDelete;
            $licence
            ->delete();

            }
        }
    }
    public function sendEmail(OrderEvent $event)
    {
        $order = $event->getOrder();


        if ($order->hasVirtualProduct() && $order->isPaid(true)) {
            $customer = $order->getCustomer();

            $this->mailer->sendEmailToCustomer(
                'mail_licence',
                $customer,
                [
                    'customer_id' => $customer->getId(),
                    'order_id' => $order->getId(),
                    'order_ref' => $order->getRef(),
                    'order_date' => $order->getCreatedAt(),
                    'update_date' => $order->getUpdatedAt()
                ]
            );
        } else {
            Tlog::getInstance()->warning(
                "No licence generated"
            );
        }
    } 



  
    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    
    public static function getSubscribedEvents()
    {
        return array(
            TheliaEvents::ORDER_UPDATE_STATUS => array(array("createKeys", 128),array("sendEmail", 128))
        );
    }

}