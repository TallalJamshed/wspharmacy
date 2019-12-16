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
    <h2 align="center">Payment Recovery Report</h2>
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
                <th>Customer Name</th>
                <th>Sale Invoice</th>
                <th>Sale Amounts</th>
                <th>Paid Amounts</th>
                <th>Returned Amount</th>
                <th>Remaining Amounts</th>
            </tr>
        </thead>
        <tbody style="background-color:white; ">
            <?php $serial = 0; $grosssale = 0; $grossrecovery = 0; $netsale = 0; $netrecovery = 0; $netreturn = 0; $rec_amnt = 0; ?>
            @foreach ($customers as $customer) 
            <tr>
                    <?php $serial++; ?>
                <td>{{$customer->cust_name}}</td>
                <td>
                    @foreach ($sales as $sale)
                        @if ($sale->fk_cust_id == $customer->cust_id)
                            {{$sale->sale_invoice}}<br>
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ($sales as $sale)
                        @if ($sale->fk_cust_id == $customer->cust_id)
                            {{$sale->total_sale}}<br>
                            <?php $grosssale += $sale->total_sale?>
                        @endif
                    @endforeach
                    <b>Total sale =</b>{{$grosssale}}
                        <?php $netsale += $grosssale;  ?>
                </td>
                <td>
                    @foreach ($ledgers as $ledger)
                        @if ($ledger->fk_cust_id == $customer->cust_id)
                            {{$ledger->paid_amount}} ({{date('d-m-Y' , strtotime($ledger->payment_date))}})<br>
                            <?php $grossrecovery += $ledger->paid_amount?>
                        @endif
                    @endforeach
                    <b>Total Recovery =</b>{{$grossrecovery}}
                    <?php $netrecovery += $grossrecovery;  ?>
                </td>
                <td>
                    @foreach ($recovery as $rec)
                        @if($rec->fk_cust_id == $customer->cust_id)
                        {{-- {{'hello'}} --}}

                        <?php $rec_amnt = $rec->recovered_amount * $rec->unit_price;?>
                        @endif
                    @endforeach
                    {{$rec_amnt}}
                    <?php $netreturn += $rec_amnt;  ?>

                </td>
                <td>
                    {{$grosssale - $grossrecovery - $rec_amnt}}
                </td>
                @php
                    $grosssale = 0;
                    $grossrecovery = 0;
                    $rec_amnt = 0;
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
            {{-- @if($recovery != null) --}}
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
            {{-- @endif --}}
        </tbody>
    </table>

    <table style="width:100%">
        <tr>
            {{-- <th>No of records :</th><td>{{$serial}}</td> --}}
            <th>Net Sale :</th><td>{{$netsale}}</td>
            <th>Net Returns :</th><td>{{$netreturn}}</td>
            <th>Net Recovery :</th><td>{{$netrecovery}}</td>

            @if ($netrecovery < 0)
                <th>Net Remaining</th><td>{{$netsale + $netrecovery + $netreturn}}</td>
            @else
                <th>Net Remaining</th><td>{{$netsale - $netrecovery - $netreturn}}</td>
            @endif
        </tr>
    </table>
</body>
</html>