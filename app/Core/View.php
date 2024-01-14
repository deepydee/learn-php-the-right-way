<?php

declare(strict_types=1);

namespace Synthex\Phptherightway\Core;

use Synthex\Phptherightway\Exceptions\ViewNotFoundException;

class View
{
    private function __construct(
        protected string $view,
        protected array $parameters = [],
    ) {
    }

    public static function make(
        string $view,
        array $parameters = [],
    ): static {
        return new static($view, $parameters);
    }

    public function render(): string
    {
        $viewPath = VIEW_PATH . '/' . $this->view . '.php';

        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }

        foreach ($this->parameters as $key => $value) {
            $$key = $value;
        }

        // extract($this->parameters);

        ob_start();

        include VIEW_PATH . '/' . $this->view . '.php';

        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name)
    {
        return $this->parameters[$name] ?? null;
    }
}
