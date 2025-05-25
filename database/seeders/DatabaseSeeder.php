<?php


namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanyFeedback;
use App\Models\CompanyResponsibleInfo;
use App\Models\DayCollect;
use App\Models\DiscountType;
use App\Models\Order;
use App\Models\OrderRejection;
use App\Models\OrdersHistory;
use App\Models\OrdersItem;
use App\Models\Payment;
use App\Models\PaymentTerm;
use App\Models\PriceRequest;
use App\Models\PriceRequestRejection;
use App\Models\PriceRequestedItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductsCategory;
use App\Models\productVariant;
use App\Models\ProductVariantAttribute;
use App\Models\productVariantAttributeValue;
use App\Models\ProductVendor;
use App\Models\Role;
use App\Models\TempProduct;
use App\Models\TempProductsVendor;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorResponsibleInfo;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed independent tables first
        Attribute::factory(5)->create();
        AttributeValue::factory(5)->create();
        Role::factory(27)->create();
        $this->call(CitySeeder::class);
        DiscountType::factory()->count(5)->create();
        Category::factory()->count(10)->create();
        Vendor::factory()->count(15)->create();
        TempProduct::factory()->count(20)->create();

        // Seed users (depends on roles)
        User::factory()->count(20)->create();

        // Seed companies (depends on cities, discount types,users)
        PaymentTerm::factory()->count(10)->create();
        Company::factory()->count(20)->create();

        // Seed company-related tables
        CompanyResponsibleInfo::factory()->count(30)->create();
        CompanyFeedback::factory()->count(40)->create();

        // Seed products and related tables
        Product::factory()->count(50)->create();

        VendorResponsibleInfo::factory()->count(10)->create();

        // Seed pivot tables
        ProductsCategory::factory()->count(10)->create();
        productVariant::factory()->count(10)->create();
        productVariantAttributeValue::factory()->count(10)->create();
        ProductVendor::factory()->count(20)->create();
        TempProductsVendor::factory()->count(10)->create();

        // Seed price requests and related tables
        PriceRequest::factory()->count(20)->create();
        PriceRequestRejection::factory()->count(5)->create();
        PriceRequestedItem::factory()->count(30)->create();

        // Seed orders and related tables
        Order::factory()->count(30)->create();
        OrdersItem::factory()->count(60)->create();
        OrdersHistory::factory()->count(40)->create();
        OrderRejection::factory()->count(10)->create();
        Payment::factory()->count(5)->create();
        // Seed day collect
        DayCollect::factory()->count(25)->create();
    }
}
