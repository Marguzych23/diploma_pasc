<?php


namespace App\Service\Competition;


class ServiceFactory
{
    protected static RFBRService $RFBRService;

    public function __construct(RFBRService $RFBRService)
    {
        self::$RFBRService = $RFBRService;
    }

    /**
     * @param string $type
     *
     * @return BaseService|null
     */
    public static function create(string $type)
    {
        switch ($type) {
            case RFBRService::ABBREVIATION:
            {
                return self::$RFBRService;
            }
            default:
            {
                return null;
            }
        }
    }

}