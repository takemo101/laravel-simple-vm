<?php

namespace Takemo101\LaravelSimpleVM;

/**
 * config class
 */
final class ViewModelConfig
{
    /**
     * @var string
     */
    const DefaultNamespace = 'Http\ViewModel';

    /**
     * @var string
     */
    const Separator = '\\';

    /**
     * @var string|null
     */
    private ?string $namespace;

    /**
     * @var string|null
     */
    private ?string $path;

    /**
     * constructor
     *
     * @param string|null $namespace
     * @param string|null $path
     */
    public function __construct(
        ?string $namespace = null,
        ?string $path = null,
    ) {
        $this
            ->setNamespace($namespace)
            ->setPath($path);
    }

    /**
     * set root namespace
     *
     * @param string $rootNamespace
     * @return self
     */
    public function setNamespace(?string $namespace = null): self
    {
        if (is_string($namespace)) {
            $namespace = trim($namespace, self::Separator);

            if (strlen($namespace) == 0) {
                $namespace = null;
            }
        }

        $this->namespace = $namespace;

        return $this;
    }

    /**
     * get combined namespace
     *
     * @param string $rootNamespace
     * @return string
     */
    public function getCombinedNamespace(string $rootNamespace): string
    {
        $namespace = $this->namespace ?? self::DefaultNamespace;

        return implode(self::Separator, [
            $rootNamespace,
            $namespace,
        ]);
    }

    /**
     * set path
     *
     * @param string $path
     * @return self
     */
    public function setPath(?string $path = null): self
    {
        if (is_string($path)) {
            $path = rtrim($path, '/');

            if (strlen($path) == 0) {
                $path = null;
            }
        }

        $this->path = $path;

        return $this;
    }

    /**
     * get path
     *
     * @param string $path
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * has path
     *
     * @return boolean
     */
    public function hasPath(): bool
    {
        return (bool)$this->path;
    }
}
