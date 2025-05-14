<?php

namespace IntrovertTest;

use Introvert\ApiClient;
class IntrovertApi
{
    const           API_URL = 'https://api.introvert.com/api/';
    protected const API_KEY = "23bc075b710da43f0ffb50ff9e889aed";


    public function __construct()
    {
        Introvert\Configuration::getDefaultConfiguration()->setApiKey('key', self::API_KEY);
        $api = new Introvert\ApiClient();
        try {
            $result = $api->account->allStatuses();
            echo '<pre>';
            var_dump($result);
            echo '<pre>';
        } catch (Exception $e) {
            echo 'Exception when calling account->allStatuses: ', $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * @param $count
     * @param $offset
     * @return mixed
     * скопировал с предыдущего задания
     */
    private function getLeads($count, $offset)
    {
        $res = $this->api->lead->getAll([], [], [], '', $count, $offset);
        return $res['result'];
    }

}