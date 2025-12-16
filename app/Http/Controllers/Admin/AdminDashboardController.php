<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking; 
use App\Models\Category; 
use App\Models\Album; 
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        
        $totalCategories = Category::count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalAlbums = Album::count(); 

        return view('admin.dashboard', compact('totalCategories', 'totalBookings', 'pendingBookings', 'totalAlbums'));
    }
}
