<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body{
            padding-left: 0.3in;
            padding-right: 0.3in;
        }
        table , th , td{
            border:1px solid black;
            border-bottom: 2px solid black;
            border-collapse: collapse;
        }
        th, td{
            text-align: center;
        }
        th{
            text-align: center;
            font-size: 12px
        }
        td{
            text-align: center;
            font-size: 10px
        }
        table{
            border-spacing: 5px;
            margin-top: 20px;
        }
        .header{
            margin-top: 5px;
            margin-bottom: -10px;
            width: 100%;
        }
        .header-div{
            display:inline-block; 
        }
        .header-div-left{
            padding-left:20px
        }
        .header-div-right{
            padding-right:20px;
            float: right;
        }
        .header-label
        {
            font-size:13px; 
            font-weight:bold
        }
        .header-span{
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h2 align="center">Profit Loss Report</h2>
    <div class="header">    
        <div class="header-div header-div-left">
            <label class="header-label">Start Date:</label>
            <span class="header-span">{{$start_date}}</span>
        </div>
        <div class="header-div header-div-right">
            <label class="header-label">End Date:</label>
            <span class="header-span">{{$end_date}}</span>
        </div>
    </div>
       
    <table style="width:100%;">
        <thead>
            <tr>
                <th>Med Name</th>
                <th>Prc Dates</th>
                <th>Prc Prices/unit</th>
                <th>Sale Dates</th>
                <th>Sale Prices/unit</th>
                <th>Sale Qty</th>
                <th>Avg Profit/Loss</th>
            </tr>
        </thead>
        <tbody style="background-color:white; ">
            <?php $serial = 0; $avgpurchase = 0; $finalprc = 0; $avgprccnt = 0; $avgsale = 0; $finalsale = 0; 
                    $avgsalecnt = 0; $saleqty = 0; $netpurchase = 0; $netsale = 0; $netpl = 0;?>
            @foreach ($medicines as $medicine) 
            <tr>
                    <?php //$serial++; ?>
                <td>{{$medicine->med_name}}</td>
                <td>
                    @foreach ($purchases as $purchase)
                        @if ($purchase->fk_med_id == $medicine->med_id)
                            {{date('d-m-Y',strtotime($purchase->purchase_date))}}<br>
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($purchases as $purchase)
                        @if ($purchase->fk_med_id == $medicine->med_id)
                        {{$purchase->subunit_price}}<br>
                        <?php $avgpurchase += $purchase->subunit_price; $avgprccnt++;?>
                        @endif
                    @endforeach
                    <?php if ($avgprccnt==0) {
                        $avgprccnt=1;
                    }?>
                    <b>Avg purchase =</b>{{$finalprc = round($avgpurchase/$avgprccnt , 2)}}
                    <?php $avgpurchase = 0; $avgprccnt = 0;?>
                </td>
                <td>
                    @foreach ($sales as $sale)
                        @if ($sale->fk_med_id == $medicine->med_id)
                            {{date('d-m-Y',strtotime($sale->sale_date))}}<br>
                        @endif
                    @endforeach
                    {{-- <b>Total sale =<b>{{$grosssale}} --}}
                </td>
                <td>
                    @foreach ($sales as $sale)
                        @if ($sale->fk_med_id == $medicine->med_id)
                            {{$price = $sale->price / $sale->quantity_sold}}<br>
                            <?php $avgsale += $price; $avgsalecnt++;?>
                        @endif
                    @endforeach
                    <?php if ($avgsalecnt==0) {
                        $avgsalecnt=1;
                    }?>
                    <b>Avg sale =<b>{{$finalsale = round($avgsale/$avgsalecnt, 2)}}
                    <?php $avgsale = 0; $avgsalecnt = 0;?>
                </td>
                <td>
                    @foreach ($sales as $sale)
                        @if ($sale->fk_med_id == $medicine->med_id)
                            {{$sale->quantity_sold}}<br>
                            <?php $saleqty += $sale->quantity_sold;?>
                        @endif
                    @endforeach
                    @foreach ($recovery as $rec)
                        @if ($rec->fk_med_id == $medicine->med_id)
                            {{-$rec->recovered_amount}}<br>
                            <?php $saleqty -= $rec->recovered_amount;?>
                        @endif
                    @endforeach
                    
                    <b>Total Qty =</b>{{$saleqty}}
                </td>
                <td>
                    <?php $netpurchase += $finalprc*$saleqty;
                            $netsale += $finalsale*$saleqty;
                    ?>
                    {{($finalsale*$saleqty) - ($finalprc*$saleqty)}}
                </td>
                @php
                    $saleqty = 0; $finalsale=0; $finalprc=0; 
                @endphp
            </tr>
            @endforeach
        </tbody>
    </table>

   
    <h3 align="center">Sale Return Medicines</h3>

    <table style="width:100%; ">
        <thead>
            <tr>
                <th>Invoice No</th>
                <th>Medicine Name</th>
                <th>Returned Quantity</th>
                <th>Return Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody style="background-color:white; ">
            <?php $serial = 0; $grosssale = 0; $grosscourier = 0; ?>
            @foreach ($recovery as $rec)
            <tr>
                <?php $serial++; ?>
                <td>{{$rec->sale_invoice}}</td>
                <td>{{$rec->med_name}}</td>
                <td>{{$rec->recovered_amount}}</td>
                <?php $rec_amnt = $rec->recovered_amount * $rec->unit_price;
                ?>
                <td>{{$rec_amnt}}</td>
                <td>{{date('d-m-Y' , strtotime($rec->recovery_date))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width:100%">
        <thead>
            <tr>
                <th>Net Purchase:</th>
                <th>Net Sale:</th>
                <th>Net Profit/Loss:</th>
                <th>Net Courier(sales):</th>
                <th>Paid Courier(sales):</th>
                <th>Net Courier(purchase):</th>
                <th>Paid Courier(purchase):</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$netpurchase}}</td>
                <td>{{$netsale}}</td>
                <td>{{$netsale - $netpurchase}}</td>
                @php
                    $sumsalecourier = 0;$sumprccourier=0;$psc = 0;$ppc=0;
                @endphp
                @foreach ($sale_couriers as $courier)
                    <?php $sumsalecourier += $courier->courier_service ?>
                @endforeach
                @foreach ($purchase_couriers as $courier)
                    <?php $sumprccourier += $courier->purchase_courier ?>
                @endforeach
                @foreach ($paidsalecourier as $courier)
                    <?php $psc += $courier->courier_paid ?>
                @endforeach
                @foreach ($paidprccourier as $courier)
                    <?php $ppc += $courier->vcourier_paid ?>
                @endforeach
                <td>{{$sumsalecourier}}</td>
                <td>{{$psc}}</td>
                <td>{{$sumprccourier}}</td>
                <td>{{$ppc}}</td>
            </tr>
        </tbody>
    </table>

    {{-- <table style="width:100%">
        <tr>
            <th>Net Purchase:</th><td>{{$netpurchase}}</td>
            <th>Net Sale:</th><td>{{$netsale}}</td>
            <th>Net Profit/Loss:</th><td>{{$netsale - $netpurchase}}</td>
            @php
                $sum = 0;$sumprccourier=0;
            @endphp
            @foreach ($couriers as $courier)
            @endforeach
            @foreach ($purchase_couriers as $courier)
            @endforeach
            <th>Net Courier Service(sales):</th><td>{{$sum}}</td>
            <th>Net Courier Service(purchase):</th><td>{{$sumprccourier}}</td>
        </tr>
    </table> --}}

    
</body>
</html>