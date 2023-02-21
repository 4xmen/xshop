<?php

namespace App\Helpers;

use App\Models\Product;
use Xmen\StarterKit\Models\Post;

class Seo
{
    public static function post(Post $post)
    {
        $image = $post->getMedia()->count() > 0 ? $post->getMedia()->first()->getUrl('posts-image') : false;

        \SEOMeta::setTitle($post->title);
        \SEOMeta::setDescription($post->subtitle ? $post->subtitle : false);
        \SEOMeta::setKeywords($post->tags->pluck('name'));

        \OpenGraph::setDescription($post->subtitle);
        \OpenGraph::setTitle($post->title);
//        \OpenGraph::setUrl($post->url);
        \OpenGraph::addProperty('type', 'articles');
        \OpenGraph::addImage(\Storage::url($image));

        \JsonLd::setType('article');
        \JsonLd::addValue(
            'mainEntityOfPage',
            [
                'type' => 'WebPage',
//                'id' => $post->url,
//                'url' => $post->url,
                'inLanguage' => config('app.locale'),
                'name' => $post->title,
                'datePublished' => $post->created_at,
                'dateModified' => $post->updated_at,
                'description' => $post->subtitle,
            ]
        );
        \JsonLd::setTitle(\SEOMeta::getTitle());
        \JsonLd::addValue('headline', $post->title);
        \JsonLd::setDescription($post->subtitle);
        \JsonLd::addValue('articleSection', $post->categories->pluck('name')->implode('، '));
        \JsonLd::addValue(
            'author',
            [
                'type' => 'Person',
                'name' => $post->author->name,
            ]
        );
        \JsonLd::addValue(
            'publisher',
            [
                'type' => 'organization',
                'name' => $post->author->name,
                'url' => config('app.url'),
//                'logo' => [
//                    'type' => 'ImageObject',
//                    'url' => setting('site.logo'),
//                ],
            ]
        );
        \JsonLd::addValue('datePublished', $post->created_at);
        \JsonLd::addValue('dateModified', $post->updated_at);
        \JsonLd::addImage(\Storage::url($image));
    }

    public function product(Product $product)
    {
        $image = $product->getMedia()->count() > 0 ? $product->getMedia()->first()->getUrl('product-image') : false;

        \SEOMeta::setTitle($product->title);
        \SEOMeta::setDescription($product->excerpt ? $product->excerpt : false);
        \SEOMeta::setKeywords($product->tags->pluck('name'));

        \OpenGraph::setDescription($product->excerpt);
        \OpenGraph::setTitle($product->title);
        \OpenGraph::setUrl($product->url);
        \OpenGraph::addProperty('type', 'product');
        \OpenGraph::setProduct([
            'price:amount'=>$product->price,
            'price:currency'=>'IRR'
        ]);
        \OpenGraph::addImage(\Storage::url($product->image));

        \JsonLd::setType('Product');
        \JsonLd::addValue(
            'mainEntityOfPage',
            [
                'type' => 'WebPage',
                'id' => $product->url,
                'url' => $product->url,
                'inLanguage' => config('app.locale'),
                'name' => $product->name,
                'datePublished' => $product->created_at,
                'dateModified' => $product->updated_at,
                'description' => $product->excerpt,
            ]
        );
        \JsonLd::addValue('name', $product->name);
        \JsonLd::setDescription($product->excerpt ? $product->excerpt : false);
        if ($product->price) {
            \JsonLd::addValue(
                'offers',
                [
                    'type' => 'Offer',
                    'price' => $product->price,
                    'priceCurrency' => 'IRR',
                ]
            );
        }
        \JsonLd::addValue(
            'provider',
            [
                'type' => 'organization',
                'name' => self::setting('site.name'),
                'url' => config('app.url'),
                'logo' => [
                    'type' => 'ImageObject',
                    'url' => self::setting('site.logo'),
                ],
            ]
        );
        \JsonLd::addValue('datePublished', $product->created_at);
        \JsonLd::addValue('dateModified', $product->updated_at);
        \JsonLd::addImage(\Storage::url($image));

    }

    public static function setting($key)
    {
        return $key;
    }
}
