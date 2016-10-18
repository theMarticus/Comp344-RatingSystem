<?php

// Do not allow browser to cache this page.
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// NOTE. Apache on Windows can generate the following warning: Warning: fgets(): SSL: fatal protocol error in ...  This is not really fatal, so we set the following:
error_reporting(E_ERROR | E_PARSE);

/*
SecureXML Example.
----------------------------
This example is based on the SecureXML documentation and should be used in conjunction with that documentation. Please feel free to edit this code to suit your own requirements. This example comes with no warranty or support. Use at your own risk.
*/


switch ($_GET[pageid])
{
	case "":
?>
	<html>
	<head>
		<title>SecureXML Example Payment Page.</title>
	</head>

	<body>
		<form method="post" action="SecureXML_PHP_Basic_example.php?pageid=process">

		<table cellspacing="0" cellpadding="5" border="1">
		<tr>
			<td colspan="2" align="center"><h2>SecureXML Example</h2></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><h4>Payment Details</h4></td>
		</tr>
		<tr>
			<td>Request Type:</td>
			<td>
				<select name="request_type">
					<option value="echo">Echo Request</option>
					<option value="payment" selected="selected">Payment Request</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Payment Type:</td>
			<td>
				<select name="payment_type">
					<option value="0">Credit Card Payment</option>
					<option value="4">Credit Card Refund</option>
					<option value="6">Credit Card Reversal</option>
					<option value="10">Credit Card Pre-Authorise</option>
					<option value="11">Credit Card Complete</option>
					<option value="15">Direct Debit</option>
					<option value="17">Direct Credit</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Merchant ID:</td>
			<td><input type="text" name="merchant_id" size="7" value="CAX0001" /></td>
		</tr>
		<tr>
			<td>Transaction Password:</td>
			<td><input type="text" name="transaction_password" size="30" value="oguxue9i" /></td>
		</tr>
		<tr>
			<td>Server:</td>
			<td>
				<select name="server">
					<option value="test" selected="selected">Test</option>
					<option value="live">Live</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Amount <br />(cents value simulates the response code on Test system):</td>
			<td><input type="text" name="payment_amount" size="6" value="1.00" /></td>
		</tr>
		<tr>
			<td>Payment Ref <br />(This must match ref of original payment for Refunds/Reversals/Completes):</td>
			<td><input type="text" name="payment_reference" size="50" value="PaymentRef" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><h4>Credit Card Details</h4></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><input type="text" name="card_holder" size="40" value="John Smith" /></td>
		</tr>
		<tr>
			<td>Card No:</td>
			<td><input name="card_number" type="text" size="16" maxlength="19" value="4444333322221111" /></td>
		</tr>
		<tr>
			<td>CVV No:</td>
			<td><input type="text" name="card_cvv" size="3" value="987" maxlength="6" /></td>
		</tr>
		<tr>
			<td>Exp:</td>
			<td>
				<select name="card_expiry_month">
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				&nbsp;/&nbsp;
				<select name="card_expiry_year">
					<option value="12" selected="selected">2012</option>
					<option value="13">2013</option>
					<option value="14">2014</option>
					<option value="15">2015</option>
					<option value="16">2016</option>
					<option value="17">2017</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Pre-Auth ID <br />(for Completion payments only):</td>
			<td><input type="text" name="preauthid" size="6" value="" /></td>
		</tr>
		<tr>
			<td>Transaction ID <br />(for Refund/Reversal payments only):</td>
			<td><input type="text" name="txnid" size="16" value="" /></td>
		</tr>
		<tr>
			<td>Currency:</td>
			<td>
				<select name="currency">
					<option value="AUD">Australian Dollars</option>
					<option value="USD">U.S. Dollars</option>
					<option value="GBP">British Pounds</option>
					<option value="EUR">Euros</option>
					<option value="NZD">New Zealand Dollars</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><h4>Direct Entry Details</h4></td>
		</tr>
		<tr>
			<td>BSB Number</td>
			<td><input type="text" name="bsb_number" size="6" value="123456" /></td>
		</tr>
		<tr>
			<td>Account Number</td>
			<td><input type="text" name="account_number" size="9" value="123456789" /></td>
		</tr>
		<tr>
			<td>Account Name</td>
			<td><input type="text" name="account_name" size="50" value="Test" /></td>
		</tr>
		<tr>
			<td><input type="submit" value="Purchase" name="submit" /></td>
			<td><input type="reset" value="Reset" name="reset" /></td>
		</tr>
		</table>

		</form>

	</body>
	</html>

<?php
		break;
	case "process":

if ($_POST["server"] == "live")
	if ($_POST["payment_type"] == 15 || $_POST["payment_type"] == 17)
		$host = "www.securepay.com.au/xmlapi/directentry";
	else
		$host = "www.securepay.com.au/xmlapi/payment";
else
	if ($_POST["payment_type"] == 15 || $_POST["payment_type"] == 17)
		$host = "www.securepay.com.au/test/directentry";
	else
		//$host = "test.securepay.com.au/xmlapi/payment";
		//Or if using SSL:
		$host = "www.securepay.com.au/test/payment";

$timestamp = getGMTtimestamp();

$vars =
"<?xml version=\"1.0\" encoding=\"UTF-8\"?>" .
"<SecurePayMessage>" .
	"<MessageInfo>" .
		"<messageID>8af793f9af34bea0cf40f5fb5c630c</messageID>" .
		"<messageTimestamp>" .urlencode($timestamp). "</messageTimestamp>" .
		"<timeoutValue>60</timeoutValue>" .
		"<apiVersion>xml-4.2</apiVersion>" .
	"</MessageInfo>" .
	"<MerchantInfo>" .
		"<merchantID>" .urlencode($_POST["merchant_id"]). "</merchantID>" .
		"<password>" .urlencode($_POST["transaction_password"]). "</password>" .
	"</MerchantInfo>" .
	"<RequestType>" .urlencode($_POST["request_type"]). "</RequestType>" .
	"<Payment>" .
		"<TxnList count=\"1\">" .
			"<Txn ID=\"1\">" .
				"<txnType>" .urlencode($_POST["payment_type"]). "</txnType>" .
				"<txnSource>23</txnSource>" .
				"<amount>" .str_replace(".", "", urlencode($_POST["payment_amount"])). "</amount>" .
				"<purchaseOrderNo>" .urlencode($_POST["payment_reference"]). "</purchaseOrderNo>" .
				"<currency>" .urlencode($_POST["currency"]). "</currency>" .
				"<preauthID>" .urlencode($_POST["preauthid"]). "</preauthID>" .
				"<txnID>" .urlencode($_POST["txnid"]). "</txnID>" .
				"<CreditCardInfo>" .
					"<cardNumber>" .urlencode($_POST["card_number"]). "</cardNumber>" .
					"<cvv>" .urlencode($_POST["card_cvv"]). "</cvv>" .
					"<expiryDate>" .urlencode($_POST["card_expiry_month"]). "/" .urlencode($_POST["card_expiry_year"]). "</expiryDate>" .
				"</CreditCardInfo>" .
				"<DirectEntryInfo>" .
					"<bsbNumber>" .urlencode($_POST["bsb_number"]). "</bsbNumber>" .
					"<accountNumber>" .urlencode($_POST["account_number"]). "</accountNumber>" .
					"<accountName>" .urlencode($_POST["account_name"]). "</accountName>" .
				"</DirectEntryInfo>" .
			"</Txn>" .
		"</TxnList>" .
	"</Payment>" .
"</SecurePayMessage>";

$response = openSocket($host, $vars);

$xmlres = array();
$xmlres = makeXMLTree ($response);

/*
// Display Array contents.
echo "<pre>";
print_r($xmlres);
echo "</pre>";
*/

echo "<h1>The Server has responded.</h1>";
echo "<p><hr /></p><h1>Recover the Response:</h1>";

$messageID = trim($xmlres[SecurePayMessage][MessageInfo][messageID]);
echo "<p>messageID = ".$messageID."</p>";

$messageTimestamp = trim($xmlres[SecurePayMessage][MessageInfo][messageTimestamp]);
echo "<p>messageTimestamp = ".$messageTimestamp."</p>";

$apiVersion = trim($xmlres[SecurePayMessage][MessageInfo][apiVersion]);
echo "<p>apiVersion = ".$apiVersion."</p>";

$RequestType = trim($xmlres[SecurePayMessage][RequestType]);
echo "<p>RequestType = ".$RequestType."</p>";

$merchantID = trim($xmlres[SecurePayMessage][MerchantInfo][merchantID]);
echo "<p>merchantID = ".$merchantID."</p>";

$statusCode = trim($xmlres[SecurePayMessage][Status][statusCode]);
echo "<p>statusCode = ".$statusCode."</p>";

$statusDescription = trim($xmlres[SecurePayMessage][Status][statusDescription]);
echo "<p>statusDescription = ".$statusDescription."</p>";

$txnType = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][txnType]);
echo "<p>txnType = ".$txnType."</p>";

