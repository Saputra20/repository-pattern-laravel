<?php

namespace App\Http\Repository;

use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(new Transaction());
    }
}
