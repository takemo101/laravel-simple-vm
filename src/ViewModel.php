<?php

namespace Takemo101\LaravelSimpleVM;

use Takemo101\SimpleVM\{
    ViewModel as BaseViewModel,
    ArrayAccessObject,
};
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\{
    Arrayable,
    Responsable,
    Jsonable,
};

/**
 * simple view model for laravel class
 *
 * @implements Arrayable<string|int, mixed>
 */
class ViewModel extends BaseViewModel implements Arrayable, Responsable, Jsonable
{
    /**
     * ignores property or method names
     *
     * @var string[]
     */
    protected static array $ignores = [
        'toArray',
        'toArrayAccessObject',
        'jsonSerialize',
        'hasIgnoresName',
        'of',
        // added
        'toResponse',
        'toJson',
        'toAccessArray',
    ];

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return new JsonResponse($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return (string)json_encode($this->jsonSerialize(), $options);
    }

    /**
     * to array
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return collect(parent::toArray())->all();
    }

    /**
     * to access array
     *
     * @return mixed
     */
    public function toAccessArray(): array
    {
        return (new LaravelArrayAccessObject(
            collect(parent::toArray())->toArray(),
        ))->toArray();
    }
}
