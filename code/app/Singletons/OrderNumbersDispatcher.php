<?php

namespace App\Singletons;

use DB;

use App\Order;

/*
    Questo serve a generare i numeri identificativi degli ordini.
    Essi non sono salvati permanentemente nel database onde evitare di dover
    ricalcolare tutto quando un ordine viene cancellato o le date sono
    modificate, ma sono dinamicamente generati in virtù di quanti ordini
    precedenti ci sono stati
*/
class OrderNumbersDispatcher
{
    private $cache = [];

    public function getNumber($order)
    {
        $year = date('Y', strtotime($order->start));

        if (array_key_exists($year, $this->cache) == false) {
            $this->cache[$year] = Order::where(DB::raw('YEAR(start)'), $year)->orderBy('start', 'asc')->orderBy('id', 'asc')->get();
        }

        $counter = 0;

        foreach($this->cache[$year] as $cached_order) {
            if ($cached_order->start < $order->start) {
                $counter++;
                continue;
            }
            else if ($cached_order->start == $order->start) {
                if ($cached_order->id < $order->id) {
                    $counter++;
                    continue;
                }
            }

            break;
        }

        return sprintf('%d / %d', $counter + 1, $year);
    }
}
