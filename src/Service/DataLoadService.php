<?php


namespace App\Service;


use App\Exception\CompetitionException;

class DataLoadService
{
    /**
     * @param string $url
     *
     * @return string
     * @throws CompetitionException
     */
    public static function loadFromURL(?string $url) : string
    {
        $result = false;

        if ($url !== null) {
            $optionsArray = [
                CURLOPT_AUTOREFERER    => true,
                CURLOPT_COOKIESESSION  => false,
                CURLOPT_HTTPGET        => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_BINARYTRANSFER => true,
            ];

            $ch = curl_init($url);
            curl_setopt_array($ch, $optionsArray);

            $result = curl_exec($ch);
            curl_close($ch);
        }

        if ($result === false) {
            throw new CompetitionException('', 110);
        } else {
            return $result;
        }
    }

    /**
     * @param string|null $url
     *
     * @return string
     * @throws CompetitionException
     */
    public static function loadHTMLFromURL(?string $url)
    {
        return self::loadFromURL($url);
    }
}