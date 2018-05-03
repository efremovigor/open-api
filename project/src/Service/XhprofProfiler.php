<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 03.05.18
 * Time: 12:42
 */

namespace Service;


use Service\Profiler\ProfilerInterface;

class XhprofProfiler implements ProfilerInterface
{

    /**
     * @var array
     */
    private $info;

    public function start(): void
    {
        xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
    }

    public function end(): void
    {
        $this->info = xhprof_disable();
    }

    /**
     * @return array
     */
    public function info(): array
    {
        return $this->info;
    }
}