<?php

function product_list($list)
{
    $data =  unserialize($list);
    $products = \DB::select('select * 
    from carts as c
    JOIN products as p ON c.product_id=p.id
    WHERE c.id IN ('.implode(',', $data).')');

    return $products;
}

function hitung_penjualan($from_date, $to_date)
{
    $data = \DB::select("select sum(total) as total from orders where created_at >= '$from_date' and created_at <= '$to_date'");

    if(empty($data[0]->total))
    {
        $total = 0;
    }else{
        $total = $data[0]->total;
    }

    return $total;
}

?>