$txnSource = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][txnSource]);
echo "<p>txnSource = ".$txnSource."</p>";

$amount = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][amount]);
echo "<p>amount = ".$amount."</p>";

$currency = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][currency]);
echo "<p>currency = ".$currency."</p>";

$purchaseOrderNo = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][purchaseOrderNo]);
echo "<p>purchaseOrderNo = ".$purchaseOrderNo."</p>";

$approved = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][approved]);
echo "<p>approved = ".$approved."</p>";

$responseCode = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][responseCode]);
echo "<p>responseCode = ".$responseCode."</p>";

$responseText = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][responseText]);
echo "<p>responseText = ".$responseText."</p>";

$settlementDate = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][settlementDate]);
echo "<p>settlementDate = ".$settlementDate."</p>";

$txnID = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][txnID]);
echo "<p>txnID = ".$txnID."</p>";

$preauthID = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][preauthID]);
echo "<p>preauthID = ".$preauthID."</p>";

$pan = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][CreditCardInfo][pan]);
echo "<p>pan = ".$pan."</p>";

$expiryDate = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][CreditCardInfo][expiryDate]);
echo "<p>expiryDate = ".$expiryDate."</p>";

$cardType = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][CreditCardInfo][cardType]);
echo "<p>cardType = ".$cardType."</p>";

