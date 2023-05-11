<?php

namespace CMDISP\MonologMicrosoftTeams;

use ArrayAccess;
use JsonSerializable;

class TeamsMessage implements ArrayAccess, JsonSerializable
{
    /**
     * @var array
     */
    private $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function jsonSerialize(): array
    {
        return array_merge([
            '@context' => 'http://schema.org/extensions',
            '@type' => 'MessageCard',
        ], $this->data);
    }
}
