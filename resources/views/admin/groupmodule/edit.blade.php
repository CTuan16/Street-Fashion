@extends('admin.layoutv2.layout.app')

@section('content')
<div id="wrapper" style="min-height: 1405px;">
    <div class="content">
        <div class="row">
                        <div  class="col-md-8 col-md-offset-2" id="small-table">
                        @php
                            $action = (isset($groupmodule->id) && $groupmodule->id) ? route('groupmodule.update',$groupmodule->id) : route('groupmodule.store');
                        @endphp
                            <form action="{{$action}}" method="POST" novalidate="novalidate" autocomplete="off" onSubmit="handleSubmit(event,this)">
                                @csrf
                                @if (isset($groupmodule->id) && $groupmodule->id)
                                    @method('PUT')
                                @endif
                                <div class="card card-info">
                                    <div class="card-body">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="group_module_name">Group module name</label>
                                                <input type="text" id="group_module_name" name="group_module_name" class="form-control @error('group_module_name') is-invalid @enderror" placeholder="Group module name" value="{{ $groupmodule->group_module_name }}" >
                                                @error('group_module_name')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer" style="text-align: center">
                                        <a href="{{route('groupmodule.index') }}" type="button" class="btn btn-default">Cancel</a>
                                        <button type="submit" class="btn btn-info">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
    </div>
</div>
@endsection