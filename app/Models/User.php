<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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


    public function profile()
    {
        return $this->morphOne(Profile::class, 'profileable');
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Profile::class);
    }

    public function posts()
    {
        return $this->hasManyThrough(Post::class, Profile::class);
    }

    public function likesPost()
    {
        return $this->hasMany(Post::class);
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getIsAdminAttribute(): bool
    {
        return auth()->user()->roles->contains('title', 'admin');
    }

    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('title', $role);
        }

        if (is_array($role)) {
            return $this->roles->whereIn('title', $role)->isNotEmpty();
        }

        return false;
    }


    public function hasPermission($permission): bool
    {
        return $this->roles->flatMap(function ($role){
            return $role->permissions;
        })->contains('name', $permission);


    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role_user', 'user_id', 'permission_id');
    }











}
