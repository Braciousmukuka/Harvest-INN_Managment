<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Incubation extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_number',
        'batch_name',
        'egg_type',
        'breed',
        'eggs_placed',
        'eggs_candled',
        'eggs_fertile',
        'eggs_hatched',
        'chicks_healthy',
        'start_date',
        'expected_hatch_date',
        'actual_hatch_date',
        'incubation_days',
        'temperature_celsius',
        'humidity_percent',
        'status',
        'notes',
        'daily_logs'
    ];

    protected $casts = [
        'start_date' => 'date',
        'expected_hatch_date' => 'date',
        'actual_hatch_date' => 'date',
        'temperature_celsius' => 'decimal:1',
        'humidity_percent' => 'decimal:2',
        'daily_logs' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($incubation) {
            if (empty($incubation->batch_number)) {
                $incubation->batch_number = self::generateBatchNumber();
            }
            
            // Calculate expected hatch date based on egg type
            if ($incubation->start_date && empty($incubation->expected_hatch_date)) {
                $incubation->expected_hatch_date = $incubation->calculateExpectedHatchDate();
            }
        });
    }

    public static function generateBatchNumber()
    {
        $year = date('Y');
        $lastBatch = self::where('batch_number', 'like', "INC-{$year}-%")->orderBy('id', 'desc')->first();
        
        if ($lastBatch) {
            $lastNumber = intval(substr($lastBatch->batch_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "INC-{$year}-{$newNumber}";
    }

    public function calculateExpectedHatchDate()
    {
        $incubationPeriods = [
            'chicken' => 21,
            'duck' => 28,
            'goose' => 30,
            'turkey' => 28,
            'guinea_fowl' => 28,
            'quail' => 18
        ];

        $days = $incubationPeriods[$this->egg_type] ?? 21;
        $this->incubation_days = $days;
        
        return Carbon::parse($this->start_date)->addDays($days);
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->status === 'completed' || $this->status === 'failed') {
            return 0;
        }
        
        $today = Carbon::today();
        $expectedDate = Carbon::parse($this->expected_hatch_date);
        
        return max(0, $today->diffInDays($expectedDate, false));
    }

    public function getHatchRateAttribute()
    {
        return $this->eggs_placed > 0 ? round(($this->eggs_hatched / $this->eggs_placed) * 100, 1) : 0;
    }

    public function getFertilityRateAttribute()
    {
        return $this->eggs_candled > 0 ? round(($this->eggs_fertile / $this->eggs_candled) * 100, 1) : 0;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->status === 'completed') return 100;
        if ($this->status === 'failed' || $this->status === 'cancelled') return 0;
        
        $today = Carbon::today();
        $startDate = Carbon::parse($this->start_date);
        $expectedDate = Carbon::parse($this->expected_hatch_date);
        
        $totalDays = $startDate->diffInDays($expectedDate);
        $daysPassed = $startDate->diffInDays($today);
        
        return min(100, max(0, round(($daysPassed / $totalDays) * 100, 1)));
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'hatching']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
