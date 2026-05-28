<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Domain\Users\Enums\UserRole;
use App\Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Override;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    #[Override]
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->afterCreating(function (User $user): void {
            Role::findOrCreate(UserRole::Admin->value, 'web');
            $user->assignRole(UserRole::Admin->value);
        });
    }

    public function moderator(): static
    {
        return $this->afterCreating(function (User $user): void {
            Role::findOrCreate(UserRole::Moderator->value, 'web');
            $user->assignRole(UserRole::Moderator->value);
        });
    }

    public function superAdmin(): static
    {
        return $this->afterCreating(function (User $user): void {
            Role::findOrCreate(UserRole::SuperAdmin->value, 'web');
            $user->assignRole(UserRole::SuperAdmin->value);
        });
    }
}
