<?php

/* Putting the data model into it's own class is beneficial!
  That we can access the functions and data members later from the main application page. */

class FxDataModel {

    //For lab 3, we are gonna keep the currency codes hardcoded as a static array.
    private static $FX_CURRENCIES = array('CAD', 'EUR', 'GBP', 'USD');
    /* For lab 3, we are gonna hardcode the currency exchange rates as a static multi-dimensional array. 
     * Note that 1.0 represents the source & dest currency being equivalent. */
    private static $FX_RATES = array(
        array(1.0, 0.624514066, 0.588714763, 0.810307), //CAD to CAD, CAD to EUR, CAD to GBP, CAD to USD
        array(1.601244959, 1.0, 0.942676548, 1.2975), //EUR to CAD, EUR to EUR, EUR to GBP, EUR to USD
        array(1.698615463, 1.060809248, 1.0, 1.3764), //GBP to CAD, GBP to EUR, GBP to GBP, GBP to USD
        array(1.234100162, 0.772200772, 0.726532984, 1.0) //USD to CAD, USD to EUR, USD to GBP, USD to USD
    );

    //Static function that returns the array of currency codes to the form.
    public static function getFxCurrencies() {
        return self::$FX_CURRENCIES; //PHP keyword double colon (::) is used between a static class and a static fnction or variable. Self refers to the current class.
    }

    //Static function that returns the appropriate value in the multi-dimensional array of currency exchange rates given a source currency code and a destination currency code.
    public static function getFxRate($sourceCurrency, $destCurrency) {//the source and destination currency arguments are chosen from the drop down on the form.
        $in = 0;
        $len = count(self::$FX_CURRENCIES); //Whatever the length of the FX_CURRENCIES array is. Not hardcoded number because what if we change the array or later reference from a file or DB?
        $out = 0;

        for (; $in < $len; $in++) {//As long as the index on the array ($in) is less than the length of the currency codes array...
            if (self::$FX_CURRENCIES[$in] == $sourceCurrency) {//Only stop parsing the array once the index is reached that matches the user's selected source currency.
                break;
            }
        }

        for (; $out < $len; $out++) { //As long as the index on the array ($out) is less than the length of the currency codes array...
            if (self::$FX_CURRENCIES[$out] == $destCurrency) { //Only stop parsing the array once the index is reached that matches the user's chosen dest currency.
                break;
            }
        }

        return self::$FX_RATES[$in][$out];
    }

}

?>
