<?php

namespace IntrovertTest;

use Introvert\ApiClient;
use Introvert\Configuration;
class IntrovertApi
{
    const  API_URL = 'https://api.s1.yadrocrm.ru/';

    const     INTERVAL_DAY = 30;
    const     LIMIT= 5;
    public    $column;
    public    $date;
    const     COUNT_PACKAGE = 50;
    private   $api;
    protected $data=[];
    protected const API_KEY = "23bc075b710da43f0ffb50ff9e889aed";

    public function __construct(string $column, string $date, array $status)
    {
        $this->status = $status;
        $this->column = $column;
        $this->date= $date;

        \Introvert\Configuration::getDefaultConfiguration()->setHost(self::API_URL)->setApiKey('key', self::API_KEY);
        $this->api = new \Introvert\ApiClient();
        try {
            foreach ($status as $st)
            {
                $this->data[]=$this->getDataLeads([$st]);
            }
            echo '<pre>';
            var_dump($this->data);
            echo '</pre>';
        } catch (Exception $e)
        {
            echo 'Exception when calling account->allStatuses: ', $e->getMessage(), PHP_EOL;
        }
    }
    /**
     * @param $count
     * @param $offset
     * @return mixed
     * скопировал с предыдущего кода
     */
    private function getDataLeads(array $status):array
    {
        $hasMore=true;
        $offset = 0;
        $arr=[];

        while ($hasMore)
        {
            // задержка скрипта
            sleep(1);
            $res = $this->getLeads($status,self::COUNT_PACKAGE, $offset);

            if (empty($res))
            {
                $hasMore = false;
            }
            $offset+=count($res);

            $res=self::filterArray($res);
            $arr=array_merge($arr,$res);
        }
        return  $arr;
    }

    /**
     * @param $count
     * @param $offset
     * @return mixed
     * скопировал с предыдущего кода
     */


    private function getLeads($status,int $count, int $offset): array
    {
        $res = $this->api->lead->getAll([],$status,[],'', $count, $offset);
        return $res['result'];
    }

    /**
     * @param $res
     * @param $column
     * @return array
     *
     * функция для фильтрации данных
     * по ключу столбца
     */

    static function filterArray(array $res): array
    {
          $arr=[];
          $res=self::filterArrayEmptyCustomField($res);
            foreach ($res as $lead)
            {
                if(!empty($lead) && self::filterFindKeyValue($lead,'name','date_reservation'))
                {
                  if(self::filterByDateInterval($lead))
                  {
                      $arr[]=$lead;
                  }

                }
            }
        return  $arr;
    }
    static function filterArrayEmptyCustomField($res):array
    {
        return array_filter($res, function($item) {
            return !empty($item['custom_fields'] ?? []);
        });
    }


    static function filterFindKeyValue(array $array, string $targetKey, string $targetValue): bool {

        foreach ($array as $key => $value)
        {
            if (is_array($value) &&  self::filterFindKeyValue($value, $targetKey, $targetValue)) {
                return true;
            }
            if ($key === $targetKey && $value === $targetValue) {
                return true;
            }
        }
        return false;
    }




   static function filterByDateInterval(array $res):bool
    {


           foreach ($res['custom_fields'] as $field)
                {
                   if($field['name']=='date_reservation')
                   {
                       if(in_array($field['values'][0]['value'],self::arrDates()))
                            {
                                return true;
                            }
                   }
               }

       return false;
    }

    static  function arrDates():array
    {
        $dates = [];
        $currentDate = new \DateTime('2025-05-01');

        for ($i = 0; $i < 30; $i++) {
            $date = clone $currentDate;
            $date->add(new \DateInterval("P{$i}D"));
            $dates[] = $date->format('Y-m-d 00:00:00');
        }

      return $dates;
    }


    public  function returnJsonData():string
    {

    }
}

