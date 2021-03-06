<?php
/**
 * Taxjar_SalesTax
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Taxjar
 * @package    Taxjar_SalesTax
 * @copyright  Copyright (c) 2016 TaxJar. TaxJar is a trademark of TPS Unlimited, Inc. (http://www.taxjar.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

 /**
  * TaxJar Categories Model
  * Populates tax category dropdown under 
  */
class Taxjar_SalesTax_Model_Categories
{
    /**
     * Populate dropdown options
     *
     * @param void
     * @return array
     */
    public function toOptionArray()
    {
        $categories = json_decode(Mage::getStoreConfig('tax/taxjar/categories'), true);
        $categories = Mage::helper('taxjar')->array_sort($categories, 'product_tax_code', SORT_ASC);

        $output = array(
            array(
                'label' => 'None',
                'value' => ''
            )
        );

        foreach($categories as $category) {
            $output[] = array(
                'label' => $category['name'] . ' (' . $category['product_tax_code'] . ')',
                'value' => $category['product_tax_code']
            );
        }

        return $output;
    }
}
