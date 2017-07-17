<?php namespace Octobro\API\Models;

use Model;

/**
 * OAuthSession Model
 */
class OAuthSession extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'oauth_sessions';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
