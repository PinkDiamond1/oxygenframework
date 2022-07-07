<?php


/* =============================================================================================================================*/
/* =============================================================================================================================*/

/**
 * payments.class.php
 *
 * Payments class and functions
 *
 * @category   E-Wallet
 * @package    Oxygen
 * @author     Redwan Aouni <aouniradouan@gmail.com>
 * @copyright  2021 - Oxygen
 * @version    1.0.0
 * @since      File available since Release 1.0.0
 */

/* =============================================================================================================================*/
/* =============================================================================================================================*/





class Payments {

	public function Stripe($CardNumber, $ExpiryMonth, $ExpiryYear, $Cvv, $Amount, $Currency = 'USD' ,$IsCallback = null){

		$gateway = Omnipay\Omnipay::create('Stripe');
		$gateway->setApiKey( STRIPE_SECRET_KEY );

		$formData = array(
			'number' => $CardNumber,
			'expiryMonth' => $ExpiryMonth,
			'expiryYear' => $ExpiryYear,
			'cvv' => $Cvv
		);
		$response = $gateway->purchase(array('amount' => $Amount, 'currency' => $Currency, 'card' => $formData))->send();

		if ($response->isRedirect()) {
		    // redirect to offsite payment gateway
		    $response->redirect();
		} elseif ($response->isSuccessful()) {
		    // payment was successful: update database
		    //print_r($response);
		    $this->Redirect("/browse");
		} else {
		    // payment failed: display message to customer
		    echo $response->getMessage();
		}


	}

	public function Paypal($IsCallback = null){

	}

	public function Eddahabia($IsCallback = null){

	}


	public function CIB($IsCallback = null){

	}



    private function UserID(){
        global $database;

        if (isset( $_SESSION['FirstLogin'] ) ) {
        	$LoginSession	=	$_SESSION['FirstLogin'];
			$UserID 		= 	$database->fetchField('SELECT id FROM users WHERE session_firstlogin = ?', $LoginSession);
        }
        return $UserID;
    }


    private function CreateSession($key, $value){
        return $_SESSION[$key]     =   $value;
    }



    private function Redirect($to){
        header("Location: $to");
        exit();
    }





}



?> 