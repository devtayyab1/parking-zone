<style>
    .mt-2 {
        margin-top: 10px;
    }
</style>
@foreach($products as $product)
@php

        $brand_price="";
        $brand_price = (array) DB::table('companies_product_prices')->where("cid","=",$id)->where("brand_name","=",$product["product_name"])->first();
@endphp
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                   href="#collapseOne_{{ $product["id"] }}">
                    {{ $product["product_name"] }}
                </a>
            </h4>
        </div>

        @if($brand_price)


        <div id="collapseOne_{{ $product["id"] }}" class="panel-collapse collapse out">
            <div id="message_product_{{ $product["id"] }}"></div>
            <form method="post"   onsubmit="return false"  id="product_{{ $product["id"] }}">

                @csrf
                <div class="panel-body">
                    <input type="hidden" name="product_id" value="{{  $product["id"] }}"/>
                    <input type="hidden" name="company_id" value="{{  $id }}"/>
                    <input type="hidden" name="product_name" value="{{  $product["product_name"] }}"/>
                    <input type="hidden" name="action" id="action_sub"  value="update"/>
                    @for ($i = 1; $i <= 31; $i++)


                        <div class="col-md-1 mt-2">
                            <label for="p_day_{{ $i }}" class=" control-label"> Day {{ $i }}</label>
                        </div>
                        <div class="col-md-1 mt-2">
                            <input style="color:green;" type="text" class="form-control" id="p_day_{{ $i }}" name="p_day_{{ $i }}" value="{{ $brand_price["day_".$i] }}" />

                        </div>

                    @endfor
                    <hr/>
                    <div style="clear: both"></div>
                    <div class="row">
                        <div class="col-md-3 mt-2 text-right">
                            <label for="over_31_days " class=" control-label">Over 31 Days</label>
                        </div>
                        <div class="col-md-4 mt-2">
                            <input style="color:green;" type="text" class="form-control" id="after_30_days"
                                   name="after_30_days" value="{{ $brand_price["after_30_days"]  }}">
                        </div>
                    </div>


                    <div class="row">

                        <button onclick="updateProductPrices('product_{{  $product["id"]   }}')" class="btn btn-success pull-right" style="margin-right: 2%;">Update</button>
                    </div>

                </div>
            </form>
        </div>
            @else


            <div id="collapseOne_{{ $product["id"] }}" class="panel-collapse collapse out">
                <div id="message_product_{{ $product["id"] }}"></div>

                <form method="post"  onsubmit="return false" action="" id="product_{{ $product["id"] }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{  $product["id"] }}"/>
                    <input type="hidden" name="company_id" value="{{  $id }}"/>
                    <input type="hidden" name="product_name" value="{{  $product["product_name"] }}"/>
                    <input type="hidden" name="action" id="action_sub"  value="add"/>
                    <div class="panel-body">
                        @for ($i = 1; $i <= 31; $i++)


                            <div class="col-md-1 mt-2">
                                <label for="p_day_{{ $i }}" class="font-weight-bold control-label"> Day {{ $i }}</label>
                            </div>
                            <div class="col-md-1 mt-2">
                                <input style="color:green;" type="text" class="form-control" id="p_day_{{ $i }}"
                                       name="p_day_{{ $i }}" value="0.00">
                            </div>
                        @endfor
                        <hr/>
                        <div style="clear: both"></div>
                        <div class="row">
                            <div class="col-md-3 mt-2 text-right">
                                <label for="over_31_days " class="font-weight-bold control-label">Over 31 Days</label>
                            </div>
                            <div class="col-md-4 mt-2">
                                <input style="color:green;" type="text" class="form-control" id="over_31_days"
                                       name="over_31_days" value="0.00">
                            </div>
                        </div>


                        <div class="row">

                            <button onclick="updateProductPrices('product_{{  $product["id"]   }}')" class="btn btn-success pull-right" style="margin-right: 2%;">Update</button>
                        </div>

                    </div>
                </form>
            </div>

            @endif
    </div>

@endforeach

