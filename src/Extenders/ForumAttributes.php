<?php

namespace Blessing\Flarum\Extenders;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Container\Container;

class ForumAttributes implements ExtenderInterface
{
    public function extend(Container $container, Extension $extension = null)
    {
        $container['events']->listen(Serializing::class, [$this, 'attributes']);
    }

    public function attributes(Serializing $event)
    {
        if ($event->isSerializer(ForumSerializer::class)) {
            /**
             * @var SettingsRepositoryInterface
             */
            $settings = app(SettingsRepositoryInterface::class);

            $event->attributes['blessing-auth.loginTitle'] =
                $settings->get('blessing-auth.button_title') ?: app(Translator::class)->trans('blessing-auth.api.default-login-button-title');
            $event->attributes['blessing-auth.loginIcon'] =
                $settings->get('blessing-auth.button_icon') ?: 'far fa-id-card';
        }
    }
}
