<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <div class="mt-1 text-right">
                    {{__("Bulk action")}}:
                </div>
            </div>
            <div class="col-md-4">
                <select name="bulk" id="bulk" class="form-control">
                    @if (isset($actions))
                        @foreach($actions as $k => $action)
                            <option value="{{$k}}"> {{$action}} </option>
                        @endforeach
                    @endif
                    <option value="delete"> {{__("Delete")}} </option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="submit" class="btn btn-secondary btn-block" value="{{__("Do")}}"/>
            </div>
        </div>
    </div>
</div>
