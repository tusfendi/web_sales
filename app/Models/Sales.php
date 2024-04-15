<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'transaction_date',
        'nominal',
    ];

    public static function getReport($startDate, $endDate)
    {
        return DB::select("SELECT u.name, data.* 
        FROM users u 
        LEFT JOIN 
            (SELECT SUM(nominal) as total_nominal, user_id, count(*) as total_transaksi,
                SUM(CASE WHEN type = 'goods' THEN nominal ELSE 0 END) total_nominal_barang,
                SUM(CASE WHEN type = 'goods' THEN 1 ELSE 0 END) total_transaksi_barang,
                count(DISTINCT(transaction_date)) as total_hari
                FROM sales s WHERE s.transaction_date >= '" . $startDate . " 00:00:00' AND s.transaction_date <= '" . $endDate . " 23:59:59' GROUP BY user_id) 
        as data ON data.user_id = u.id;");
    }
}
