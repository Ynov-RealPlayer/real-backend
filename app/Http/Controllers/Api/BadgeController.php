<?php

namespace App\Http\Controllers\Api;

use App\Models\BadgeUser;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(BadgeUser $badgeUser)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BadgeUser $badgeUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BadgeUser $badgeUser)
    {
        //
    }
}
