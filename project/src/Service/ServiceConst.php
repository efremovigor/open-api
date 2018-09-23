<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:46
 */

namespace Service;

final class ServiceConst
{
    public const LOGGER           = Logger::class;
    public const CACHE_MAN        = Cache::class;
    public const ROUTER           = Router::class;
    public const PROFILER         = XhprofProfiler::class;
    public const DEBUG_LOGGER     = DebugLogger::class;
    public const REPOSITORY       = ContainerRepositoryRegistry::class;
    public const ORM_CONNECTION   = OrmConnection::class;
    public const REDIS_CONNECTION = RedisConnection::class;
    public const TEMPLATER        = Templater::class;
    public const SESSION          = Session::class;

    public const GIFT_SERVICE     = GiftService::class;
    public const APP_GIFT_SENDER  = AppGiftService::class;
    public const BANK_GIFT_SENDER = BankGiftService::class;
    public const MAIL_GIFT_SENDER = MailGiftService::class;

}