<?php

use Illuminate\Database\Seeder;
use App\Models\ConfigItem;

class InitialConfigItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configItem = new ConfigItem();
        $configItem->description = 'Sets email address that send rdn website general emails';
        $configItem->key = 'rdn.general.email.from';
        $configItem->value = 'noreply@resumendenoticias.com';
        $configItem->save();

        $configItem = new ConfigItem();
        $configItem->description = 'Sets name that send rdn website general emails';
        $configItem->key = 'rdn.general.email.name';
        $configItem->value = 'RDN';
        $configItem->save();

        $configItem = new ConfigItem();
        $configItem->description = 'Sets paginator sizes for administrator list views';
        $configItem->key = 'rdn.admin.paginator-sizes';
        $configItem->value = '10,25,50,100,200';
        $configItem->save();
        
        $configItem = new ConfigItem();
        $configItem->description = 'Sets default paginator size value that administrator list views must have';
        $configItem->key = 'rdn.admin.paginator-default.value';
        $configItem->value = '50';
        $configItem->save();
        
        $configItem = new ConfigItem();
        $configItem->description = 'Sets max value for news categories orders';
        $configItem->key = 'rdn.admin.news-category.order.max-value';
        $configItem->value = '20';
        $configItem->save();
        
        $configItem = new ConfigItem();
        $configItem->description = 'Sets paginator size for app list views';
        $configItem->key = 'rdn.app.paginator-size';
        $configItem->value = '20';
        $configItem->save();
        
        $configItem = new ConfigItem();
        $configItem->description = 'Sets paginator size for blog section list views';
        $configItem->key = 'rdn.app.blog-section-paginator-size';
        $configItem->value = '20';
        $configItem->save();
        
        $configItem = new ConfigItem();
        $configItem->description = 'Sets offset days for news digests search';
        $configItem->key = 'rdn.app.search-offset-days';
        $configItem->value = '20';
        $configItem->save();
    }
}
