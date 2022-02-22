<?php

namespace Takemo101\LaravelSimpleVM;

use Takemo101\SimpleVM\ArrayAccessObject;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

/**
 * array access object for laravel class
 *
 * @implements Arrayable<string|int, mixed>
 */
final class LaravelArrayAccessObject extends ArrayAccessObject implements Arrayable
{
    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @return boolean
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetExists(mixed $key): bool
    {
        if (!(is_int($key) || is_string($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        return Arr::exists($this->data, $key);
    }

    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @return mixed
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetGet(mixed $key): mixed
    {
        if (!(is_int($key) || is_string($key) || is_null($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        return Arr::get($this->data, $key);
    }

    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        if (!(is_string($key) || is_null($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        Arr::set($this->data, $key, $value);
    }

    /**
     * implements ArrayAccess
     *
     * @param mixed $key
     * @return void
     * @throws ArrayAccessObjectKeyArgumentException
     */
    public function offsetUnset(mixed $key): void
    {
        if (!(is_array($key) || is_string($key))) {
            throw new ArrayAccessObjectKeyArgumentException($key);
        }
        Arr::forget($this->data, $key);
    }
}
