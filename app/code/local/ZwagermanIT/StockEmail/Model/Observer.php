<?php

Mage::log("Voorraad check is gedaan", null, "voorraad_check.log");

class ZwagermanIT_StockEmail_Model_Observer
{
public function voorraadcheck($observer)

    {
 $stockItem = $observer->getEvent()->getItem();
 
 //oude manier om voorraad aantal te vergelijken met notify van Magento
 //if($stockItem->getQty() == $stockItem->getNotifyStockQty()){
 
if ($stockItem->getisinstock() == "0") { 

  //voorraad is lager dan het notify aantal, mail versturen
                                   
$product = Mage::getModel('catalog/product')->load($stockItem->getProductId());
   $body = "Hallo Lennard en Paul,<br><br>";
   $body .= "{$product->getName()} :: {$product->getSku()} is niet langer op voorraad:\n";
   $body .= "<br>Huidig aantal in shop: {$stockItem->getQty()}\n";
   $body .= "<br>Wanneer is dit product uit voorraad gegaan: {$stockItem->getLowStockDate()}\n";
   $body .= "<br><br>Groeten van de voorraadbeheerder\n";
      
    $mail = new Zend_Mail();
    $mail->setType(Zend_Mime::MULTIPART_RELATED);
    $mail->setBodyHtml($body);
    $mail->setFrom('info@ipcam-shop.nl', 'Voorraadbeheerder IPcam-Shop');
    $mail->addTo('info@ipcam-shop.nl', 'Lennard en Paul');
    $mail->setSubject("[Melding] {$product->getSku()} is niet langer op voorraad");
    $mail->send();
   }
     }
      }
