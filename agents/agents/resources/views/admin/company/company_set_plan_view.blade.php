<style>
    .mt-2 {
        margin-top: 10px;
    }
</style>


<div class="panel panel-default">


    @if($is_exist)

        @php
            //dd($is_exist); die();
              //$is_exist = (array) $is_exist;
              //dd($is_exist); die();
              $days = App\companies_set_price_plan::find($is_exist->id)->Days;

        @endphp
        <div id="message_product_1"></div>
        <form method="post" onsubmit="return false" id="product_1">

            @csrf
            <input type="hidden" name="month" value="{{ $month }}"/>
            <input type="hidden" name="year" value="{{ $year }}"/>
            <input type="hidden" name="id" value="{{ $id }}"/>
            <input type="hidden" name="plain_id" value="{{ $is_exist->id }}"/>
            <input type="hidden" name="action" value="update"/>
            <div class="panel-body">

                <input type="hidden" name="action" value="update"/>
                @for ($i = 1; $i <= 31; $i++)


                    <div class="col-md-1 mt-2">
                        <label for="p_day_{{ $i }}" class=" control-label"> Day {{ $i }}</label>
                    </div>
                    <div class="col-md-2 mt-2">
                        @php
                        $d = "";
                        if(count($days)>0){
                            $d  = $days[$i-1]->brand_name;
                        }
                        @endphp
                        {{ Form::select('p_day_'.$i,$products,$d,["required"=>"required","class"=>"form-control"]) }}


                    </div>

                @endfor


                <div class="row" style="clear: both">

                    <button onclick="updateProductPrices('product_1')" class="btn btn-success pull-right"
                            style="margin-right: 2%;">Update
                    </button>
                </div>

            </div>
        </form>
        <script>$("#extra").val("{{ $is_exist->extra }}");</script>
    @else


        <div id="message_product_1"></div>

        <form method="post" onsubmit="return false" action="" id="product_1">
            @csrf
            <input type="hidden" name="month" value="{{ $month }}"/>
            <input type="hidden" name="year" value="{{ $year }}"/>
            <input type="hidden" name="id" value="{{ $id }}"/>
            <input type="hidden" name="action" value="add"/>

            <div class="panel-body">
                @for ($i = 1; $i <= 31; $i++)


                    <div class="col-md-1 mt-2">
                        <label for="p_day_{{ $i }}" class="font-weight-bold control-label"> Day {{ $i }}</label>
                    </div>
                    <div class="col-md-2 mt-2">
                        {{ Form::select('p_day_'.$i,$products,"",["required"=>"required","class"=>"form-control"]) }}
                    </div>
                @endfor


                <div class="row" style="clear: both">

                    <button onclick="updateProductPrices('product_1')" class="btn btn-success pull-right"
                            style="margin-right: 2%;">Add
                    </button>
                </div>

            </div>
        </form>
</div>
<script>$("#extra").val("");</script>

@endif



