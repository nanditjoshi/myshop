<div class="search-container">
            <div id="sbar" class="container search-bar wid mobile-menu">
                <div class="container nv-pd ">
                    <form method="POST" action="{{ action('PropertyController@searchProperties') }}">
                        <div class="form-row">
                            <div class="col-sm-3 sm-bt-mr pdl "> <i class="form-control-feedback desti-icn"></i>
                                <input type="text" autocomplete="off" class="form-control destinationtext" placeholder="Destination" name="destination" onkeyup="getDestinationList(this.value)" value="{!! Session::get('destination') !!}" required="required"/>
                                <div class="destinations" style="display: none; background: #ffffff;">
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-7 mr-pd ">
                                <div class="col-sm-3 col-md-3 sm-bt-mr ">
                                    <div class="form-group">
                                        <div class='input-group date' id='datetimepicker'>
                                            <input type='text' class="form-control datepickerinput" placeholder="Date" readonly="true" name="date" value="{!! \Carbon\Carbon::parse(Session::get('date'))->format('d-m-Y') !!}">
                                            <span class="input-group-addon"> <i class="form-control-feedback dat"></i> </span></div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 sm-bt-mr ">
                                    <div class="selectdiv ">
                                        <label>
                                        <select class="dat" name="night">
                                        @php $nt = Session::get('night') @endphp
                                        @for ($i = 1; $i < 31; $i++)
                                            <option @if($nt == $i) selected @endif value="{{$i}}"> {{$i}} Nights</option>
                                        @endfor
                                        </select>    
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 sm-bt-mr ">
                                    <div class="input-group incr-box ">
                                        <label class="hdng">Adult: </label>
                                        <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[1]"> <span class="glyphicon glyphicon-minus"></span> </button>
                                            </span>
                                            <input type="text" name="quant[1]" class="form-control input-number nubrs" value="{{ Session::get('adult')?Session::get('adult'):1 }}" min="1" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[1]"> <span class="glyphicon glyphicon-plus"></span> </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-3 sm-bt-mr ">
                                    <div class="input-group incr-box ">
                                        <label class="hdng">Child: </label>
                                        <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[2]"> <span class="glyphicon glyphicon-minus"></span> </button>
                                            </span>
                                            <input type="text" name="quant[2]" class="form-control input-number nubrs" value="{{ Session::get('children')?Session::get('children'):0 }}" min="0" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[2]"> <span class="glyphicon glyphicon-plus"></span> </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div clas="col-sm-2 col-md-2 mr-pd">
                                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                                <!-- <button onclick="window.location.href = '#';" type="button" class="btn btn-primary btn-lg ">Search</button> -->
                                <button type="submit" class="btn btn-primary btn-lg search-property-button">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

