<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Rating;
use App\Models\Section;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function add(Request $request)
    {
        $stars_rated = $request->input('section_rating');
        $section_id = $request->input('section_id');
        $section_check = Section::where('id', $section_id)->where('status', '0')->first();

        if ($section_check) {

            $existing = Rating::where('user_id', Auth::id())->where('section_id', $section_id)->first();
            if ($existing) {
                $existing->stars_rated = $stars_rated;
                $existing->update();
            } else {
                Rating::create([
                    'user_id' => Auth::id(),
                    'section_id' => $section_id,
                    'stars_rated' => $stars_rated
                ]);
            }
            return redirect()->back()->with('status', 'Producto valorado correctamente');

        } else {
            return redirect()->back()->with('status', 'Se ha producido un error puntuando este elemento');
        }
    }
}