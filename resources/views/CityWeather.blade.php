<h1>
    Weather forecast for the next 5 days in {{$city}}.
</h1>

<div>
    <ol>
        @foreach ($forecasts as $forecast)
            <li> Min Temp: {{ $forecast->getMinTemperature() }} / Max Temp: {{ $forecast->getMaxTemperature() }} </li>
        @endforeach
    </ol>
</div>
