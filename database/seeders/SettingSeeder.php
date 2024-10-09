<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $sections = [
            'General' => [
                [
                    'title' => __("Email"),
                    'key' => 'email',
                    'type' => 'TEXT',
                    'ltr' => true,
                    'value' => 'xshop@xstack.ir',
                    'size' => '6',
                ],
                [
                    'title' => __("Tel"),
                    'key' => 'tel',
                    'type' => 'TEXT',
                    'ltr' => true,
                    'value' => '+98-21-9988-7766',
                    'size' => '6',
                ],
                [
                    'title' => __("Subtitle"),
                    'key' => 'subtitle',
                    'type' => 'TEXT',
                    'value' => 'another shop with xShop',
                ],
                [
                    'title' => __("copyright"),
                    'key' => 'copyright',
                    'type' => 'TEXT',
                    'value' => 'xShop community © ' . date('Y'),
                ],
                [
                    'title' => __("Twitter (x)"),
                    'key' => 'social_twitter',
                    'type' => 'TEXT',
                    'size' => '4',
                    'ltr' => true,
                ],
                [
                    'title' => __("Facebook"),
                    'key' => 'social_facebook',
                    'type' => 'TEXT',
                    'size' => '4',
                    'ltr' => true,
                ],
                [
                    'title' => __("Instagram"),
                    'key' => 'social_instagram',
                    'type' => 'TEXT',
                    'size' => '4',
                    'ltr' => true,
                ],
                [
                    'title' => __("LinkedIn"),
                    'key' => 'social_linkedin',
                    'type' => 'TEXT',
                    'size' => '4',
                    'ltr' => true,
                ],

                [
                    'title' => __("Youtube"),
                    'key' => 'social_youtube',
                    'type' => 'TEXT',
                    'size' => '4',
                    'ltr' => true,
                ],
                [
                    'title' => __("Telegram"),
                    'key' => 'social_telegram',
                    'type' => 'TEXT',
                    'size' => '4',
                    'ltr' => true,
                ],
                [
                    'title' => __('Under construction'),
                    'key' => 'under',
                    'type' => 'CHECKBOX',
                    'value' => 0,
                ],
                [
                    'title' => __('Cache'),
                    'key' => 'cache_number',
                    'type' => 'TEXT',
                    'value' => 0,
                    'active' => false,
                ],

            ],
            'SMS' => [
                [
                    'title' => __("Sign-in authentication"),
                    'key' => 'sign',
                    'type' => 'LONGTEXT',
                    'value' => 'sign',
                ],
                [
                    'title' => __("Order confirmation"),
                    'key' => 'order',
                    'type' => 'LONGTEXT',
                    'value' => 'order',
                ],
                [
                    'title' => __("Sent message"),
                    'key' => 'sent',
                    'type' => 'LONGTEXT',
                    'value' => 'sent',
                ],
            ],
            'SEO' => [
                [
                    'title' => __("Common keyword"),
                    'key' => 'keyword',
                    'type' => 'TEXT',
                    'value' => 'shop,xshop, sale, xStack',
                ],
                [
                    'title' => __("Common description"),
                    'key' => 'desc',
                    'type' => 'TEXT',
                    'value' => 'Best customizable shop in the world',
                ],
                [
                    'title' => __("Google Webmaster code"),
                    'key' => 'google-webmaster-code',
                    'type' => 'CODE',
                ],
                [
                    'title' => __("SEO image"),
                    'key' => 'site_image',
                    'type' => 'FILE',
                ],
                [
                    'title' => __("Product description template"),
                    'value' => __("%name% sale in our shop by %price% %category.name%"),
                    'key' => 'product_description',
                    'type' => 'TEXT',
                ],
                [
                    'title' => __("Guarantee"),
                    'key' => 'guarantee',
                    'type' => 'TEXT',
                    'value' => '',
                ],
            ],
            'Media' => [
                [
                    'title' => __("Logo (svg)"),
                    'key' => 'logo_svg',
                    'type' => 'FILE',
                ],
                [
                    'title' => __("Logo (png)"),
                    'key' => 'logo_png',
                    'type' => 'FILE',
                ],
                [
                    'title' => __('Optimize type'),
                    'key' => 'optimize',
                    'type' => 'TEXT',
                    'value' => 'webp',
                    'size' => '4',
                ],
                [
                    'title' => __('Watermark (product, gallery, post) '),
                    'key' => 'watermark',
                    'type' => 'CHECKBOX',
                    'value' => false,
                    'size' => '4',
                ],
                [
                    'title' => __('Watermark ( category, slider, group)'),
                    'key' => 'watermark2',
                    'type' => 'CHECKBOX',
                    'value' => false,
                    'size' => '4',
                ],
                [
                    'title' => __('Product thumbnail size'),
                    'key' => 'product_image',
                    'type' => 'TEXT',
                    'value' => '1200x1200',
                    'size' => '6',
                ],
                [
                    'title' => __('Product image size'),
                    'key' => 'product_thumb',
                    'type' => 'TEXT',
                    'value' => '500x500',
                    'size' => '6',
                ],
                [
                    'title' => __('Post thumbnail size'),
                    'key' => 'post_thumb',
                    'type' => 'TEXT',
                    'value' => '500x500',
                    'size' => '6',
                ],
                [
                    'title' => __('Gallery thumbnail size'),
                    'key' => 'gallery_thumb',
                    'type' => 'TEXT',
                    'value' => '900x900',
                    'size' => '6',
                ],
            ]
        ];
        foreach ($sections as $section => $section_data) {
            foreach ($section_data as $set) {

                $setting = new Setting();
                $setting->title = $set['title'];
                $setting->section = $section;
                $setting->key = $set['key'];
                $setting->value = $set['value'] ?? null;
                $setting->type = $set['type'] ?? 'TEXT';
                $setting->ltr = $set['ltr'] ?? false;
                $setting->active = $set['active'] ?? true;
                $setting->is_basic = true;
                $setting->size = $set['size'] ?? 12;;
                $setting->save();
            }
        }
    }
}
