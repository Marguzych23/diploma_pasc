<?php


namespace App\Service\Competition;


class ServiceFactory
{
    protected static RFBRService $RFBRService;
    protected static RSFService  $RSFService;

    /**
     * ServiceFactory constructor.
     *
     * @param RFBRService $RFBRService
     * @param RSFService  $RSFService
     */
    public function __construct(RFBRService $RFBRService, RSFService $RSFService)
    {
        self::$RFBRService = $RFBRService;
        self::$RSFService  = $RSFService;
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
            case RSFService::ABBREVIATION:
            {
                return self::$RSFService;
            }
            default:
            {
                return null;
            }
        }
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        return [
            RFBRService::ABBREVIATION => self::$RFBRService,
            RSFService::ABBREVIATION  => self::$RSFService,
        ];
    }

}