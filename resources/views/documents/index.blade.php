@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Document Library</h2>

            <div class="mb-4">
                <h4>Upload Document</h4>
                <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Document Name:</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="photo">Document File: Click here first</label>
                        <input type="file" name="photo" id="photo" class="form-control-file" onchange="previewImage(event)">
                        <img id="preview" src="#" alt="Preview" style="display: none; width: 200px; height: auto; margin-top: 10px;">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Upload">
                </form>
            </div>

            <h4>Documents</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Upload Date</th>
                        <th>Preview</th>
                        <th>Actions</th> <!-- Add the Actions column -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr>
                            <td>{{ $document->name }}</td>
                            <td>{{ $document->upload_date }}</td>
                            <td><img src="{{ $document->photo_url }}" alt="Preview" style="width: 100px; height: auto;"></td>
                            <td>
                                <form action="{{ route('documents.destroy', $document->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this document?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
