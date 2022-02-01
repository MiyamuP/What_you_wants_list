<!-- resources/views/common/error.blade.php -->
@if (count($errors) > 0)
    <!-- Form Error List -->
    <div class="alert alert-danger">
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif