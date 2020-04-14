<?php
namespace exactdata\validators\EmailValidatorNet;

use GuzzleHttp\Client;

/**
 * See https://www.email-validator.net/api.html
 */
class Validator extends \exactdata\validators\base\ValidatorBase implements \exactdata\validators\base\ValidatorInterface
{
    private $_apiKey;
    private $_apiUrl = 'https://api.email-validator.net/api/verify';

    /**
     * @param array [apiKey]
     */
    public function config(array $config): void
    {
        if (!empty($config['apiKey'])) {
            $this->_apiKey = $config['apiKey'];
        }
    }

    /**
     * @param array ['emailAddress']
     * @return bool
     */
    public function validate(array $item): bool
    {
        $result = (new Client())->request('GET', $this->_apiUrl, [
            'EmailAddress' => $item['emailAddress'], 
            'APIKey' => $this->_apiKey
        ]);

        switch ($result->getStatusCode()) {
            case 200:
            case 207:
            case 215:
                return true;
                break;
            default:
                return false;
                break;
        }
    }
}