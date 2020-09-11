<?php

namespace RefinedDigital\PagePromos\Module\Providers;

use Illuminate\Support\ServiceProvider;
use RefinedDigital\CMS\Modules\Pages\Aggregates\PageAggregate;

class PagePromoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../../config/page-promos.php' => config_path('page-promos.php'),
        ], 'page-promos');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->mergeConfigFrom(__DIR__.'/../../../config/page-promos.php', 'page-promos');

        $fields = [
            [ 'name' => 'Heading', 'page_content_type_id' => 3, 'field' => 'heading' ],
            [ 'name' => 'Link', 'page_content_type_id' => 3, 'field' => 'link' ],
            [ 'name' => 'Image', 'page_content_type_id' => 4, 'field' => 'image', 'hide_label' => true ]
        ];

        if (config('page-promos.extra_fields')) {
            $fields = array_merge($fields, config('page-promos.extra_fields'));
        }

        app(PageAggregate::class)
            ->addModule('Promos', [
                'tab' => 'promos',
                'type' => 'repeatable',
                'config' => 'page-promos',
                'fields' => $fields
            ]);
    }
}
