<?php

/**
 * Create and parse rates from JSON obj
 *
 * @author Taxjar (support@taxjar.com)
 */
class Taxjar_SalesTax_Model_Rate {

  /**
   * Try to create the rate
   *
   * @param JSON $string
   * @return array
   */
  public function create( $rateJson ) {
    try {
      $zip        = $rateJson['zip'];
      $regionCode = $rateJson['state'];
      $rate       = $rateJson['rate'];

      if ( isset( $rateJson['country'] ) ) {
        $countryCode = $rateJson['country'];
      }
      else {
        $countryCode = 'US';
      }

      $regionId  = Mage::getModel('directory/region')->loadByCode($regionCode, $countryCode)->getId();
      $rateModel = Mage::getModel('tax/calculation_rate');

      $rateModel->setTaxCountryId($countryCode);
      $rateModel->setTaxRegionId($regionId);
      $rateModel->setTaxPostcode($zip);
      $rateModel->setCode($countryCode . '-' . $regionCode . '-' . $zip);
      $rateModel->setRate($rate);
      $rateModel->save();

      if ( $rateJson['freight_taxable'] ) {
        $shippingRateId = $rateModel->getId();
      }
      else {
        $shippingRateId = 0;
      }

      return array( $rateModel->getId(), $shippingRateId );
    }
    catch ( Exception $e ) {
      unset( $rateModel );
      return;
    }
  }  
  
}
?>