@extends ('layouts.layout')

@section ('content')

<div class="accordion mb-5" id="accordion">
    <div style="color: white; margin:auto;" class="w-75 p-5">
        <h1 class="text-center display-2">Our Menu</h1>
        <hr style="height: 2px; background-color:orange">
        @foreach ($sections as $section)
            <div>
                <div class="card-header w-100" id="heading{{ $section->section_id }}">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapse{{ $section->section_id }}" aria-expanded="false"
                            aria-controls="collapse{{ $section->section_id }}" data-parent="#accordion"
                            style="font-size: 20pt; font-weight: bold; color: orange"
                            onclick="myFunction({{ $section->section_id }})">
                            {{ $section->name }}
                        </button>
                    </h2>
                </div>
            </div>
            <div id="collapse{{ $section->section_id }}" class="collapse w-100" 
                aria-labelledby="heading{{ $section->section_id }}" data-parent="#accordion">
                <div class="card-body pl-2 ml-50" style="background-color:rgba(68, 68, 68, 0.63)">
                    @foreach ($menu as $item)
                        @if ($item->section_id == $section->section_id)
                            <div class="row w-100">
                                <div class="col w-100">
                                    <label type="text" id="name" value="name"
                                        style="margin-top:10px; font-weight:bold; font-size:20pt">{{ $item->name }}</label>
                                </div>
                                <div class="col-md-auto w-50 text-right">
                                    <p style="font-size: 15pt; margin-top:10px; font-weight:bold; font-size:20pt"
                                        name="price" id="price" value="price">
                                        ${{ $item->price }}
                                        <a href="/login" role="button"
                                            class="btn btn-primary" style="background-color:orange; border:none; font-weight:bold">Sign-in To Order!</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            </table>
        @endforeach
    </div>
</div>
@endsection