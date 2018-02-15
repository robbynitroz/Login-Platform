<?php

/**
 * Class SendEmailToGuestCompass
 */
class SendEmailToGuestCompass
{
    /**
     * API URL
     */
    const URL = "http://login.loc/api/email";
    /**
     * @var string $hotel_name
     */
    private $hotel_name;
    /**
     * @var string $token
     */
    private $token;
    /**
     * @var string $email_address
     */
    private $email_address;
    /**
     * @var string $guest_name
     */
    private $guest_name;

    /**
     * SendEmailToGuestCompass constructor.
     * @throws Exception
     */
    public function __construct()
    {
        if (!function_exists('curl_version')) {
            throw new Exception('cURL is not enabled');
        };
    }

    /**
     * Set required values to properties
     *
     * @param string $hotel_name
     * @param string $token
     * @param string $email
     * @param string $guest_name
     */
    public function setData($hotel_name, $token, $email, $guest_name = '')
    {
        $this->hotel_name = $hotel_name;
        $this->token = $token;
        $this->email_address = $email;
        $this->guest_name = $guest_name;
    }

    /**
     * Do cURL request, send data
     *
     * @return string
     */
    public function send()
    {
        $data = array(
            "email" => $this->email_address,
            "token" => $this->token,
            "hotel_name" => $this->hotel_name,
            "name" => $this->guest_name
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

}

//Creates SendEmailToGuestCompass object
$object = new SendEmailToGuestCompass();

// Example hotel name
$hotel_name = 'Waldorf Astoria Amsterdam';
// Example token
$token = 'AJ9!GDoBSv@83V0';
// Example email
$email = "rob@guestcompass.nl";
// Example name, optional, can be full name or just name
$name = 'Rob Neervens';

//Set data
$object->setData($hotel_name, $token, $email, $name);

// Send to GuestCompass's application
$object->send();










