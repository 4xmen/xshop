<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasApiTokens;

    static $roles = ['DEVELOPER', 'ADMIN', 'USER', 'SUSPENDED'];

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

    public function getRouteKeyName()
    {
        return 'email';
    }

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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postsPercent()
    {
        if (Post::count() == 0) {
            return 100;
        }
        return $this->posts()->count() * 100 / Post::count();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function productsPercent()
    {

        if (Product::count() == 0) {
            return 100;
        }
        return $this->products()->count() * 100 / Product::count();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function ticketsPercent()
    {
        if (Ticket::count() == 0) {
            return 100;
        }
        return $this->tickets()->count() * 100 / Ticket::count();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentator');
    }

    public function commentsPercent()
    {
        if (Comment::count() == 0) {
            return 100;
        }
        return $this->comments()->count() * 100 / Comment::count();
    }

    public function logs()
    {
        return $this->hasMany(AdminLog::class, 'user_id', 'id');
    }

    public function accesses()
    {
        return $this->hasMany(Access::class);
    }

    public function hasAnyAccess($name)
    {
        if ($this->hasRole('SUSPENDED')) {
            return false;
        }
        if ($this->hasRole('admin') || $this->hasRole('developer')) {
            return true;
        }
        return $this->accesses()->where('route', 'LIKE', '%.' . $name . '.%')->count() > 0;
    }

    public function hasAnyAccesses($array)
    {
        if ($this->hasRole('SUSPENDED')) {
            return false;
        }
        if ($this->hasRole('admin') || $this->hasRole('developer')) {
            return true;
        }
        foreach ($array as $access) {
            if ($this->hasAnyAccess($access)) {
                return true;
            }
        }
    }

    public function hasAccess($route)
    {
        if ($this->hasRole('SUSPENDED')) {
            return false;
        }
        return $this->accesses()->where('route', $route)->count() > 0;
    }


    public function evaluations(){

        return Evaluation::where(function ($query) {
            $query->whereNull('evaluationable_type')
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query) {
            $query->where('evaluationable_type', User::class)
                ->whereNull('evaluationable_id');
        })->orWhere(function ($query ) {
            $query->where('evaluationable_type', User::class)
                ->where('evaluationable_id',$this->id);
        })->get();
    }


    public function avatar(){
        if ($this->avatar == null || trim($this->avatar) == ''){
            return asset('assets/default/unknown.svg');
        }


        return \Storage::url('users/' . $this->avatar);
    }
}
