<?php

/**
 * Class SendEmailToGuestCompass
 */
class SendEmailToGuestCompass
{
    /**
     * API URL
     */
    const URL = "https://wifi.guestcompass.nl/api/email";

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
     * SendEmailToGuestCompass constructor. Check if curl present and enabled
     *
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
     * @return void
     */
    public function setData($hotel_name, $token, $email, $guest_name = '')
    {
        $this->hotel_name = $hotel_name;
        $this->token = $token;
        $this->email_address = $email;
        $this->guest_name = $guest_name;
    }

    /**
     * Does cURL request, send provided data
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

// Example hotel name (dummy), must be provided by admin
$hotel_name = 'Waldorf Astoria Amsterdam';

// Example token (dummy),  must be provided by admin
$token = 'AJ9!GDoBSv@83V0';

// Example email
$email = "rob@guestcompass.nl";

// Example name, optional, can be full name or just name
// if full name presented, name and last name must be separated with single space, see example
$name = 'Rob Neervens';

//Set data
$object->setData($hotel_name, $token, $email, $name);

// Send to GuestCompass's application
// In case of success return string: 'Success' - HTTP CODE 200
// In case of failure return string: 'Unauthorized action.' - HTTP CODE 401
$object->send();










