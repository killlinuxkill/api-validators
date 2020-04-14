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
    public function config($config = [])
    {
        if (!empty($config['apiKey'])) {
            $this->_apiKey = $config['apiKey'];
        }
    }

    /**
     * @param array ['emailAddress']
     * @return object
     */
    public function validate($item = [])
    {
        $result = new \stdClass(['success' => false, 'info' => '']);

        $response = (new Client())->request('GET', $this->_apiUrl, [
            'EmailAddress' => $item['emailAddress'],
            'APIKey' => $this->_apiKey
        ]);

        if ($response->getStatusCode() != 200) {
            return $result;
        }

        $contents = $response->getBody()->getContents();
        $contents = json_decode($contents);

        switch ($contents->status) {
            case 200:
            case 207:
            case 215:
                $result->success =  true;
                break;
            default:
                $result->success =  false;
                break;
        }
        $result->info = $contents->info;
        return $result;
    }
}