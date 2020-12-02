@extends ('layouts.layout')

@section('content')

    <script>
        $(document).ready(function() {
            $("#tableSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#Table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

    </script>

    @if ($flash = session('success'))
        <div id="flash-message" class="alert alert-success" role="alert">
            {{ $flash }}
        </div>
    @endif

    @if ($flash = session('nochange'))
        <div id="flash-message" class="alert alert-warning" role="alert">
            {{ $flash - message }}
        </div>
    @endif

    <div class="col-sm-8">

        <h1>Edit Menu</h1>

        <form method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" class="form-control" id="name" name="name" value="" required>
            </div>

            <div class="form-group">
                <label for="Section">Section</label>
                <select id="section" name="section">
                    @foreach ($sections as $sec)
                        <option value="{{ $sec->section_ID }}">{{ $sec->name }} </option>
                    @endforeach
                </select>
                <hr>
                <label for="Price">Price</label>
                <input type="text" class="form-control" id="price" name="price" aria-describedby="price"
                    value="" required>
            </div>
            <button type="submit" class="btn btn-primary">Create New</button>
        </form>

        <hr>
        <!-- Search form -->
        <div class="container">
            <input class="form-control mb-4" id="tableSearch" type="text" placeholder="Type something to search list items">

            <table id="Table" class="table">
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Section</th>
                    <th>Options</th>
                </tr>
                @foreach ($menu_item as $item)
                    <tr {{ $flash == $item->menu_ID ? 'class=bg-success' : "$flash" }}>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $sections[$item->section_ID - 1]->name }}</td>
                        <td><a href="editMenuItem/{{ $item->menu_ID }}" style="padding-right:10px">Edit</a>
                            <a href="deleteMenuItem/{{ $item->menu_ID }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
