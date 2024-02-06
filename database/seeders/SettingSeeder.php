<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if (config('app.xlang')){
            $lang = config('app.xlang_main');
            \DB::insert(<<<SQL

INSERT INTO `settings` (`id`, `section`, `type`, `title`, `active`, `key`, `value`, `created_at`, `updated_at`) VALUES
	(NULL, '1menu', 'image', 'Logo', 1, 'logo_png', NULL, '2022-08-02 00:14:57', '2022-08-02 00:14:57'),
	(NULL, '2top', 'text', 'Main section title', 1, 'top1text', '{"$lang":"\\u062a\\u0633\\u062a","ru":"\\u0442\\u0435\\u0441\\u0442"}', '2022-08-02 00:23:04', '2024-02-06 03:17:09'),
	(NULL, '2top', 'cat', 'Category of the main section', 1, 'top1cat', '{"$lang":"1"}', '2022-08-02 00:23:35', '2022-08-02 00:53:57'),
	(NULL, '2top', 'text', 'Title of the above section', 1, 'top2text', '{"$lang":"33%"}', '2022-08-02 00:23:04', '2024-02-06 03:14:33'),
	(NULL, '2top', 'cat', 'Category of the above section', 1, 'top2cat', '{"$lang":"1"}', '2022-08-02 00:23:35', '2022-08-02 00:54:06'),
	(NULL, '2top', 'text', 'Title of the bottom section', 1, 'top3text', '{"$lang":"15%"}', '2022-08-02 00:23:04', '2024-02-06 03:14:33'),
	(NULL, '2top', 'cat', 'Category of the bottom section', 1, 'top3cat', '{"$lang":"1"}', '2022-08-02 00:23:35', '2022-08-02 00:54:06'),
	(NULL, '3top', 'text', 'Title of the second section', 1, 'sectext', '{"$lang":"\\u0633\\u0627\\u06cc\\u0631 \\u0645\\u062d\\u0635\\u0648\\u0644\\u0627\\u062a"}', '2022-08-02 00:23:04', '2024-02-06 03:14:33'),
	(NULL, '3top', 'cat', 'Category of the second section', 1, 'seccat', '{"$lang":"1"}', '2022-08-02 00:23:35', '2022-08-02 00:54:06'),
	(NULL, '4sec', 'text', 'Title of the third section with filters', 1, '3text', '{"$lang":"\\u0644\\u0648\\u0627\\u0632\\u0645 \\u062c\\u0627\\u0646\\u0628\\u06cc"}', '2022-08-02 00:33:47', '2024-02-06 03:14:33'),
	(NULL, '4sec', 'cat', 'Category of the third section with filters', 1, '3cat', '{"$lang":"1"}', '2022-08-02 00:34:35', '2022-08-02 00:54:06'),
	(NULL, '5sec', 'cat', 'Brand category', 1, '4cat', '{"$lang":"1"}', '2022-08-02 00:34:35', '2022-08-02 00:54:06'),
	(NULL, '6footer', 'category', 'Right footer category', 1, 'footer1', '{"$lang":"1"}', '2022-08-02 00:38:10', '2022-08-02 00:54:06'),
	(NULL, '6footer', 'category', 'Center footer', 1, 'footer2', '{"$lang":"4"}', '2022-08-02 00:38:42', '2022-09-12 01:27:55'),
	(NULL, '6footer', 'code', 'Right footer', 1, 'footer3', '{"$lang":"<img src=\\"http:\\/\\/parsavps.com\\/enamad.png\\" width=\\"145px\\" \\/>"}', '2022-08-02 00:40:14', '2024-02-06 03:14:33'),
	(NULL, '6footer', 'text', 'Instagram social network', 1, 'soc_in', '{"$lang":null}', '2022-08-02 00:41:20', '2024-02-06 03:14:33'),
	(NULL, '6footer', 'text', 'Telegram social network', 1, 'soc_tg', '{"$lang":null}', '2022-08-02 00:41:20', '2024-02-06 03:14:33'),
	(NULL, '6footer', 'text', 'Twitter social network', 1, 'soc_tw', '{"$lang":"https:\\/\\/twitter.com\\/a1gard"}', '2022-08-02 00:41:20', '2024-02-06 03:14:33'),
	(NULL, '6footer', 'text', 'WhatsApp social network (country code number)', 1, 'soc_wp', '{"$lang":"+989121234567"}', '2022-08-02 00:41:20', '2024-02-06 03:14:33'),
	(NULL, '6footer', 'text', 'YouTube social network', 1, 'soc_yt', '{"$lang":null}', '2022-08-02 00:41:20', '2024-02-06 03:14:33'),
	(NULL, '6footer', 'text', 'Footer title', 1, 'footer_title', '{"$lang":"\\u0627\\u0637\\u0644\\u0627\\u0639\\u0627\\u062a \\u062a\\u0645\\u0627\\u0633"}', '2022-08-02 00:41:20', '2024-02-06 03:14:33'),
	(NULL, '6footer', 'editor', 'Footer text', 1, 'footer_text', '{"$lang":"<p>\\u0627\\u0641\\u0631\\u0627\\u062f \\u06af\\u0631\\u0648\\u0647 \\u0633\\u0648\\u0645 \\u0627\\u0632 \\u0627\\u0647\\u0645\\u06cc\\u062a \\u0628\\u0647 \\u067e\\u0627\\u06cc\\u0627\\u0646 \\u0631\\u0633\\u0627\\u0646\\u062f\\u0646 \\u0622\\u06af\\u0627\\u0647 \\u0647\\u0633\\u062a\\u0646\\u062f. \\u0622\\u0646\\u0647\\u0627 \\u0628\\u0627 \\u062a\\u0641\\u06a9\\u0631 \\u0645\\u0646\\u0637\\u0642\\u06cc\\u060c \\u0637\\u0631\\u062d\\u06cc \\u0631\\u0648\\u0634\\u0646 \\u0627\\u0631\\u0627\\u0626\\u0647 \\u0645\\u06cc&zwnj;\\u06a9\\u0646\\u0646\\u062f. \\u0622\\u0646\\u0647\\u0627 \\u0646\\u0647 \\u062a\\u0646\\u0647\\u0627 \\u0628\\u0631\\u0627\\u06cc \\u067e\\u0627\\u06cc\\u0627\\u0646 \\u062f\\u0627\\u062f\\u0646 \\u0628\\u0647 \\u067e\\u0631\\u0648\\u0698\\u0647&zwnj;\\u06cc \\u062e\\u0648\\u062f \\u062f\\u0631 \\u0622\\u06cc\\u0646\\u062f\\u0647 \\u0628\\u0631\\u0646\\u0627\\u0645\\u0647 \\u0631\\u06cc\\u0632\\u06cc \\u0645\\u06cc&zwnj;\\u06a9\\u0646\\u0646\\u062f\\u060c \\u0628\\u0644\\u06a9\\u0647 \\u0628\\u0647 \\u062a\\u0645\\u0627\\u0645 \\u0646\\u062a\\u0627\\u06cc\\u062c \\u0648 \\u0639\\u0648\\u0627\\u0642\\u0628 \\u0627\\u062c\\u0631\\u0627\\u06cc \\u0622\\u0646 \\u0628\\u0631\\u0646\\u0627\\u0645\\u0647 \\u0647\\u0645 \\u0645\\u06cc&zwnj;\\u0627\\u0646\\u062f\\u06cc\\u0634\\u0646\\u062f. \\u0627\\u06cc\\u0646 \\u0627\\u0641\\u0631\\u0627\\u062f \\u06a9\\u0633\\u0627\\u0646\\u06cc \\u0647\\u0633\\u062a\\u0646\\u062f \\u06a9\\u0647 \\u0647\\u0646\\u0631 \\u0628\\u0647 \\u067e\\u0627\\u06cc\\u0627\\u0646 \\u0631\\u0633\\u0627\\u0646\\u062f\\u0646 \\u0631\\u0627 \\u0645\\u06cc&zwnj;\\u062f\\u0627\\u0646\\u0646\\u062f.<\\/p>"}', '2022-08-02 00:41:20', '2024-02-06 03:14:33'),
	(NULL, '7seo', 'text', 'Website color code', 1, 'color', '{"$lang":"#3593D2"}', '2022-08-02 00:48:38', '2024-02-06 03:14:33'),
	(NULL, '7seo', 'text', 'SEO keywords', 1, 'keywords', '{"$lang":"\\u0641\\u0631\\u0648\\u0634\\u06af\\u0627\\u0647\\u060c \\u0641\\u0631\\u0648\\u0634 \\u0622\\u0646\\u0644\\u0627\\u06cc\\u0646"}', '2022-08-02 00:49:10', '2024-02-06 03:14:33'),
	(NULL, '7seo', 'text', 'SEO details', 1, 'desc', '{"$lang":"\\u062a\\u0648\\u0636\\u06cc\\u062d\\u0627\\u062a \\u0641\\u0631\\u0648\\u0634\\u06af\\u0627\\u0647 \\u0634\\u0645\\u0627"}', '2022-08-02 00:50:08', '2024-02-06 03:14:33'),
	(NULL, '7seo', 'text', 'Copyright text', 1, 'copyright', '{"$lang":"\\u06a9\\u0644\\u06cc\\u0647 \\u062d\\u0642\\u0648\\u0642 \\u0628\\u0631\\u0627\\u06cc \\u0648\\u0628\\u0633\\u0627\\u06cc\\u062a \\u0641\\u0631\\u0648\\u0634\\u06af\\u0627\\u0647 \\u0645\\u062d\\u0641\\u0648\\u0638 \\u0627\\u0633\\u062a"}', '2022-08-02 01:10:18', '2024-02-06 03:14:33'),
	(NULL, '1menu', 'text', 'Copyright text', 1, 'tel', '{"$lang":"021"}', '2023-02-22 20:51:33', '2024-02-06 03:14:33'),
	(NULL, '1menu', 'text', 'Email', 1, 'email', '{"$lang":"info@local"}', '2023-02-22 20:51:53', '2024-02-06 03:14:33'),
	(NULL, 'seo', 'text', 'Website name', 1, 'site_name', '{"$lang":"\\u0641\\u0631\\u0648\\u0634\\u06af\\u0627\\u0647 \\u0627\\u06cc\\u06a9\\u0633 \\u0634\\u0627\\u067e"}', '2022-09-14 05:16:58', '2024-02-06 03:14:33'),
	(NULL, 'seo', 'text', 'Brief website description (SEO)', 1, 'site_description', '{"$lang":"\\u0628\\u0647 \\u0631\\u0648\\u0632\\u062a\\u0631\\u06cc\\u0646 \\u06af\\u0648\\u0634\\u06cc \\u0647\\u0627 \\u0628\\u0627 \\u06a9\\u0645\\u062a\\u0631\\u06cc\\u0646 \\u0642\\u06cc\\u0645\\u062a"}', '2022-09-14 05:18:23', '2024-02-06 03:14:33'),
	(NULL, 'seo', 'text', 'Website keywords (SEO - use "," to break)', 1, 'site_keywords', '{"$lang":"\\u06af\\u0648\\u0634\\u06cc\\u060c\\u0627\\u0631\\u0632\\u0627\\u0646\\u060c\\u062e\\u0631\\u06cc\\u062f\\u060c\\u0627\\u06cc\\u06a9\\u0633 \\u0634\\u0627\\u067e"}', '2022-09-14 05:22:56', '2024-02-06 03:14:33'),
	(NULL, 'seo', 'text', 'Google Webmaster code', 1, 'site_webmaster_google', '{"$lang":null}', '2022-09-14 05:29:17', '2024-02-06 03:14:33'),
	(NULL, 'seo', 'image', 'Site image(SEO)', 1, 'site_image', NULL, '2022-09-14 05:30:51', '2022-09-14 05:30:51');
SQL);
        }else{

        //
        \DB::insert(<<<SQL
REPLACE INTO `settings` (`id`, `section`, `type`, `title`, `active`, `key`, `value`, `created_at`, `updated_at`) VALUES
	(NULL, '1menu', 'image', 'Logo', 1, 'logo_png', NULL, '2022-08-02 04:44:57', '2022-08-02 04:44:57'),
	(NULL, '2top', 'text', 'Main section title', 1, 'top1text', 'Best-selling products', '2022-08-02 04:53:04', '2022-08-02 05:23:03'),
	(NULL, '2top', 'cat', 'Main section category', 1, 'top1cat', '1', '2022-08-02 04:53:35', '2022-08-02 05:23:57'),
	(NULL, '2top', 'text', 'Title of the above section', 1, 'top2text', '33%', '2022-08-02 04:53:04', '2022-08-02 05:24:06'),
	(NULL, '2top', 'cat', 'Category of the top section', 1, 'top2cat', '1', '2022-08-02 04:53:35', '2022-08-02 05:24:06'),
	(NULL, '2top', 'text', 'Title of the bottom section', 1, 'top3text', '15%', '2022-08-02 04:53:04', '2022-08-02 05:24:06'),
	(NULL, '2top', 'cat', 'Category of the bottom section', 1, 'top3cat', '1', '2022-08-02 04:53:35', '2022-08-02 05:24:06'),
	(NULL, '3top', 'text', 'Title of the second section', 1, 'sectext', 'Other products', '2022-08-02 04:53:04', '2022-08-02 05:24:06'),
	(NULL, '3top', 'cat', 'Category of the second section', 1, 'seccat', '1', '2022-08-02 04:53:35', '2022-08-02 05:24:06'),
	(NULL, '4sec', 'text', 'Title of the third section with filters', 1, '3text', 'Accessories', '2022-08-02 05:03:47', '2022-08-02 05:24:06'),
	(NULL, '4sec', 'cat', 'Category of the third section with filters', 1, '3cat', '1', '2022-08-02 05:04:35', '2022-08-02 05:24:06'),
	(NULL, '5sec', 'cat', 'Brand category', 1, '4cat', '1', '2022-08-02 05:04:35', '2022-08-02 05:24:06'),
	(NULL, '6footer', 'category', 'Right footer category', 1, 'footer1', '1', '2022-08-02 05:08:10', '2022-08-02 05:24:06'),
	(NULL, '6footer', 'category', 'Center footer', 1, 'footer2', '4', '2022-08-02 05:08:42', '2022-09-12 05:57:55'),
	(NULL, '6footer', 'code', 'Right footer', 1, 'footer3', '<img src="http://parsavps.com/enamad.png" width="145px" />', '2022-08-02 05:10:14', '2022-08-02 05:31:52'),
	(NULL, '6footer', 'text', 'Instagram social network', 1, 'soc_in', NULL, '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(NULL, '6footer', 'text', 'Telegram social network', 1, 'soc_tg', NULL, '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(NULL, '6footer', 'text', 'Twitter social network', 1, 'soc_tw', 'https://twitter.com/a1gard', '2022-08-02 05:11:20', '2022-08-02 05:24:06'),
	(NULL, '6footer', 'text', 'WhatsApp social network (country code number)', 1, 'soc_wp', '+989121234567', '2022-08-02 05:11:20', '2022-08-02 05:27:02'),
	(NULL, '6footer', 'text', 'YouTube social network', 1, 'soc_yt', NULL, '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(NULL, '6footer', 'text', 'Footer title', 1, 'footer_title', 'Contact information', '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(NULL, '6footer', 'editor', 'Footer text', 1, 'footer_text', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. ', '2022-08-02 05:11:20', '2022-08-02 05:11:20'),
	(NULL, '7seo', 'text', 'Website color code', 1, 'color', '#3593D2', '2022-08-02 05:18:38', '2022-08-02 05:24:06'),
	(NULL, '7seo', 'text', 'SEO keywords', 1, 'keywords', 'Store, online selling', '2022-08-02 05:19:10', '2022-08-02 05:24:06'),
	(NULL, '7seo', 'text', 'SEO details (Use "," to break)', 1, 'desc', 'Description of your store', '2022-08-02 05:20:08', '2022-08-02 05:24:06'),
	(NULL, '7seo', 'text', 'Copyright text', 1, 'copyright', 'All rights reserved for the store website', '2022-08-02 05:40:18', '2022-08-02 05:40:37'),
	(NULL, '1menu', 'text', 'Phone', 1, 'tel', NULL, '2023-02-23 00:21:33', '2023-02-23 00:21:33'),
	(NULL, '1menu', 'text', 'Email', 1, 'email', NULL, '2023-02-23 00:21:53', '2023-02-23 00:21:53');
SQL
);
        \DB::insert(<<<SQL
insert into settings (`id`, `section`, `type`, title, `active`, `key`, `value`, `created_at`, `updated_at`)
values  (null, 'seo', 'text', 'Site name', 1, 'site_name', 'Xshop', '2022-09-14 09:46:58', '2022-09-14 09:47:20'),
        (null, 'seo', 'text', 'Short description of the site (SEO)', 1, 'site_description', 'The most up-to-date phones at the lowest prices', '2022-09-14 09:48:23', '2022-09-14 09:48:39'),
        (null, 'seo', 'text', 'SEO keywords (Use "," to break)', 1, 'site_keywords', 'Phone, cheap, buy, Xshop', '2022-09-14 09:52:56', '2022-09-14 09:53:41'),
        (null, 'seo', 'text', 'Google web master code', 1, 'site_webmaster_google', null, '2022-09-14 09:59:17', '2022-09-14 09:59:17'),
        (null, 'seo', 'image', 'Site image (SEO)', 1, 'site_image', null, '2022-09-14 10:00:51', '2022-09-14 10:00:51');
SQL
);
        }
    }
}
