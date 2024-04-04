<x-layout>
    <div class="container py-md-5 container--narrow">
        <h2 class="text-center mb-3">Upload Avatar</h2>
        <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
            @csrf 
            <input type="file" name="avatar" required>
            @error('avatar')
            <p class="alert small alert-danger shadow-sm">{{$message}}"></p>
            @enderror
    </div>
    <button class="btn btn-primary">save</button>

</x-layout>