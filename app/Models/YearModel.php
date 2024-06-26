<?php

namespace App\Models;

use CodeIgniter\Model;

class YearModel extends Model
{
    protected $table = 'years';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tahun'];
}
