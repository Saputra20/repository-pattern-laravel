<?php

namespace App\Http\Repository;

use App\Models\Business;

class BusinessRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(new Business());
    }
}
