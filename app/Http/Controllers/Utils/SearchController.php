<?php

namespace App\Http\Controllers\Utils;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Search for a user
     *
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request) : Collection
    {
        $q = $request->input('q');
        return User::where('pseudo', 'LIKE', '%' . $q . '%')
            ->orWhere('email', 'LIKE', '%' . $q . '%')
            ->get();
    }
}
