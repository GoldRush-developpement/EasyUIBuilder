<?php

namespace refaltor\ui\builders;

interface RootBuild
{
    public function root(): Root;
    public function getNamespace(): string;
    public function getPathName(): string;
}