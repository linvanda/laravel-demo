<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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

    public static function boot()
    {
        parent::boot();

        // 监听creating事件
        static::creating(function ($user) {
            $user->activation_token = str_random(30);
        });
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
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
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
}
