<?php

namespace App\Models\Finance;

use App\Models\HR\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
