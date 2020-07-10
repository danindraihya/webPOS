<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    public $primaryKey = 'kode';

    public $timestamps = false;

    public function transaksi() {
        return $this->belongsToMany('App\Transaksi', 'detail_transaksi', 'menu_kode', 'transaksi_id')
                    ->as('detail_transaksi')
                    ->withPivot('jumlah', 'harga')
                    ->withTimestamps();
    }
}
