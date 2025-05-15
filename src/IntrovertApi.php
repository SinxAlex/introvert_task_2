<?php

namespace IntrovertTest;

use Introvert\ApiClient;
use Introvert\Configuration;
class IntrovertApi
{
    const  API_URL = 'https://api.s1.yadrocrm.ru/';

    const     INTERVAL_DAY = 30;

    public    $field;
    public    $date;
    const     COUNT_PACKAGE = 50;
    private   $api;
    protected $data;
    protected const API_KEY = "23bc075b710da43f0ffb50ff9e889aed";

    public function __construct(string $field, string $date, array $status)
    {
        $this->field = $field;
        $this->date= $date;

        \Introvert\Configuration::getDefaultConfiguration()->setHost(self::API_URL)->setApiKey('key', self::API_KEY);

        $this->api = new \Introvert\ApiClient();
        try {
                $this->data=$this->getDataLeads($status,strtotime($date));
                $this->returnJsonData();
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


    private function getLeads($status,int $count, int $offset,int $timestamp): array
    {
        $res = $this->api->lead->getAll([],$status,[],$timestamp, $count, $offset);
        return $res['result'];
    }

    /**
     * @param $count
     * @param $offset
     * @return mixed
     * скопировал с предыдущего кода
     */
    private function getDataLeads(array $status,$timestamp):array
    {
        $hasMore=true;
        $offset = 0;
        $arr=[];
        while ($hasMore)
        {
            // задержка скрипта
            sleep(1);
            $res = $this->getLeads($status,self::COUNT_PACKAGE, $offset,$timestamp);

            if (empty($res))
            {
                $hasMore = false;
            }
            $offset+=count($res);
            //пропускаем через фильтрацию
            $res=self::filterArray($res,$this->field);
            $arr=array_merge($arr,$res);
            if(!empty($res))
            {
                $arr=array_merge($arr,$res);
            }
        }
        return  $arr;
    }



    /**
     * @param $res
     * @param $column
     * @return array
     *
     * функция для фильтрации данных
     * по ключу столбца
     */

    static function filterArray(array $res, string $field): array
    {
      return array_filter($res, function($item) use ($field) {
            return self::filterArrayField($item, $field);
        });

    }

    static function filterArrayField(array $item,string $field): bool
    {
        // Проверяем существование custom_fields и что это массив
        if (!isset($item['custom_fields']) || !is_array($item['custom_fields'])) {
            return false;
        }

        // Ищем поле с нужным name
        foreach ($item['custom_fields'] as $field_data) {
            // Проверяем что это массив и содержит нужный name
            if (is_array($field_data) &&
                isset($field_data["name"]) &&
                $field_data["name"] === $field) {
                return true;
            }
        }

        return false;
    }


    static  function arrDates():array
    {
        $dates = [];
        $currentDate = new \DateTime('2025-05-01');

        for ($i = 0; $i < self::INTERVAL_DAY; $i++) {
            $date = clone $currentDate;
            $date->add(new \DateInterval("P{$i}D"));
            $dates[] = $date->format('Y-m-d 00:00:00');
        }
      return $dates;
    }


    public  function returnJsonData():string
    {
        $arr=[];
        foreach (self::arrDates() as $date)
        {
            $arr_id_leads=[];
            foreach ($this->data as $item) {
                foreach ($item['custom_fields'] as $key => $value)
                {
                       if($value["name"]===$this->field && $value["values"][0]["value"]==$date)
                       {
                                $arr_id_leads[]=$item["id"];
                       }
                }
            }
            $arr[$date]=$arr_id_leads;
        }
      return json_encode($arr);
    }
}

