<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costume extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price_per_day',
        'size',
        'color',
        'category',
        'image',
        'status',
        'available_from',
        'available_to',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_per_day' => 'decimal:2',
        'available_from' => 'date',
        'available_to' => 'date',
    ];

    /**
     * Get the bookings for the costume.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if costume is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * Get available costumes
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Get costumes by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
