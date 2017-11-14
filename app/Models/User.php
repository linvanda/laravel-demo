<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use TCG\Voyager\Models\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function boot()
    {
        parent::boot();

        // 监听creating事件
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });

        // 全局作用域
        static::addGlobalScope('activated', function (Builder $builder) {
            return $builder->where('activated', 1);
        });
    }

    /**
     * 访问器
     *
     * @param $value
     * @return string
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    /**
     * 本地作用域
     *
     * @param Builder $builder
     * @return $this
     */
    public static function scopeAdmin(Builder $builder)
    {
        return $builder->where('is_admin', 1);
    }

    public static function scopeOfName(Builder $builder, $name)
    {
        return $builder->where('name', $name);
    }

    /**
     * 关注
     *
     * @param $userIds
     */
    public function follow($userIds)
    {
        $this->following()->sync($userIds, false);
    }

    /**
     * 取消关注
     *
     * @param $userIds
     */
    public function unfollow($userIds)
    {
        $this->following()->detach($userIds);
    }

    public function isFollowing($userId)
    {
        return $this->following()->allRelatedIds()->contains($userId);
    }

    /**
     * 动态列表
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * 粉丝列表
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')
            ->withPivot(['id'])->withTimestamps()->wherePivot('id', '<', 59);
    }

    /**
     * 关注人列表
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function avatar($size = 100)
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));

        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    /**
     * 动态列表，包括当前用户以及其关注的用户的动态
     *
     */
    public function feeds()
    {
        $userIds = $this->following->pluck('id')->toArray();
        $userIds[] = $this->id;

        return Status::whereIn('user_id', $userIds)->with('user')->orderByDesc('created_at');
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }
}
