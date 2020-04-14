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
     * @return bool
     */
    public function validate($item = [])
    {
        $result = (new Client())->request('POST', $this->_apiUrl, [
            'PhoneNumber' => $item['phoneNumber'],
            'CountryCode' => $item['countryCode'],
            'Locale' => $item['locale'],
            'APIKey' => $this->_apiKey
        ]);

        $content = $result->getBody();

        switch($content['status']) {
            case "VALID_CONFIRMED":
            case "VALID_UNCONFIRMED":
                return true;
                break;
            case "INVALID": 
                return false;
                break;
            default:
                return false;
                break;
        }
    }
}