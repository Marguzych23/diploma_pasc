<?php


namespace App\Service;


class DataUtilService
{

    /**
     * @param string      $data
     * @param string|null $from_encoding
     *
     * @return false|string|string[]|null
     */
    public static function convertToUTF8(string $data, ?string $from_encoding = null)
    {
        if ($from_encoding !== null) {
            return mb_convert_encoding($data, "UTF-8", $from_encoding);
        }

        return mb_convert_encoding($data, "UTF-8");
    }

}