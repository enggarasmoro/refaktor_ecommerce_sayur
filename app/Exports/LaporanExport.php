<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class LaporanExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        $dates = explode(" - ",$this->date);
        $datefrom = $dates[0]." 00:00:00";
        $dateto =$dates[1]. " 23:59:59";
        // DB::enableQueryLog();
        $laporan = DB::table('order_detail')
                ->join('order', 'order_detail.id_order', '=', 'order.id')
                ->join('produk', 'order_detail.id_produk', '=', 'produk.id')
                ->select(
                    DB::raw('sum(order_detail.qty) as qty, produk.nama')
                )
                ->whereBetween('order.created_at', [$datefrom, $dateto])
                ->where("order.status",1)                
                ->groupBy('order_detail.id_produk')->orderBy('produk.nama','ASC')->get()->toArray();
        // $query = DB::getQueryLog();

        // dd($query);
        $data = array();
        foreach ($laporan as $value) {
            $data[] = array(
                "Nama Produk"  => $value->nama,
                "Qty" =>  $value->qty,
            );
        }
        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Nama Produk','Qty'
        ];
    }
}
