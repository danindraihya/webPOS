<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    public $primaryKey = 'id';

    public $timestamps = true;

    public function menu(){
        return $this->belongsToMany('App\Menu', 'detail_transaksi', 'transaksi_id', 'menu_kode')
                    ->as('detail_transaksi')
                    ->withPivot('jumlah', 'harga')
                    ->withTimestamps();
    }

    public function users(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
