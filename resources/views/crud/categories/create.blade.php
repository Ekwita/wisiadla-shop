<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <label for="">Name</label>
    <input type="text" name="name" id="name">

    <button type="submit">Submit</button>
</form>
