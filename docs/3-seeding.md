# Seeding

## What is the Seeding System?

Seeding is a method to generate fake or sample data, allowing for an easier startup of your application.

## Default Seeder Details

The default seeders generate the following data:

- **Users**: 3 users (the first user is essential for login)
- **Groups**: 6 groups
- **Posts**: 55 posts
- **States & Cities**: 31 states and 1,111 cities for user location selection
- **Customers**: 35 customers
- **Categories**: 13 categories for digital products
- **Props or Properties**: 8 sample properties for the first and second categories
- **Products**: 31 products
- **Comments**: 55 sample comments associated with posts and products
- **Setting**: Various settings categorized into [General, SEO, Media, SMS, Theme] (this is an essential seeder)
- **GFX**: GFX seeder adds website graphic details (this is an essential seeder)
- **Area**: Areas designed for website sections needed for theme parts (this is an essential seeder)
- **Invoices**: 71 user invoices corresponding to orders based on products and customers
- **VisitorSeeder**: Generates fake website visit statistics
- **Transport Methods**: 2 transport methods
- **Menu**: One menu containing 4 items
- **Slider**: 3 slider items
- **Part**: The Part seeder is responsible for theme sections (if you disable this seeder, your website will lack design and require manual setup)
- **Evaluation**: Evaluations for the rating system

## How to Disable or Change Seeders

The main data seeder class is located in the `database/seeder/DataSeeder` directory. You can comment out specific seeders or modify them by accessing their respective sub-classes. For example, the `VisitorSeeder` can be adjusted like this:

```php
$this->call([
    XLangSeeder::class,
    UserSeeder::class,
    GroupSeeder::class,
    PostSeeder::class,
    StateSeeder::class,
    CustomerSeeder::class,
    CategorySeeder::class,
    PropSeeder::class,
    ProductSeeder::class,
    CommentSeeder::class,
    SettingSeeder::class,
    GfxSeeder::class,
    AreaSeeder::class,
    InvoiceSeeder::class,
    VisitorSeeder::class,
    TransportSeeder::class,
    MenuSeeder::class,
    SliderSeeder::class,
    PartSeeder::class,
    EvaluationSeeder::class,
]);
```

VisitorSeeder sample:

```php
public function run(): void
{
    //
    Visitor::factory()->count(1250)->create();
}
```


## Image seeding

- Download & prepare images
```bash
php artisan seeding:prepare
 ```
- nor copy your image folder to `database/seeders/images/`
- then: Seeding image for models: [`Group`, `Category`, `Post`, `Product`, `Slider`]

```bash
php artisan seeding:image Product digital
```

Or to seed all models:

```bash
php artisan seeding:all digital
```

## Prepare and downloaded image repository

- The repository is https://github.com/A1Gard/xshop-installer-assets
- images from unsplash free license




