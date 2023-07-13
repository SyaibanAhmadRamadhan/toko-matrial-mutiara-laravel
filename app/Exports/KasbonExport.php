<?php

namespace App\Exports;

use App\Models\Kasbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;

class KasbonExport implements FromView, WithColumnWidths
{
    private $dari;
    private $sampai;

    public function __construct(string $dari, string $sampai)
    {
        $this->sampai = $sampai;
        $this->dari = $dari;
    }

    public function view(): View
    {
        if ($this->dari != "" && $this->sampai != "") {
            $all = Kasbon::where("tanggal_kasbon", ">=", $this->dari)->where("tanggal_kasbon", "<=", $this->sampai)->get();
            $total = 0;
            foreach ($all as $key => $x) {
                $total += $x->uang_kasbon;
            }
            return view('after-revisi.export.kasbon', [
                'kasbon' =>  Kasbon::where("tanggal_kasbon", ">=", $this->dari)->where("tanggal_kasbon", "<=", $this->sampai)->orderBy('tanggal_kasbon', 'ASC')->get(),
                'title' => 'kasbon',
                'total' => $total
            ]);
        } else {
            $all = Kasbon::get();
            $total = 0;
            foreach ($all as $key => $x) {
                $total += $x->uang_kasbon;
            }
            // dd($total);
            return view('after-revisi.export.kasbon', [
                'kasbon' =>  Kasbon::orderBy("tanggal_kasbon", 'asc')->get(),
                'title' => 'kasbon',
                'total' => $total
            ]);
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 16,
            'B' => 16,
            'B' => 28,
            'C' => 30,
            'D' => 28,
        ];
    }
}