<h1>
    Choose a city.
</h1>

@if ($errors->any())
    <div style="color:red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/show">
    <label for="city">Choose a city:</label>
    <select name="city" id="city">
        @foreach ($cities as $city)
            <option value={{$city}}>{{$city}}</option>
        @endforeach
    </select>
    <input type="submit" value="Submit">
</form>
