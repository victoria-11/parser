<?php

namespace Parser;

interface ParserInterface
{

    public function parse($handle, bool $byKey): array;
}
