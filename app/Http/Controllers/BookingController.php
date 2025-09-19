<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Costume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'costume']);

        // If user is not admin, only show their bookings
        if (!Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create(Costume $costume)
    {
        return view('bookings.create', compact('costume'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $request->validate([
            'costume_id' => 'required|exists:costumes,id',
            'rental_start_date' => 'required|date|after_or_equal:today',
            'rental_end_date' => 'required|date|after:rental_start_date',
            'notes' => 'nullable|string|max:500',
        ]);

        $costume = Costume::findOrFail($request->costume_id);

        // Check if costume is available
        if (!$costume->isAvailable()) {
            return back()->withErrors(['costume' => 'ชุดนี้ไม่พร้อมให้เช่าในขณะนี้']);
        }

        // Calculate total days and amount
        $startDate = \Carbon\Carbon::parse($request->rental_start_date);
        $endDate = \Carbon\Carbon::parse($request->rental_end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $totalDays * $costume->price_per_day;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'costume_id' => $request->costume_id,
            'rental_start_date' => $request->rental_start_date,
            'rental_end_date' => $request->rental_end_date,
            'total_days' => $totalDays,
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'การจองถูกสร้างเรียบร้อยแล้ว กรุณาอัพโหลดสลิปการโอนเงิน');
    }

    /**
     * Display the specified booking
     */
    public function show(Booking $booking)
    {
        // Check if user can view this booking
        if (!Auth::user()->isAdmin() && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['user', 'costume']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking
     */
    public function edit(Booking $booking)
    {
        // Only allow editing if booking is pending
        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'ไม่สามารถแก้ไขการจองที่ยืนยันแล้วได้']);
        }

        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified booking
     */
    public function update(Request $request, Booking $booking)
    {
        // Only allow updating if booking is pending
        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'ไม่สามารถแก้ไขการจองที่ยืนยันแล้วได้']);
        }

        $request->validate([
            'rental_start_date' => 'required|date|after_or_equal:today',
            'rental_end_date' => 'required|date|after:rental_start_date',
            'notes' => 'nullable|string|max:500',
        ]);

        // Calculate total days and amount
        $startDate = \Carbon\Carbon::parse($request->rental_start_date);
        $endDate = \Carbon\Carbon::parse($request->rental_end_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $totalDays * $booking->costume->price_per_day;

        $booking->update([
            'rental_start_date' => $request->rental_start_date,
            'rental_end_date' => $request->rental_end_date,
            'total_days' => $totalDays,
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
        ]);

        return redirect()->route('bookings.show', $booking)->with('success', 'การจองถูกอัพเดทเรียบร้อยแล้ว');
    }

    /**
     * Upload payment slip
     */
    public function uploadPaymentSlip(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_slip' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Delete old payment slip if exists
        if ($booking->payment_slip) {
            Storage::disk('public')->delete($booking->payment_slip);
        }

        $imagePath = $request->file('payment_slip')->store('payment-slips', 'public');

        $booking->update([
            'payment_slip' => $imagePath,
            'payment_status' => 'pending',
        ]);

        return back()->with('success', 'สลิปการโอนเงินถูกอัพโหลดเรียบร้อยแล้ว');
    }

    /**
     * Confirm booking (Admin only)
     */
    public function confirm(Booking $booking)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'verified',
            'payment_verified_at' => now(),
        ]);

        // Update costume status
        $booking->costume->update(['status' => 'rented']);

        return back()->with('success', 'การจองถูกยืนยันเรียบร้อยแล้ว');
    }

    /**
     * Reject booking (Admin only)
     */
    public function reject(Booking $booking)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $booking->update([
            'status' => 'cancelled',
            'payment_status' => 'rejected',
        ]);

        return back()->with('success', 'การจองถูกปฏิเสธแล้ว');
    }

    /**
     * Complete booking (Admin only)
     */
    public function complete(Booking $booking)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $booking->update(['status' => 'completed']);

        // Update costume status back to available
        $booking->costume->update(['status' => 'available']);

        return back()->with('success', 'การจองเสร็จสิ้นแล้ว');
    }

    /**
     * Cancel booking
     */
    public function cancel(Booking $booking)
    {
        // Only allow cancellation if booking is pending
        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'ไม่สามารถยกเลิกการจองที่ยืนยันแล้วได้']);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.index')->with('success', 'การจองถูกยกเลิกแล้ว');
    }
}