$cardDescription = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][CreditCardInfo][cardDescription]);
echo "<p>cardDescription = ".$cardDescription."</p>";

$bsbNumber = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][DirectEntryInfo][bsbNumber]);
echo "<p>bsbNumber = ".$bsbNumber."</p>";

$accountNumber = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][DirectEntryInfo][accountNumber]);
echo "<p>accountNumber = ".$accountNumber."</p>";

$accountName = trim($xmlres[SecurePayMessage][Payment][TxnList][Txn][DirectEntryInfo][accountName]);
echo "<p>accountName = ".$accountName."</p>";


echo "<p><hr /><a href=\"SecureXML_PHP_Basic_example.php\">Return to Payment Page</a></p>";


		// expression
		break;
	default:
		// expression
		break;
}

function getGMTtimeStamp()
{
	$stamp = date("YmdGis")."000+1000";
	return $stamp;
}

/**************************/
/* Secure Socket Function */
/**************************/
function openSocket($host,$query){
        // Break the URL into usable parts
        $path = explode('/',$host);
        $host = $path[0];
        unset($path[0]);
        $path = '/'.(implode('/',$path));



        // Prepare the post query
        $post  = "POST $path HTTP/1.1\r\n";
        $post .= "Host: $host\r\n";
        $post .= "Content-type: application/x-www-form-urlencoded\r\n";
        $post .= "Content-type: text/xml\r\n";
        $post .= "Content-length: ".strlen($query)."\r\n";
        $post .= "Connection: close\r\n\r\n$query";

		//echo "<p>post = </p>";
		//echo $post;

        /***********************************************/
        /* Open the secure socket and post the message */
        /***********************************************/
       $h = fsockopen("ssl://".$host, 443, $errno, $errstr);

        if ($errstr)
                print "$errstr ($errno)<br/>\n";
        fwrite($h,$post);

        /*******************************************/
        /* Retrieve the HTML headers (and discard) */
        /*******************************************/

//echo "<pre>";

        $headers = "";
        while ($str = trim(fgets($h, 4096))) {
//echo "Headers1: ".$str."\n";
                $headers .= "$str\n";
        }

        $headers2 = "";
        while ($str = trim(fgets($h, 4096))) {
//echo "Headers2: ".$str."\n";
                $headers2 .= "$str\n";
        }

//echo "</pre>";


        /**********************************************************/
        /* Retrieve the response */
        /**********************************************************/

        $body = "";
        while (!feof($h)) {
                $body .= fgets($h, 4096);
        }

        // Close the socket
        fclose($h);

        // Return the body of the response

        return $body;
}

	function makeXMLTree ($data) {
	   $output = array();
	
	   $parser = xml_parser_create();

	   xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
	   xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
	   xml_parse_into_struct($parser, $data, $values, $tags);
	   xml_parser_free($parser);
	
	   $hash_stack = array();
	
	   foreach ($values as $key => $val)
	   {
		   switch ($val['type'])
		   {
			   case 'open':
				   array_push($hash_stack, $val['tag']);
				   break;
		
			   case 'close':
				   array_pop($hash_stack);
				   break;
		
			   case 'complete':
				   array_push($hash_stack, $val['tag']);
				   eval("\$output['" . implode($hash_stack, "']['") . "'] = \"{$val['value']}\";");
				   array_pop($hash_stack);
				   break;
		   }
	   }

	   return $output;
   }
?> 