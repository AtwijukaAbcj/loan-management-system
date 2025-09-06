@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Pesapal API Settings</h2>
    <form method="POST" action="{{ route('settings.pesapal.save') }}">
        @csrf
        <div class="mb-3">
            <label for="consumer_key" class="form-label">Consumer Key</label>
            <input type="text" class="form-control" id="consumer_key" name="consumer_key" value="{{ old('consumer_key', $consumer_key ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label for="consumer_secret" class="form-label">Consumer Secret</label>
            <input type="text" class="form-control" id="consumer_secret" name="consumer_secret" value="{{ old('consumer_secret', $consumer_secret ?? '') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
