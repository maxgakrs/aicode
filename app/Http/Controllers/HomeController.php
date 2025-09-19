<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the home page
     */
    public function index()
    {
        $featuredCostumes = Costume::available()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $categories = Costume::select('category')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return view('home', compact('featuredCostumes', 'categories'));
    }

    /**
     * Show the dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin dashboard
            $totalCostumes = Costume::count();
            $availableCostumes = Costume::available()->count();
            $totalBookings = Booking::count();
            $pendingBookings = Booking::pending()->count();
            $recentBookings = Booking::with(['user', 'costume'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return view('admin.dashboard', compact(
                'totalCostumes',
                'availableCostumes',
                'totalBookings',
                'pendingBookings',
                'recentBookings'
            ));
        } else {
            // Customer dashboard
            $userBookings = Booking::with('costume')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            $totalBookings = Booking::where('user_id', $user->id)->count();
            $pendingBookings = Booking::where('user_id', $user->id)
                ->where('status', 'pending')
                ->count();

            return view('customer.dashboard', compact(
                'userBookings',
                'totalBookings',
                'pendingBookings'
            ));
        }
    }
}
