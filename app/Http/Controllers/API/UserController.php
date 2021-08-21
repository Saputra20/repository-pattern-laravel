<?php

namespace App\Http\Controllers\API;

use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\UserRepository;
use Excel;

class UserController extends Controller
{
    protected $userRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository();
    }

    public function index(Request $request)
    {
        return $this->userRepo->paginate();
    }

    public function export()
    {
        $data = $this->userRepo->all();
        $total = $data->count();

        return Excel::download(new UserExport($data, $total), 'User List ' . date('d M Y') . '.xlsx');
    }
}