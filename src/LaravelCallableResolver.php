<?php

namespace Takemo101\LaravelSimpleVM;

use Takemo101\SimpleVM\{
    CallableResolverInterface,
    ViewModel,
    CallMethodException,
};
use Illuminate\Contracts\Foundation\Application;

final class LaravelCallableResolver implements CallableResolverInterface
{
    /**
     * Undocumented function
     *
     * @param Application $app
     */
    public function __construct(
        private Application $app,
    ) {
        //
    }

    /**
     * resolve call model method
     *
     * @param ViewModel $model
     * @return mixed
     * @throws CallMethodException
     */
    public function call(ViewModel $model, string $method): mixed
    {
        if (!method_exists($model, $method)) {
            throw new CallMethodException("not found method error: [{$method}]");
        }

        $callable = [$model, $method];

        if (!is_callable($callable)) {
            throw new CallMethodException("not callable error: [{$method}]");
        }

        return $this->app->call($callable);
    }

    /**
     * deep copy method
     *
     * @return static
     */
    public function copy(): static
    {
        return new static($this->app);
    }
}
