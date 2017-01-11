<?php
namespace XLite\Module\UnisenderInc\Integration\Core;

use XLite\Module\UnisenderInc\Integration;

/**
 * Unisender Api Client
 */
class UnisenderApi extends \XLite\Base\Singleton
{
    protected $apiKey;
    protected $lists;

    /**
     * @return Integration\Core\UnisenderApi
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    public function getLists($apiKey = null)
    {
        if (empty($this->lists)) {
            $lists = array();
            $method = 'getLists';
            $vars['api_key'] = $apiKey == null ? $this->apiKey : $apiKey;

            $listsTmp = $this->exec($method, $vars);
            // error
            if (!empty($listsTmp['error'])) {
                unset($this->lists);
                return $listsTmp;
            }

            foreach ($listsTmp['result'] as $list) {
                $lists[$list['id']] = $list['title'];
            }
            $this->lists = $lists;
        }
        return $this->lists;
    }

    public function subscribe($profile, $listIds = null)
    {
        $method = 'subscribe';
        $vars = array(
            'api_key' => $this->apiKey,
            'fields[email]' => $profile->login,
        );

        if (!empty($listIds)) {
            $vars['list_ids'] = $listIds;
        }

        $address = $profile->getFirstAddress();

        if ($address) {
            $vars = array_merge($vars, array(
                'fields[Name]' => $address->getName(),
                'fields[phone]' => $address->phone,
                'double_optin' => 3,
                'overwrite' => 2
            ));
        }

        $response = $this->exec($method, $vars);
        return $response;
    }

    public function subscribeForm($data, $listIds)
    {
        $method = 'subscribe';
        $vars = array(
            'api_key' => $this->apiKey,
            'fields[email]' => $data['email'],
            'list_ids' => $listIds,
        );

        if (!empty($data['name'])) {
            $vars['fields[Name]'] = $data['name'];
        }

        if (!empty($data['phone'])) {
            $vars['fields[phone]'] = $data['phone'];
        }

        $response = $this->exec($method, $vars);
        return $response;
    }

    protected function __construct()
    {
        $this->apiKey = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->apiKey;
    }

    protected function exec($method, $vars)
    {
        $url = $this->getApiUrl() . $method;
        $vars['format'] = 'json';
        $vars['platform'] = 'X-Cart';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_USERAGENT, 'HAC');
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);

        $response = curl_exec($curl);
        $response = json_decode($response, 1);
        curl_close($curl);

        if (!empty($response['error'])) {
            return $this->getError($response);
        }

        return $response;
    }

    protected function getError($response)
    {
        $errors = array(
            'invalid_api_key' => static::t('invalid_api_key'),
        );
        return array(
            'error' => isset($errors[$response['code']]) ? $errors[$response['code']] : $response['error']
        );
    }

    public function getApiUrl()
    {
        $lang = \XLite\Core\Session::getInstance()->getLanguage()->getCode();
        $lang = $lang == 'ru' ? 'ru' : 'en';
        $url = 'https://api.unisender.com/' . $lang . '/api/';
        return $url;
    }
}
