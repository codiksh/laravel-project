<?php

Route::group(['prefix' => 'media', 'namespace' => 'App\Http\Controllers'], function (){
    Route::get('default-image/{resolution?}/{type?}','MediaController@getDefaultImage')->name('images_default');
    Route::get('images/{model}/{modelUuid}/{collection}/{mediaId}/{conversion}/{name}',
        'MediaController@responseImage')->name('media_images');
    Route::get('response/media/{model}/{collection}/{mediaId}/{fileName}','MediaController@responseMedia')->name('response_media');
    Route::get('response/media/{model}/{collection}/{mediaId}/responsive-images/{fileName}','MediaController@responseResponsiveMedia')->name('response_responsive_media');
    Route::get('others/{model}/{modelUuid}/{collection}/{mediaId}/{name}','MediaController@response')->name('media_response');
});

