@if (count($errors))
                
<div class="form-group w-100" style="margin: auto">
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <strong>{{ $error }}</strong><br>
            @endforeach
    </div>
</div> 

@endif