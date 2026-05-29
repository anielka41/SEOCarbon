<?php

declare(strict_types=1);

namespace App\Filament\Resources\Settings\Settings;

use App\Domain\Shared\Models\Setting;
use App\Filament\Resources\Settings\Settings\Pages\CreateSetting;
use App\Filament\Resources\Settings\Settings\Pages\EditSetting;
use App\Filament\Resources\Settings\Settings\Pages\ListSettings;
use App\Filament\Resources\Settings\Settings\Schemas\SettingSchema;
use App\Filament\Resources\Settings\Settings\Tables\SettingTable;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Override;
use UnitEnum;

final class SettingResource extends Resource
{
    #[Override]
    protected static ?string $model = Setting::class;

    #[Override]
    protected static ?string $slug = 'settings';

    #[Override]
    protected static ?string $recordTitleAttribute = 'key';

    #[Override]
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    #[Override]
    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    #[Override]
    public static function form(Schema $schema): Schema
    {
        return SettingSchema::configure($schema);
    }

    #[Override]
    public static function table(Table $table): Table
    {
        return SettingTable::configure($table);
    }

    /**
     * @return array<string, PageRegistration>
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListSettings::route('/'),
            'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }
}
