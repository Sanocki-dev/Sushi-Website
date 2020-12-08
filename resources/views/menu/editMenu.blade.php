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

    <div class="w-75 p-5 text-white" style="margin: auto; background-color:rgba(43, 43, 43, 0.7)">

        <h3 class="display-2 text-white">Edit Menu</h3>
        <hr style="height: 2px; background-color:orange">

        <form method="post" class="p-5">
            {{ csrf_field() }}
            <h3 style="font-weight: lighter">Create Menu Item</h3>
            <div class="form-group ">
                <label for="name">Item Name</label>
                <input type="text" class="form-control" id="name" name="name" value="" required>
            </div>

            <div class="form-group">
                <label for="Section">Section</label>
                <select id="section" name="section">
                    @foreach ($sections as $sec)
                        <option value="{{ $sec->section_id }}">{{ $sec->name }} </option>
                    @endforeach
                </select>
                <label for="Price">Price</label>
                <input type="text" class="form-control" id="price" name="price" aria-describedby="price" value="" required>
            </div>
            <button type="submit" class="btn" style=" background-color:orange; color:white">Create New</button>
        </form>

        <hr style="height: 2px; background-color:orange">
        <!-- Search form -->
        <div class="w-75 p-5" style="margin: auto">
            <h3 style="font-weight: lighter">Edit Existing Menu Item</h3>
            <input class="form-control mb-4" id="tableSearch" type="text" placeholder="Type something to search list items">

            <table id="Table" class="table">
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Section</th>
                    <th>Options</th>
                </tr>
                @foreach ($menu_item as $item)
                    <tr {{ $flash == $item->menu_id ? 'class=bg-success' : "$flash" }}>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $sections[$item->section_id - 1]->name }}</td>
                        <td><a href="editMenuItem/{{ $item->menu_id }}" style="padding-right:10px; color:orange">Edit</a>
                            <a href="deleteMenuItem/{{ $item->menu_id }}" style="color:orange">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
