@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->request }}\{{ $config->modelNames->name }};

class CreateRequest extends MasterRequest
{

}
