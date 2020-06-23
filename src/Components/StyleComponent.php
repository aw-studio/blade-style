<?php

namespace BladeStyle\Components;

use BladeStyle\Factory;
use Illuminate\Support\Str;
use Illuminate\View\Component;
use Illuminate\Support\Facades\File;

class StyleComponent extends Component
{
    /**
     * Style language.
     *
     * @var string
     */
    public $lang;

    public $style;

    public $factory;

    /**
     * Create new StyleComponent instance.
     *
     * @param string $lang
     * @return void
     */
    public function __construct(Factory $factory, $lang = 'css')
    {
        $this->lang = $lang;
        $this->factory = $factory;

        $this->setStyle();
        $this->addStyleToStack();
    }

    public function setStyle()
    {
        $path = $this->getPathFromTrace();

        if (!$path) {
            return;
        }

        $this->style = $this->factory->make($path);
    }

    protected function addStyleToStack()
    {
        //
    }

    protected function getPathFromTrace()
    {
        foreach (debug_backtrace() as $trace) {
            if (!array_key_exists('file', $trace)) {
                continue;
            }

            if (!Str::startsWith($trace['file'], config('view.compiled'))) {
                continue;
            }

            return $this->getPathFromCompiled($trace['file']);
        }
    }

    protected function getPathFromCompiled($compiled)
    {
        return trim(Str::between(File::get($compiled), '/**PATH', 'ENDPATH**/'));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return void
     */
    public function render()
    {
        //
    }
}
