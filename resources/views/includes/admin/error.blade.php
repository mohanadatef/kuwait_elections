<!-- errors -->
@if(count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session()->has('message'))
    <div class="alert alert-success" align="center">
        {{ session()->get('message') }}
    </div>
    @elseif(session()->has('message_fales'))
    <div class="alert alert-danger" align="center">
        {{ session()->get('message_fales') }}
    </div>
@endif
@yield('error')