<?php
namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class MenuFilter implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['permission']) && !auth()->user()->hasPermissionTo($item['permission'])) {
            \Log::info('Menu item hidden due to lack of permission', ['item' => $item]);
            return null; // Return null to hide the item
        }
        \Log::debug('Menu item displayed', ['item' => $item]);
        return $item;
    }
}
