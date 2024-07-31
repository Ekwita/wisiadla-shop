<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <label for="name">Name</label>
    <input type="text" name="name" value="{{$category->name}}">
    <button type="submit">Submit</button>
</form>
