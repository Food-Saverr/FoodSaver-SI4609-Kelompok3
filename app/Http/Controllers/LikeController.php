<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artikel;

class LikeController extends Controller
{
    public function toggle(Artikel $artikel)
    {
        $user = Auth::user();

        if ($artikel->isLikedBy($user)) {
            $user->likedArtikels()->detach($artikel->id);
        } else {
            $user->likedArtikels()->attach($artikel->id);
        }

        return back();
    }
}
