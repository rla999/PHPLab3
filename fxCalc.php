<!DOCTYPE html>
<?php
//Import our FX Data Model class into the form page so that we can refer to it's variables and functions.
require_once( 'FxDataModel.php' );

//Setting a variable for the array of currency codes from the data model class. Used in tandem with looping to populate the drop down menus for source and dest currency.
$fxCurrencies = fxDataModel::getFxCurrencies();

//Get the amount of the source currency from the text field (user input) using the special $_POST array. htmlspecialchars is there to prvent malicious Javascript attacks!
$sourceAmount = htmlspecialchars($_POST['sourceAmount']);

//Validation to gracefully deal with invalid data; i.e. non-numeric characters. Blanks the form out instead of throwing nasty PHP exceptions in the browser!
if (is_numeric($sourceAmount)) {//If user inputted source currency amount is a valid number...
    $destCurrency = $_POST['destCurrency']; //Continue and set the destination currency using the value that the user chose from the drop down menu.
    $sourceCurrency = $_POST['sourceCurrency']; //Set the source currency using the value chosen by the user from the drop down list.

    $destAmount = fxDataModel::getFxRate($sourceCurrency, $destCurrency) * $sourceAmount; //Calculate the amount in the destination currency using the array of rates and the user provided values for the currency codes and the source amount.
} else { //In the case of invald data...reset the form to the initial state. Equivalent to clicking the reset button on the bottom of the form.
    $destAmount = ''; //Blank out the destination amount.
    $destCurrency = $fxCurrencies[0]; //Reset the destination currency to CAD or whatever the 0 index's value is.
    $sourceAmount = ''; //Blank out the source amount text field.
    $sourceCurrency = $fxCurrencies[0]; //Reset the source currency to CAD or whatever the 0 index' value is.
}
?>

<!--Start of the HTML form!-->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Ryan's F/X Calculator</title>
        <link href="css/main.css" rel="stylesheet" type="text/css"/> <!--Link the CSS to the page.-->
    </head>

    <body>
        <header>
            <h1>Ryan's Super F/X Calculator</h1>
        </header>
        <br/>
        <main>
            <form name="fxCalc" action="fxCalc.php" method="post"> 
                <!--Use the POST method to send form data! Sends it to the PHP form. 
                If on HTML file it will redirect to the PHP form in the background to show calculation results. 
                The two forms look identical in style and formatting.-->

                <h3>Choose your source currency code and enter the amount as precise as you want it.</h3>
                <!--Drop down for source currency code selection.-->
                <select name="sourceCurrency">
                    <?php
//                Iterate through the array of currency codes to populate the drop down menu dynamically.
                    foreach ($fxCurrencies as $fxCurrency) {
                        ?>
                        <option value="<?php echo $fxCurrency ?>"

                                <?php
//                            Ensure that the currency code value selected by the user is sent to the form and still shown as the selected option post-submission.
                                if ($fxCurrency === $sourceCurrency) {
                                    ?>   
                                    selected
                                    <?php
                                }
                                ?>
                                <!--The command to actually print the list.-->
                                <?php echo $fxCurrency ?></option>
                                <?php
                            }
                            ?>
                </select>
                <!--Text field for the source currency amount. The value attribute is dynamically filled by PHP. Reminder: validation is performed at the top of the code.-->
                <input type="text" name="sourceAmount" value="<?php echo $sourceAmount ?>" class="textField"/>
                <br/>

                <h3>Now choose your destination currency code and click CALCULATE to receive your result!</h3>
                <!--Drop down for destination currency code selection.-->
                <select name="destCurrency">
                    <?php
//                Iterate through the array of currency codes to populate the drop down menu dynamically.
                    foreach ($fxCurrencies as $fxCurrency) {
                        ?>
                        <option value="<?php echo $fxCurrency ?>"

                                <?php
//                            Ensure that the currency code value selected by the user is sent to the form and still shown as the selected option post-submission.
                                if ($fxCurrency === $destCurrency) {
                                    ?>
                                    selected
                                    <?php
                                }
                                ?>
                                <!--The command to actually print the list.-->
                                <?php echo $fxCurrency ?></option>

                        <?php
                    }
                    ?>
                </select>
                <!--Read only text field for the destination currency amount. The value attribute is dynamically filled by PHP.-->
                <input type="text" name="destAmount" disabled="disabled" value="<?php echo $destAmount ?>" class="textField"/>

                <br/><br/>
                <!--Submit our form for calcuation. After the first submission the user is sent to and will remain on the PHP form unless they click Reset.-->
                <input type="submit" value="CALCULATE" class="button"/>
                <!--Clear all text fields, resets the drop down menus to display the 0 index value of the array and sends user back to the HTML file.-->
                <input type="reset" value="RESET" onclick="window.location.href = 'fxCalc.html'" class="button"/>

            </form>
        </main>

        <br/>

        <footer>
            <p>Copyright (c) 2019 Ryan Lasher. Unauthorized copying of my student work is not the right thing to do, but be inspired by the way I designed my page and come up with your own creative implementation!</p>
        </footer>
    </body>
</html>
