@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset
@php
$configData = Helper::appClasses();
@endphp

@isset($configData["layout"])
@include((( $configData["layout"] === 'horizontal') ? 'admin.layouts.sneat.horizontalLayout' :
(( $configData["layout"] === 'blank') ? 'layouts.blankLayout' : 'admin.layouts.sneat.contentNavbarLayout') ))
@endisset
