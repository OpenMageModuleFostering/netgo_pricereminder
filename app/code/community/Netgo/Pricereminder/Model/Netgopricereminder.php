<?php
/***************************************
 *** Price Drop Notifier ***
 ***************************************
 *
 * @copyright   Copyright (c) 2015
 * @company     NetAttingo Technologies
 * @package     Netgo_Pricereminder
 * @author 		NetGo
 * @dev			netattingomails@gmail.com
 *
 */
class Netgo_Pricereminder_Model_Netgopricereminder
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'netgo_pricereminder_netgopricereminder';
    const CACHE_TAG = 'netgo_pricereminder_netgopricereminder';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'netgo_pricereminder_netgopricereminder';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'netgopricereminder';
    /**
     * constructor
     * @access public
     * @return void
     * @author NetGo
     */
    public function _construct(){
        parent::_construct();
        $this->_init('netgo_pricereminder/netgopricereminder');
    }
    /**
     * before save netgopricereminder
     * @access protected
     * @return Netgo_Pricereminder_Model_Netgopricereminder
     * @author NetGo
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
    /**
     * get the url to the netgopricereminder details page
     * @access public
     * @return string
     * @author NetGo
     */
    public function getNetgopricereminderUrl(){
        if ($this->getUrlKey()){
            $urlKey = '';
            if ($prefix = Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/url_prefix')){
                $urlKey .= $prefix.'/';
            }
            $urlKey .= $this->getUrlKey();
            if ($suffix = Mage::getStoreConfig('netgo_pricereminder/netgopricereminder/url_suffix')){
                $urlKey .= '.'.$suffix;
            }
            return Mage::getUrl('', array('_direct'=>$urlKey));
        }
        return Mage::getUrl('netgo_pricereminder/netgopricereminder/view', array('id'=>$this->getId()));
    }
    /**
     * check URL key
     * @access public
     * @param string $urlKey
     * @param bool $active
     * @return mixed
     * @author NetGo
     */
    public function checkUrlKey($urlKey, $active = true){
        return $this->_getResource()->checkUrlKey($urlKey, $active);
    }

    /**
     * save netgopricereminder relation
     * @access public
     * @return Netgo_Pricereminder_Model_Netgopricereminder
     * @author NetGo
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }
    /**
     * get default values
     * @access public
     * @return array
     * @author NetGo
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
	
	public function getHeaders($email){
		
				// Always set content-type when sending HTML email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: <'.$email.'>' . "\r\n";
				return $headers;
	}
	/*
	 
	*/
	public function getMailHtml($newproduct,$mailheading,$emailid,$oldprice){
      	$title = $newproduct->getData('title'); 
		
		$description = $newproduct->getData('description');
		$newprice = $newproduct->getData('price');
		$urlpath = $newproduct->getData('url_path');
		$baseurl = str_replace('index.php/','',Mage::getBaseUrl());
		$unsubscribeONEUrl = $baseurl."netgo_pricereminder/netgopricereminder/unsubscribeOne?emailid=".$emailid."&productid=". $newproduct->getId()."";
		$unsubscribeALLUrl= $unsubscribeONEUrl = $baseurl."netgo_pricereminder/netgopricereminder/unsubscribeAll?emailid=".$emailid;
		$producturl= $baseurl.$urlpath;
		
		$header_bg_color =Mage::getStoreConfig('netgo_pricereminder/emailsettings/headcolor');
		$header_bg_color =(trim($header_bg_color)=='')?'#23c1da':$header_bg_color;
		$header_txt_color =Mage::getStoreConfig('netgo_pricereminder/emailsettings/headtextcolor');
		$header_txt_color =(trim($header_txt_color)=='')?'#ffffff':$header_txt_color;
		
		  $imageurl = $baseurl.'media/catalog/product'.$newproduct->getData('image'); 
		//echo '<pre>';print_r($newproduct->getData());die;
 	$message = "<div style=\"font-family: font-family: 'Helvetica Neue',Verdana,Arial,sans-serif; font-size: 13px; font-weight: bold;\">
<div style=\"font-size: 21px; font-weight: bold; background: ".$header_bg_color ." none repeat scroll 0% 0%; color: ".$header_txt_color."; text-align: center; padding: 20px 0px; margin-bottom: 10px; font-family: arial;\"><span>Hurray!!!</span><br /> ".$mailheading."</div>
<form>
<div style=\"display: block; float: left; width: 100%; margin: 10px 0px 20px; font-weight: bold; text-transform: uppercase; border-bottom: 1px solid #000000;\"><span style=\"float: left; margin-bottom: 5px; color: #000000; font-size: 17px;\">".$title."</span></div>
<div style=\"margin-bottom: 10px; float: left; padding-right: 0px; width: 25%;\">
<div style=\"border: 1px solid #ededed; display: block; position: relative; margin-bottom: 10px;\">
<div style=\"position: relative;\">
     <img style=\"display: block; margin: 0px auto; max-width: 100%; max-height: 100%; width: 100%;\" title=\"lorem ipsume test product\" alt=\"lorem ipsume test product\" src=\"".$imageurl."\" />
</div>
</div>
</div>
<div style=\"margin-bottom: 10px; width: 68%; border: 1px solid #000000; padding: 15px; float: right; font-weight: bold;\">
<div style=\"margin-bottom: 10px; padding-left: 0px; float: left; width: 100%;\">
<div style=\"float: left; margin-bottom: 10px; max-width: 70%; padding: 0;\">
<div style=\"margin-top: 0;\">
<p style=\"margin-bottom: 10px; line-height: 1.2; padding-right: 0px; display: inline-block; font-style: normal; font-family: Arial;\"><span id=\"old-price-1\" style=\"color: #000; text-decoration: line-through; font-weight: bold;\">$".number_format($oldprice,2)."</span></p>
<p style=\"margin: 0px; color: #3399cc; padding-left: 1em; line-height: 1.2; padding: 0;\"><span id=\"product-price-1\" style=\"font-size: 24px; font-style: normal; color: #000000; float: left; padding: 0; font-family: arial; font-weight: bold;\">$".$newprice."</span></p>
</div>
</div>
<div style=\"float: left; margin-bottom: 5px; max-width: 70%; padding: 0; clear: left;\">
<p style=\"font-size: 16px; color: #11b400; margin: 0; text-transform: uppercase;\">
	<span style=\"font-size: 16px; font-style: normal; font-family: arial; font-weight: bold;\">In stock</span>
 </p>
</div>
<div style=\"clear: both; margin-bottom: 5px; color: #000000;\">
<div>".$description."</div>
</div>
<div style=''><a href='".$producturl."' target='_BLANK' style='background: rgb(0, 0, 0) none repeat scroll 0% 0%; color: rgb(255, 255, 255); margin-top: 10px; display: inline-block; text-decoration: none; padding: 8px 15px; text-transform: uppercase; font-weight: bold;font-size:14px;'>View Product</a></div>
</div>
</div>
<div style=\"font-weight: bold; float: left; width: 100%; border-top: 1px solid #cccccc; padding-top: 10px; margin-top: 10px;\">
<div style=\"font-weight: bold; color: #8d8d8d; width: 100%; font-family: arial;\">Click <a style=\"color: #3399cc;\" href=\"".$unsubscribeONEUrl."\">here</a> if you wish not to be notified for this product</div>
<div style=\"font-weight: bold; color: #8d8d8d; width: 100%; font-family: arial;\">Click <a style=\"font-weight: bold; color: #3399cc;\" href=\"".$unsubscribeALLUrl."\">here</a> to unsubscribe from all products</div>
</div>
</form>

</div>";

	return $message;	
		
	}
	
	
	public function catalog_product_save_before($observer){
		$product = $observer->getProduct();	
		$newproduct = $observer->getProduct();
		$productId = $product->getId();
        $oldproduct = Mage::getModel('catalog/product')->load($newproduct->getId());
           //echo '<pre>';print_r($newproduct->getData());die;
        if ($oldproduct->getData('price') != $newproduct->getData('price')){
			$newprice = $newproduct->getData('price');
			$oldprice = $oldproduct->getData('price');
             //IF PRICE CHANGED THEN GET ALL NOTIFY REQUEST AND SEND MAILS TO THEM
			 $rmodel = Mage::getModel('netgo_pricereminder/netgopricereminder');
			 
			 $fixedcollection = $rmodel->getCollection()->addFieldToFilter('status',1) 
			                                                             ->addFieldToFilter('isfixed',1) 
																         ->addFieldToFilter('productid',$oldproduct->getId())->load();
			  $variablecollection = $rmodel->getCollection()->addFieldToFilter('status',1) 
																			  ->addFieldToFilter('isvariable',1) 
																			  ->addFieldToFilter('productid',$oldproduct->getId())->load();
		     $fixData = $fixedcollection->getData(); 
          	 $varData = $variablecollection->getData();	  
             //ITERATE THROUGH DATA AND SEND MAILS
			 
			 //SEND MAILS FOR FIXED PRICE SUBSCRIPTION
			 $adminemail=Mage::getStoreConfig('trans_email/ident_general/email');;
              foreach($fixData as $key=>$value){
				          $dataprice = number_format($value['rprice'],2);
				          $newprice = number_format($newprice,2);
						  
				                if($dataprice==$newprice ){
									//send mail
									 $emailid = $value['emailid'];
									 $prodId =  $productId;
									 $subject = "Contratulations!!! Our Product got cheaper, as you wished";
									 $mailheading = 'The Product, you have subscribed for is now available at your desired Price.';
									 $price =  Mage::helper('core')->currency($newproduct->getData('price'), true, false);
									 $mailhtmlcontent = $this->getMailHtml($newproduct,$mailheading,$emailid,$oldprice);
									 $headers = $this->getHeaders($adminemail);
									 
									mail($emailid,$subject,$mailhtmlcontent,$headers);
								}
			  }

			   //SEND MAILS FOR VARIABLE PRICE SUBSCRIPTIONS
			    foreach($varData as $key=>$value){
				          $dataprice = number_format($value['rprice'],2);
				          $newprice = number_format($newprice,2);
						  
				                if($newprice<$dataprice){ 
									//send mail
									$emailid = $value['emailid'];
									 $subject = "Contratulations!!! Our Product got cheaper, as you wished";
									$mailheading = 'The Product, you have subscribed for is now available for a new lower price.';
									 $price =  Mage::helper('core')->currency($newproduct->getData('price'), true, false);
									 $mailhtmlcontent = $this->getMailHtml($newproduct,$mailheading,$emailid,$oldprice);
									 $headers = $this->getHeaders($adminemail);
								     mail($emailid,$subject,$mailhtmlcontent,$headers);
								}
			  } 
                 //GET ALL VARIABLE CHOSEN OPTION AND SEND MAIL			  
        }else{
			   echo "price doesn't changed!!! do nothing";
		}
		 
    }	 
}
