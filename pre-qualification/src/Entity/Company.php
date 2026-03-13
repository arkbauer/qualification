<?php

namespace Entity;

use Entity\Interface\Renderable;
use Enum\Format;

class Company implements Renderable
{
    public $id;
    public $name;


    public $creator;

    public $addresses = [];

    function addAddress($addr) {
        $this->addresses[] = $addr;
        return $this;
    }

    function render(Format $format)
    {
        $out = null;

        $out .= "\n";

        $out .= sprintf("%s: %s | %s", $this->id, $this->name, $this->creator);

        $out .= "\n----------------------\n";

        foreach ($this->addresses as $address) {
            $out .= sprintf("%s\n\n", $address->render($format));
        }
        $out .= "\n";
        return $out;
    }
}
