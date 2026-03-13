<?php

namespace Entity\Interface;

use Enum\Format;

interface Renderable
{
    public function render(Format $format);
}
