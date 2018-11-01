<?php

namespace Modules\Task\Models;

use Balping\HashSlug\HasHashSlug;
use Modules\Core\Models\CoreModel;
use Modules\Core\Traits\Model\Cacheable\Cacheable;
use Modules\Core\Traits\Model\Playable;
use Modules\User\Models\User;
use QCod\ImageUp\HasImageUploads;

class Task extends CoreModel
{
    // maintains created_by, updated_by and deleted_by
    use Playable;

    // automatic fake model id
    use HasHashSlug;

    // cache queries on the model
    use Cacheable;

    // to upload images
    use HasImageUploads;

    protected $fillable = [
        'user_id',
        'description',
        'file',
        'completed',
    ];

    protected $rules = [
        'description' => 'required|min:5',
    ];

    // Array of uploadable images. These fields need to be existent in your database table
    // https://github.com/qcod/laravel-imageup
    protected static $imageFields = [
        'file' => [
            'path' => 'task',
            'rules' => 'image|max:2000',
            'width' => 250,
            'height' => 150,
        ]
    ];


    ###################################################################
    # RELATIONSHIPS START
    ###################################################################

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    ###################################################################
    # RELATIONSHIPS END
    ###################################################################

    ###################################################################
    # SCOPES START
    ###################################################################

    public function scopeCompleted($query)
    {
        return $query->where('completed', 1);
    }

    public function scopeUncompleted($query)
    {
        return $query->where('completed', 1);
    }

    ###################################################################
    # SCOPES END
    ###################################################################

    ###################################################################
    # ACCESSROS START
    ###################################################################

    //

    ###################################################################
    # ACCESSROS END
    ###################################################################

    ###################################################################
    # MUTATORS START
    ###################################################################

    //

    ###################################################################
    # MUTATORS END
    ###################################################################

    ###################################################################
    # GENERAL FUNCTIONS START
    ###################################################################

    //

    ###################################################################
    # GENERAL FUNCTIONS END
    ###################################################################
}
