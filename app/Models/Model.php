<?php
/**
 * Thrive Themes - https://thrivethemes.com
 *
 * @package forum
 */

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 *
 * Used so that all the other models extend from it, so do not add the fillable property to all of them
 */
class Model extends BaseModel {

    /**
     * @var array
     */
    protected $guarded = [];
}
