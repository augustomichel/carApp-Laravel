@if($errors->any())
<br>
<div class="container">
    <div class="col-md-12">
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif