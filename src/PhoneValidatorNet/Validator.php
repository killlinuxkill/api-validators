<?php
namespace exactdata\validators\PhoneValidatorNet;

use GuzzleHttp\Client;

/**
 * See https://www.phone-validator.net/api.html
 */
class Validator extends \exactdata\validators\base\ValidatorBase implements \exactdata\validators\base\ValidatorInterface
{
    private $_apiKey;
    private $_apiUrl = 'https://api.phone-validator.net/api/v2/verify';

    /**
     * @param array [apiKey]
     */
    public function config($config = [])
    {
        if (!empty($config['apiKey'])) {
            $this->_apiKey = $config['apiKey'];
        }
    }

    /**
     * @param array [phoneNumber, countryCode, locale]
     * @return object
     */
    public function validate($item = [])
    {
        $result = new \stdClass(['success' => false, 'info' => '']);

        $response = (new Client())->request('POST', $this->_apiUrl, [
            'PhoneNumber' => $item['phoneNumber'],
            'CountryCode' => $item['countryCode'],
            'Locale' => $item['locale'],
            'APIKey' => $this->_apiKey
        ]);

        if ($response->getStatusCode() != 200) {
            return $result;
        }

        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents);

        switch($contents->status) {
            case "VALID_CONFIRMED":
            case "VALID_UNCONFIRMED":
                $result->success = true;
                break;
            case "INVALID":
                $result->success = false;
                break;
            default:
                $result->success = false;
                break;
        }
        $result->info = $contents->info;
        return $result;
    }
}