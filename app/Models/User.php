<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'role',
        'gender',
        'address',
        'phone_number',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $incrementing = false;

    // Event "creating" untuk otomatis mengisi pengkodean id
    protected static function booted(): void
    {
        static::creating(function ($user) {
            if (!$user->id) {
                // Kamu bisa menyesuaikan logic roleCode di sini
                $user->id = self::generateId(self::roleCode($user->role ?? 'admin'));
            }
        });
    }
    
    public static function generateId(int $roleCode): int
    {
        $dateCode = now()->format('ymd'); // format YYMMDD, contoh: 250623

        $count = self::whereDate('created_at', today())
            ->where('id', 'like', "{$roleCode}{$dateCode}%")
            ->count() + 1;

        $order = min($count, 9); // hanya 1 digit

        return (int)("{$roleCode}{$dateCode}{$order}");
    }

    public static function roleCode(string $role): int
    {
        return [
            'admin' => 1,
            'kurir' => 2,
            'owner' => 3,
        ][$role] ?? 9; // 9 = undefined
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }
}
