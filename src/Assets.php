<?php

namespace IntrovertTest;

class Assets
{

    /**
     * @return string[]
     *
     * фнкция возращает массив пакетов css и js
     * Более продвинутом варианте, конечно  можно сделать с выводом js в разных
     * частях станицы HEAD BODY END - если js как то влияет от порядка подключения CSS
     * классов или DOM объектов
     * P.s начианаю жалеть что не использую  Yii2 -> не было бы этих
     * заморочек с подключения ассетс и роутов
     */
    static function getAssets()
    {
        return [
           'css'=>' <link href="/src/assets/glDatePicker-2.0/styles/glDatePicker.default.css" rel="stylesheet" type="text/css">',
           'js'=>[
               '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>',
               '<script src="/src/assets/glDatePicker-2.0/glDatePicker.js"></script>',
            ],
        ];
    }

    static function registerAssets()
    {
        self::getAssets();
    }
}