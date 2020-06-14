<?php

namespace BladeStyle\Compiler;

use BladeStyle\Compiler\Compiler;

class LessCompiler extends Compiler
{
    /**
     * Compile scss to file.
     *
     * @return void
     */
    public function compile()
    {
        $error = shell_exec($this->getCompileCommand());
        if (!$error) {
            return;
        }
        $error = json_decode($error);
        $this->throwStyleException($error->message, $error->line);
    }

    /**
     * Get compile command.
     *
     * @return void
     */
    public function getCompileCommand()
    {
        $compilerPath = __DIR__ . '/../../scripts/compile-less.js';
        $oneLineStyle = str_replace("\n", '<br>', $this->style);
        return "/Users/helen/.nvm/versions/node/v12.16.3/bin/node $compilerPath '{$oneLineStyle}' --path={$this->path} 2>&1";
    }
}
